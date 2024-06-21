<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function userChart()
    {
        // Sélectionner le mois et le nombre d'utilisateurs créés pour chaque mois de l'année en cours
        $users = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Initialiser les tableaux pour les labels (mois) et les données (nombre d'utilisateurs)
        $labels = [];
        $data = [];
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#8BC34A', '#FF5722', '#009688', '#795548', '#9C27B0', '#2496F3', '#CDDC39', '#607D8B'];

        // Parcourir les 12 mois de l'année
        for ($i = 1; $i <= 12; $i++) {
            // Obtenir le nom du mois
            $month =  date('F', mktime(0, 0, 0, $i, 1));
            // Initialiser le compteur pour le nombre d'utilisateurs
            $count = 0;
            // Parcourir les résultats de la requête pour trouver le nombre d'utilisateurs pour ce mois
            foreach ($users as $user) {
                if ($user->month == $i) {
                    $count = $user->count;
                    break;
                }
            }
            // Ajouter le mois et le nombre d'utilisateurs aux tableaux correspondants
            $labels[] = $month;
            $data[] = $count;
        }

        // Créer le jeu de données pour le graphique
        $datasets = [
            'label' => 'Users',
            'data' => $data,
            'backgroundColor'=> $colors,
            'borderWidth'=>1
        ];

        // Retourner la vue avec les données du graphique
        return view('charts', compact('labels','datasets'));
    }
}
