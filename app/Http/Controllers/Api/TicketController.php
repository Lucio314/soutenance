<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Application;
use App\Models\ProblemCategory;
use Illuminate\Http\Request;
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
        // Valider les données du formulaire
        $validated = $request->validate([
            'client_email' => 'required|email',
            'problem_category_id' => 'required|integer',
            'object' => 'required|string|max:255',
            'content' => 'required|string',
            'uploaded_files.*' => 'file|max:2048' // Limite de taille de fichier à 2 Mo par fichier
        ]);

        // Créer le ticket
        $ticket = new Ticket();
        $ticket->client_email = $validated['client_email'];
        $ticket->problem_category_id = $validated['problem_category_id'];
        $ticket->object = $validated['object'];
        $ticket->content = $validated['content'];
        $ticket->save();

        // Gérer les fichiers joints
        if ($request->hasFile('uploaded_files')) {
            foreach ($request->file('uploaded_files') as $file) {
                $path = $file->store('uploads');
                // Enregistrez le chemin du fichier ou traitez le fichier selon vos besoins
            }
        }

        return response()->json(['message' => 'Ticket créé avec succès']);
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



