<?php

namespace App\Http\Controllers;

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

        // Récupérer les tickets liés aux applications de l'entreprise connectée
        $tickets = Ticket::whereHas('application', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->get();

        // Retourner la vue avec les tickets récupérés
        return view('tickets.index', compact('tickets','company'));
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
