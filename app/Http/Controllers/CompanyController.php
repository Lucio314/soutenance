<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Company;
use App\Models\ProblemCategory;
use App\Models\Technician;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retourne une vue avec la liste des entreprises
        return view('companies.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retourne une vue pour créer une nouvelle entreprise
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Valider les données du formulaire
        $validatedData = $request->validate([
            'code' => 'required|string|max:255',
            'cpn_name' => 'required|string|max:255',
            'cpn_email' => 'required|email|unique:companies,cpn_email',
            'company_phone' => 'required|string|max:255',
            'cpn_address' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        // Créer une nouvelle instance de Company avec les données validées
        $company = new Company($validatedData);

        // dd($company);

        $company->save();


        // Rediriger vers la page de détails de l'entreprise nouvellement créée
        return redirect()->route('companies.dashboard');
    }

    public function dashboard(Company $company)
    {
        // Initialisation des variables par défaut
        $ticketEvolution = [
            'labels' => [],
            'datasets' => []
        ];
        $technicianStats = [
            'labels' => [],
            'datasets' => []
        ];
        $issueStats = [
            'labels' => [],
            'datasets' => []
        ];
        $applicationStats = [
            'labels' => [],
            'datasets' => []
        ];
        $company = Auth::user()->company;
     //   dd($company->is_active);
        if ($company->is_active) {
            // Évolution des tickets (nouveaux, résolus, terminés) au cours de l'année
            $tickets = Ticket::selectRaw('MONTH(created_at) as month, status, COUNT(*) as count')
                ->whereHas('application', function ($query) use ($company) {
                    $query->where('company_id', $company->id);
                })
                ->whereYear('created_at', date('Y'))
                ->groupBy('month', 'status')
                ->orderBy('month')
                ->get();

            $labels = [];
            $newTickets = [];
            $resolvedTickets = [];
            $closedTickets = [];
            $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#8BC34A', '#FF5722', '#009688', '#795548', '#9C27B0', '#2496F3', '#CDDC39', '#607D8B'];

            for ($i = 1; $i <= 12; $i++) {
                $month = date('F', mktime(0, 0, 0, $i, 1));
                $labels[] = $month;
                $newCount = 0;
                $resolvedCount = 0;
                $closedCount = 0;

                foreach ($tickets as $ticket) {
                    if ($ticket->month == $i) {
                        if ($ticket->status == 'Nouveau') {
                            $newCount = $ticket->count;
                        } elseif ($ticket->status == 'Résolu') {
                            $resolvedCount = $ticket->count;
                        } elseif ($ticket->status == 'Terminé') {
                            $closedCount = $ticket->count;
                        }
                    }
                }

                $newTickets[] = $newCount;
                $resolvedTickets[] = $resolvedCount;
                $closedTickets[] = $closedCount;
            }

            $ticketEvolution = [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Nouveaux Tickets',
                        'data' => $newTickets,
                        'backgroundColor' => '#FF6384',
                        'borderWidth' => 1
                    ],
                    [
                        'label' => 'Tickets en cours',
                        'data' => $resolvedTickets,
                        'backgroundColor' => '#36A2EB',
                        'borderWidth' => 1
                    ],
                    [
                        'label' => 'Tickets Terminés',
                        'data' => $closedTickets,
                        'backgroundColor' => '#FFCE56',
                        'borderWidth' => 1
                    ]
                ]
            ];

            // // Techniciens avec le plus de tickets résolus
            // $technicians = Technician::whereHas('company', function ($query) use ($company) {
            //     $query->where('id', $company->id);
            // })->withCount(['tickets as tickets_resolved_count' => function ($query) {
            //     $query->where('status', 'Terminé');
            // }])->get();

            // $techNames = $technicians->pluck('user.name');
            // $techData = $technicians->pluck('tickets_resolved_count');

            // $technicianStats = [
            //     'labels' => $techNames,
            //     'datasets' => [
            //         [
            //             'label' => 'Tickets résolus',
            //             'data' => $techData,
            //             'backgroundColor' => $colors,
            //             'borderWidth' => 1
            //         ]
            //     ]
            // ];

            // Problèmes les plus courants
            $issues = ProblemCategory::selectRaw('name, COUNT(*) as count')
                ->whereHas('application', function ($query) use ($company) {
                    $query->where('company_id', $company->id);
                })
                ->groupBy('name')
                ->orderBy('count', 'desc')
                ->take(5)
                ->get();

            $issueTypes = $issues->pluck('name');
            $issueData = $issues->pluck('count');

            $issueStats = [
                'labels' => $issueTypes,
                'datasets' => [
                    [
                        'label' => 'Nombre de problèmes',
                        'data' => $issueData,
                        'backgroundColor' => $colors,
                        'borderWidth' => 1
                    ]
                ]
            ];

            // Problèmes sur les applications
            $applications = Application::withCount(['problemCategories' => function ($query) use ($company) {
                $query->whereHas('application', function ($query) use ($company) {
                    $query->where('company_id', $company->id);
                });
            }])
                ->where('company_id', $company->id)
                ->orderBy('problem_categories_count', 'desc')
                ->take(5)
                ->get();

            $appNames = $applications->pluck('app_name');
            $appData = $applications->pluck('problem_categories_count');

            $applicationStats = [
                'labels' => $appNames,
                'datasets' => [
                    [
                        'label' => 'Problèmes sur les applications',
                        'data' => $appData,
                        'backgroundColor' => $colors,
                        'borderWidth' => 1
                    ]
                ]
            ];
        }

        return view('companies.dashboard', [
            'company' => $company,
            'ticketEvolution' => $ticketEvolution,
            // 'technicianStats' => $technicianStats,
            'issueStats' => $issueStats,
            'applicationStats' => $applicationStats
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {

        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {

        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            // Ajoutez ici les autres champs à valider
        ]);

        // Mettre à jour les données de l'entreprise avec les données validées
        $company->update($validatedData);

        // Rediriger vers la page de détails de l'entreprise mise à jour
        return redirect()->route('companies.show', $company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // Supprimer l'entreprise spécifiée de la base de données
        $company->delete();

        // Rediriger vers la liste des entreprises avec un message de succès
        return redirect()->route('companies.index')->with('success', 'Entreprise supprimée avec succès.');
    }
}
