<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewTicketMail;
use App\Models\Ticket;
use App\Models\Application;
use App\Models\Comment;
use App\Models\ProblemCategory;
use App\Models\Technician;
use App\Notifications\NewTicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function create(Request $request)
    {
        $apiKey = $request->header('api_key');
        $application = Application::where('unique_code', $apiKey)->first();

        if (!$application) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $problemCategories = $application->problemCategories;

        return response()->json(['problemCategories' => $problemCategories], 200);
    }



    public function store(Request $request)
    {
        // Définir les règles de validation
        $rules = [
            'client_email' => 'required|email',
            'problem_category_id' => 'required|integer',
            'object' => 'required|string|max:255',
            'content' => 'required|string',
            'uploaded_files.*' => 'file|max:2048'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $apiKey = $request->header('api_key');
        $application = Application::where('unique_code', $apiKey)->first();

        if (!$application) {
            return response()->json(['error' => 'Application non définie'], 400);
        }

        $application_id = $application->id;

        $ticket = new Ticket();
        $ticket->client_email = $request->input('client_email');
        $ticket->problem_category_id = $request->input('problem_category_id');
        $ticket->application_id = $application_id;
        $ticket->object = $request->input('object');
        $ticket->content = $request->input('content');

        $uploadedFilesPaths = [];

        if ($request->hasFile('uploaded_files')) {
            foreach ($request->file('uploaded_files') as $image) {
                $path = $image->store('public/images');
                $uploadedFilesPaths[] = $path;
            }
        }

        // Enregistrer les chemins des fichiers en JSON

        $pathJson = json_encode($uploadedFilesPaths);
        $ticket->uploaded_files = $pathJson;

        $ticket->save();

        // Obtenez les techniciens concernés par la catégorie de problème
        $technicians = Technician::whereHas('problemCategories', function ($query) use ($ticket) {
            $query->where('problem_categories.id', $ticket->problem_category_id);
        })->get();

        // Envoyez les e-mails aux techniciens
        foreach ($technicians as $technician) {
            $user = $technician->user; // Obtenez l'utilisateur lié au technicien
            if ($user && $user->email) {
                Mail::to($user->email)->send(new NewTicketMail($ticket));
            }
        }

        return response()->json(['message' => 'Ticket créé avec succès', 'ticket' => $ticket]);
    }


    /**
     * Display the specified ticket.
     *
     * @param Ticket $ticket
     * @return \Illuminate\Http\Response
     */


    public function show(Request $request)
    {
        $email = $request->header('client_email');
        $tickets = Ticket::where('client_email', $email)
            ->whereIn('status', ['Nouveau', 'En cours'])
            ->where('object', 'plainte')
            ->orderBy('created_at', 'desc')
            ->get();
        $nbre_total_ticket = Ticket::where('client_email', $email)->count();
        $nbre_suggestion = Ticket::where('client_email', $email)->where('object', 'Suggestion')->count();
        $nbre_en_cours = Ticket::where('client_email', $email)->where('status', 'En cours')->count();

        if ($tickets) {
            return response()->json([
                'nombre_total_ticket' => $nbre_total_ticket,
                'nombre_suggestion' => $nbre_suggestion,
                'nombre_en_cours' => $nbre_en_cours,
                'tickets' => $tickets,
            ], 200);
        } else {
            return response()->json([
                'nombre_total_ticket' => $nbre_total_ticket,
                'nombre_suggestion' => $nbre_suggestion,
                'nombre_en_cours' => $nbre_en_cours,
                'tickets' => null,
            ], 200);
        }
    }

    public function storeComment(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'body' => 'required|string',
            'is_technician' => 'required|boolean',
        ]);

        // Récupérer l'ID du ticket et l'e-mail du client à partir des headers
        $ticketId = $request->header('ticket_id');
        $clientEmail = $request->header('client_email');

        // Vérifier que l'ID du ticket est présent et valide
        if (!$ticketId || !is_numeric($ticketId)) {
            return response()->json(['error' => 'ID de ticket invalide dans l\'en-tête'], 400);
        }

        // Trouver le ticket par son ID
        $ticket = Ticket::findOrFail($ticketId);

        // Créer un nouveau commentaire
        $comment = new Comment();
        $comment->body = $request->input('body');
        $comment->is_technician = $request->input('is_technician');
        $comment->client_email = $clientEmail;

        // Associer le commentaire au ticket
        $ticket->comments()->save($comment);

        // Réponse JSON en cas de succès
        return response()->json(['message' => 'Commentaire ajouté avec succès'], 201);
    }
    /**
     * Remove the specified ticket from storage.
     *
     * @param Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        $ticket->delete();
        return response()->json(['message' => 'Ticket deleted successfully'], 200);
    }
}
