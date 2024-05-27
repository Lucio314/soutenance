<?php

namespace App\Http\Controllers;

use App\Models\Gerer;
use App\Models\Technician;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer l'entreprise de l'utilisateur connecté
        $company = Auth::user()->company;
        if ($company !== null) {

            // Récupérer les tickets liés aux applications de l'entreprise connectée
            $tickets = Ticket::whereHas('application', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            })->get();
        }
        // Retourner la vue avec les tickets récupérés
        return view('tickets.index', compact('tickets', 'company'));
    }
    public function myindex(Technician $technician)
    {
        $technician = Auth::user()->technician;
        // dd($technician);
        $problemCategoriesIds = Gerer::where('technician_id', $technician->id)
            ->pluck('problem_category_id')
            ->toArray();

        $tickets = Ticket::whereHas('problemCategory', function ($query) use ($problemCategoriesIds) {
            $query->whereIn('id', $problemCategoriesIds);
        })->get();

        // Retourner la vue avec les tickets filtrés
        return view('tickets.myindex', compact('tickets'));
    }
    public function transfer(Request $request, $ticketId)
    {
        $request->validate([
            'technician_id' => 'required|exists:technicians,id',
        ]);

        $ticket = Ticket::findOrFail($ticketId);
        $currentTechnician = auth()->user()->technician;

        $ticket->technicians()->updateExistingPivot($currentTechnician->id, [
            'transferred_to' => $request->technician_id,
        ]);

        return redirect()->back()->with('success', 'Ticket transféré avec succès.');
    }
    public function handleTicket(Request $request, $ticketId, $technicianId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $technician = Technician::findOrFail($technicianId);

        // Vérifier si le technicien est autorisé à traiter ce ticket
        $problemCategoriesIds = Gerer::where('technician_id', $technician->id)
            ->pluck('problem_category_id')
            ->toArray();

        if (!in_array($ticket->problem_category_id, $problemCategoriesIds)) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized to handle this ticket']);
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
        $ticket->status = 'terminé';
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
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

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
