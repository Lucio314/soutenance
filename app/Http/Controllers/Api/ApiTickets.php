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

class ApiTickets extends Controller
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
            // foreach ($request->file('uploaded_files') as $file) {
            //     $path = $file->store('uploads', 'public');
            //     $uploadedFilesPaths[] = $path;
            // }
            foreach ($request->file('uploaded_files') as $image) {
                $path = $image->store('public/images');
                $uploadedFilesPaths[] = $path;
            }
        }

        // Enregistrer les chemins des fichiers en JSON

        $pathJson = json_encode($uploadedFilesPaths);
        $ticket->uploaded_files = $pathJson;

        $ticket->save();

        return response()->json(['message' => 'Ticket créé avec succès', 'ticket' => $ticket]);
    }


    public function showTicket(Request $request)
    {
        $email = $request->header('client_email');
        $ticket = Ticket::where('client_email', $email)->orderBy('created_at', 'desc')->first();
        $nbre_total_ticket = Ticket::where('client_email', $email)->count();
        $nbre_suggestion = Ticket::where('client_email', $email)->where('object', 'Suggestion')->count();
        $nbre_en_cours = Ticket::where('client_email', $email)->where('status', 'En cours')->count();

        if ($ticket) {
            return response()->json([
                'nombre_total_ticket' => $nbre_total_ticket,
                'nombre_suggestion' => $nbre_suggestion,
                'nombre_en_cours' => $nbre_en_cours,
                'category' => $ticket->problemCategory->name,
                'ticket' => $ticket,
            ], 200);
        } else {
            return response()->json([
                'nombre_total_ticket' => $nbre_total_ticket,
                'nombre_suggestion' => $nbre_suggestion,
                'nombre_en_cours' => $nbre_en_cours,
                'category' => null,
                'ticket' => null,
            ], 200);
        }
    }
}
