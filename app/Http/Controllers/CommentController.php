<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $ticketId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $ticket = Ticket::findOrFail($ticketId);
        $comment = new Comment();
        $comment->ticket_id = $ticketId;
        $comment->body = $request->input('body');
        $comment->is_technician = true; // Marquer le commentaire comme étant du technicien
        $comment->client_email = $ticket->client_email;

        // Récupérer l'ID du technicien actuellement authentifié
        $comment->technician_id = Auth::user()->technician->id;

        $comment->save();

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
