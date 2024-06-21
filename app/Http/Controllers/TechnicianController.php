<?php

namespace App\Http\Controllers;

use App\Models\ProblemCategory;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Gerer;
use App\Models\Ticket;
use App\Models\Travailler;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TechnicianController extends Controller
{
    public function acceptTicket($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        $technician = auth()->user()->technician;

        $travailler = Travailler::where('ticket_id', $ticket_id)
            ->where('transferred_to', $technician->id)
            ->firstOrFail();

        if ($travailler) {
            $travailler->update(['transferred_to' => null]);
            return redirect()->route('technician.dashboard')->with('success', 'Ticket accepted successfully.');
        } else {
            return redirect()->route('technician.dashboard')->with('error', 'Unable to accept ticket.');
        }
    }

    public function declineTicket($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        $technician = auth()->user()->technician;

        $travailler = Travailler::where('ticket_id', $ticket_id)
            ->where('transferred_to', $technician->id)
            ->firstOrFail();

        if ($travailler) {
            $travailler->delete();
            $ticket->update(['status' => 'new']);
            return redirect()->route('technician.dashboard')->with('success', 'Ticket declined successfully.');
        } else {
            return redirect()->route('technician.dashboard')->with('error', 'Unable to decline ticket.');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Auth::user()->company;
        // Récupérer tous les techniciens avec leurs catégories de problèmes associées
        $technicians = Technician::with('problemCategories', 'company')->where('company_id', $company->id)->get();
        // Retourner la vue avec les techniciens
        return view('technicians.index', compact('technicians', 'company'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Auth::user()->company;

        // Supposons que chaque application a une relation avec ProblemCategory via une table intermédiaire
        // Et que l'entreprise a une relation avec ses applications.
        $problem_categories = ProblemCategory::whereHas('application', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->get();

        // Retourner la vue pour créer un nouveau technicien
        return view('technicians.create', compact('company', 'problem_categories'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['string', 'nullable'],
            'company_id' => ['nullable', 'exists:companies,id'],
            'problem_category_id' => ['nullable', 'array'],
            'problem_category_id.*' => ['nullable', 'exists:problem_categories,id'],
        ]);

        // Générer un mot de passe aléatoire
        $password = $request->password;

        // Créer un nouvel utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role
        ]);

        // Si le rôle de l'utilisateur est technicien, créer un technicien et l'associer aux catégories de problèmes
        if ($request->role == 'technician') {
            $technician = Technician::create([
                'user_id' => $user->id,
                'company_id' => $request->company_id,
            ]);

            // Enregistrer les relations entre le technicien et les catégories de problèmes
            if ($request->has('problem_category_id')) {
                foreach ($request->problem_category_id as $categoryId) {
                    Gerer::create([
                        'technician_id' => $technician->id,
                        'problem_category_id' => $categoryId,
                    ]);
                }
            }

            // Envoyer un e-mail avec le mot de passe au technicien
            Mail::send('emails.technician_welcome', ['user' => $user, 'password' => $password], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Bienvenue en tant que technicien');
            });

            return redirect()->route('technicians.index')->with('success', 'Technicien créé avec succès et e-mail envoyé.');
        }

        return redirect()->route('technicians.index')->with('success', 'Technicien créé avec succès.');
    }

    public function dashboard()
    {

        return view('technicians.dashboard');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function show(Technician $technician)
    {
        // Retourner la vue avec le détail du technicien
        return view('technicians.show', compact('technician'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function edit(Technician $technician)
    {

        $company = Auth::user()->company;

        $problem_categories = ProblemCategory::all();
        // Retourner la vue pour éditer le technicien
        return view('technicians.edit', compact('technician', 'company', 'problem_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technician  $technician
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Technician $technician)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'problem_category_id' => 'required|array',
            'problem_category_id.*' => 'exists:problem_categories,id',
        ]);

        // Mettre à jour les données du technicien avec les données validées
        //  $technician->update($validatedData);

        // Mettre à jour les catégories de problèmes associées au technicien dans la table pivot "gerers"
        $technician->problemCategories()->sync($validatedData['problem_category_id']);

        // Rediriger avec un message de succès
        return redirect()->route('technicians.index')->with('success', 'Technicien mis à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technician $technician)
    {
        // Supprimer le technicien de la base de données
        $technician->delete();

        // Rediriger avec un message de succès
        return redirect()->route('technicians.index')->with('success', 'Technicien supprimé avec succès.');
    }
}
