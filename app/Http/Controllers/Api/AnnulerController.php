<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class AnnulerController extends Controller
{
    public function annuler(Request $request)
    {
        $id = $request->header('id');

        $ticket = Ticket::find($id);
        if ($ticket) {
            $ticket->status = 'Annuler';
            $ticket->save();

            return response()->json([
                'message' => 'ticket annulé',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Une erreur est survenue lors de l\'envoi',
            ], 500);
        }
    }
}
