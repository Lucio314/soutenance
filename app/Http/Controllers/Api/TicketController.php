<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewTicketMail;
use App\Models\Ticket;
use App\Models\Application;
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

        $application = $request->attributes->get('application');
        // dd($application);
        if (!$application) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Récupérer les catégories de problèmes spécifiques à l'application
        $problemCategories = $application->problemCategories;




        // Récupérer toutes les catégories de problèmes
        $problemCategories = ProblemCategory::all();

        // Passer les données à la vue
        return view('tickets.create', compact('problemCategories'));
    }

    /**
     * Display a listing of the tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();
        return response()->json(['tickets' => $tickets], 200);
    }

    /**
     * Store a newly created ticket in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Définir les règles de validation
        $rules = [
            'client_email' => 'required|email',
            'problem_category_id' => 'required|integer',
            'object' => 'required|string|max:255',
            'content' => 'required|string',
            'uploaded_files.*' => 'file|max:2048' // Limite de taille de fichier à 2 Mo par fichier
        ];

        // Créer le validateur
        $validator = Validator::make($request->all(), $rules);

        // Vérifier si la validation échoue
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Récupérer l'application
        $application = $request->attributes->get('application');

        // Vérifier si l'application est définie
        if (!$application) {
            return response()->json(['error' => 'Application non définie'], 400);
        }

        $application_id = $application->id;

        // Créer le ticket
        $ticket = new Ticket();
        $ticket->client_email = $request->input('client_email');
        $ticket->problem_category_id = $request->input('problem_category_id');
        $ticket->application_id = $application_id; // Utiliser l'ID extrait du JSON
        $ticket->object = $request->input('object');
        $ticket->content = $request->input('content');

        $uploadedFiles = [];

        // Traitement des fichiers
        if ($request->hasFile('uploaded_files')) {
            foreach ($request->file('uploaded_files') as $file) {
                $path = $file->store('uploads', 'public');
                $uploadedFiles[] = $path;
            }
        }

        // Enregistrer les chemins des fichiers en JSON
        $ticket->uploaded_files = json_encode($uploadedFiles);

        // Enregistrer le ticket
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

        // Envoyez les notifications
       // Notification::send($technicians, new NewTicketNotification($ticket));

        return response()->json(['message' => 'Ticket créé avec succès', 'ticket' => $ticket]);

    }

    /**
     * Display the specified ticket.
     *
     * @param Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        return response()->json(['ticket' => $ticket], 200);
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
