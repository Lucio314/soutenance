<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Gerer;
use App\Models\ProblemCategory;
use App\Models\ProblemPriority;
use App\Models\Technician;
use App\Models\Ticket;
use App\Notifications\TicketTransferred;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketAssigned;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // Récupérer l'entreprise de l'utilisateur connecté
        $company = Auth::user()->company;

        if ($company !== null) {
            // Construire la requête de base pour les tickets liés aux applications de l'entreprise connectée
            $ticketsQuery = Ticket::whereHas('application', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            });

            // Filtrer par catégorie de problème si une catégorie est sélectionnée
            if ($request->filled('category')) {
                $ticketsQuery->where('problem_category_id', $request->category);
            }

            // Filtrer par application si une application est sélectionnée
            if ($request->filled('application')) {
                $ticketsQuery->where('application_id', $request->application);
            }

            // Récupérer les tickets correspondant aux critères de filtrage
            $tickets = $ticketsQuery->paginate(10);

            // Récupérer les catégories de problèmes associées aux applications de l'entreprise
            $problemCategories = ProblemCategory::whereHas('application', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            })->get();

            // Récupérer les applications de l'entreprise
            $applications = Application::where('company_id', $company->id)->get();
        } else {
            $tickets = collect(); // Une collection vide si aucune entreprise n'est trouvée
            $problemCategories = collect(); // Une collection vide si aucune entreprise n'est trouvée
            $applications = collect(); // Une collection vide si aucune entreprise n'est trouvée
        }

        // Retourner la vue avec les tickets et les catégories de problèmes récupérés
        return view('tickets.index', compact('tickets', 'company', 'problemCategories', 'applications'));
    }


    public function myindex(Request $request)
    {
        $technician = Auth::user()->technician;

        // Récupérer les IDs des catégories de problèmes que le technicien gère
        $problemCategoriesIds = Gerer::where('technician_id', $technician->id)
            ->pluck('problem_category_id')
            ->toArray();

        // Construire la requête pour récupérer les tickets
        $query = Ticket::whereHas('problemCategory', function ($query) use ($problemCategoriesIds) {
            $query->whereIn('id', $problemCategoriesIds);
        });

        // Filtrer par priorité si le paramètre est présent dans la requête
        if ($request->has('priority') && $request->priority != '') {
            $query->whereHas('problemCategory.problem_priority', function ($q) use ($request) {
                $q->where('code_priority', $request->priority);
            });
        }

        // Exclure les tickets sur lesquels le technicien a déjà travaillé
        $query->whereDoesntHave('technicians', function ($q) use ($technician) {
            $q->where('technician_id', $technician->id);
        });

        // Obtenir les tickets filtrés
        $tickets = $query->get();

        // Récupérer les priorités disponibles
        $priorities = ProblemPriority::all();

        // Retourner la vue avec les tickets filtrés et les priorités
        return view('tickets.myindex', compact('tickets', 'priorities'));
    }

    public function verrouillerEnMasse(Request $request)
    {
        $ticketIds = $request->input('ticket_ids', []);
        if (!empty($ticketIds)) {
            Ticket::whereIn('id', $ticketIds)
                ->where('status', 'Nouveau')
                ->update(['status' => 'En cours']);
        }

        return redirect()->route('tickets.myindex')->with('success', 'Les tickets sélectionnés ont été verrouillés avec succès.');
    }


    public function show($id)
    {
        // Récupérer le ticket avec ses relations nécessaires
        $ticket = Ticket::with(['application', 'problemCategory'])->findOrFail($id);

        // Récupérer tous les techniciens
        $technicians = Technician::all();

        // Passer le ticket et les techniciens à la vue
        return view('tickets.show', compact('ticket', 'technicians'));
    }

    public function transfer(Request $request, $id)
    {
        $request->validate([
            'technician_id' => 'required|exists:technicians,id',
        ]);

        $ticket = Ticket::findOrFail($id);
        $technician = Technician::findOrFail($request->technician_id);
        $currentTechnician = Auth::user()->technician;

        // Vérifier que le technicien connecté est déjà en train de travailler sur le ticket
        if (!$ticket->technicians->contains($currentTechnician)) {
            return redirect()->route('tickets.show', $ticket->id)->with('error', 'Vous ne travaillez pas sur ce ticket.');
        }

        // Vérifier si le technicien de destination est disponible
        if ($technician->isAvailable()) {
            // Transférer le ticket
            $ticket->technicians()->attach($technician->id, ['transferred_to' => $technician->id]);

            // Notifier le technicien
            $technician->notify(new TicketTransferred($ticket));

            return redirect()->route('tickets.show', $ticket->id)->with('success', 'Ticket transféré avec succès.');
        } else {
            return redirect()->route('tickets.show', $ticket->id)->with('error', 'Le technicien n\'est pas disponible.');
        }
    } // Assurez-vous d'importer le mailable approprié


    public function handleTicket(Request $request, $ticketId, $technicianId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $technician = Technician::findOrFail($technicianId);

        // Vérifier si le technicien est autorisé à traiter ce ticket
        $problemCategoriesIds = Gerer::where('technician_id', $technician->id)
            ->pluck('problem_category_id')
            ->toArray();

        if (!in_array($ticket->problem_category_id, $problemCategoriesIds)) {
            return redirect()->back()->withErrors(['error' => 'Non autorisé à traiter ce ticket.']);
        }

        // Mettre à jour le statut du ticket
        $ticket->status = 'En cours';
        $ticket->save();

        // Vérifier si une entrée existante dans Travailler doit être mise à jour ou créée
        $existingEntry = $technician->travaillers()->where('ticket_id', $ticket->id)->first();
        if ($existingEntry) {
            $existingEntry->transferred_to = null;
            $existingEntry->save();
        } else {
            // Enregistrer les détails du traitement dans la table pivot Travailler
            $technician->travaillers()->create([
                'ticket_id' => $ticket->id,
                'transferred_to' => null, // Aucun transfert
            ]);
        }

        // Envoyer un email au client
        if ($ticket->client && $ticket->client->email) {
            $clientEmail = $ticket->client->email; // Assurez-vous que la relation 'client' est définie dans le modèle Ticket
            Mail::to($clientEmail)->send(new TicketAssigned($ticket, $technician));
        }

        return redirect()->route('tickets.show', $ticketId)->with('success', 'Ticket en cours de traitement par le technicien.');
    }



    /**
     * Close a ticket by a technician.
     */
    public function closeTicket(Request $request, $ticketId, $technicianId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $technician = Technician::findOrFail($technicianId);

        // Vérifier si le technicien est autorisé à traiter ce ticket
        $problemCategoriesIds = Gerer::where('technician_id', $technician->id)
            ->pluck('problem_category_id')
            ->toArray();

        if (!in_array($ticket->problem_category_id, $problemCategoriesIds)) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized to close this ticket']);
        }

        // Mettre à jour le statut du ticket
        $ticket->status = 'Terminé';
        $ticket->save();

        // Enregistrer les détails de la clôture dans la table pivot Travailler
        $existingEntry = $technician->travaillers()->where('ticket_id', $ticket->id)->first();
        if ($existingEntry) {
            $existingEntry->transferred_to = null;
            $existingEntry->save();
        } else {
            // Enregistrer les détails de la clôture dans la table pivot Travailler
            $technician->travaillers()->create([
                'ticket_id' => $ticket->id,
                'transferred_to' => null, // Aucun transfert
            ]);
        }

        return redirect()->route('tickets.show', $ticketId)->with('success', 'Ticket terminé par le technicien.');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Logic for displaying the create form
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'client_email' => 'required|email',
            'application_id' => 'required|exists:applications,id',
            'problem_category_id' => 'required|exists:problem_categories,id',
            'object' => 'required',
            'content' => 'required',
            'status' => 'required|in:Nouveau,Terminé,En cours',
            'uploaded_files' => 'nullable|array',
        ]);

        // Create a new ticket instance
        $ticket = Ticket::create($validatedData);

        // Redirect to the index page with a success message
        return redirect()->route('tickets.index')->with('success', 'Ticket créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        // Logic for displaying the edit form
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'client_email' => 'required|email',
            'application_id' => 'required|exists:applications,id',
            'problem_category_id' => 'required|exists:problem_categories,id',
            'object' => 'required',
            'content' => 'required',
            'status' => 'required|in:Nouveau,Terminé,En cours',
            'uploaded_files' => 'nullable|array',
        ]);

        // Update the ticket with the validated data
        $ticket->update($validatedData);

        // Redirect to the index page with a success message
        return redirect()->route('tickets.index')->with('success', 'Ticket mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        // Delete the ticket
        $ticket->delete();

        // Redirect to the index page with a success message
        return redirect()->route('tickets.index')->with('success', 'Ticket supprimé avec succès.');
    }
}
