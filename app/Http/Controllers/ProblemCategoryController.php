<?php

namespace App\Http\Controllers;

use App\Models\ProblemCategory;
use App\Models\ProblemPriority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProblemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer l'entreprise de l'utilisateur connecté
        $company = Auth::user()->company;

        // Récupérer toutes les catégories de problème liées à l'application de l'entreprise de l'utilisateur authentifié
        $categories = ProblemCategory::with('application')
            ->whereHas('application', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            })
            ->get();

        return view('problem_categories.index', compact('categories', 'company'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $applications = Auth::user()->company->applications;
        $priorities = ProblemPriority::all();
        // Afficher le formulaire pour créer une nouvelle catégorie de problème
        return view('problem_categories.create', compact('applications',  'priorities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'code_priority' => 'nullable|string|max:255',
            'application_id' => 'required|exists:applications,id' // Assure que l'application existe
        ]);

        // Créer une nouvelle catégorie de problème avec les données validées
        $category = ProblemCategory::create($validatedData);

        // Rediriger vers la page de détails de la nouvelle catégorie de problème
        return redirect()->route('problem_categories.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(ProblemCategory $problem_category)
    {

        // Afficher les détails de la catégorie de problème spécifiée
        return view('problem_categories.show', compact('problemCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProblemCategory $problem_category)
    {

        $applications = Auth::user()->company->applications;
        $priorities = ProblemPriority::all();

        // Afficher le formulaire pour modifier la catégorie de problème spécifiée
        return view('problem_categories.edit', compact('applications', 'priorities', 'problem_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProblemCategory $problem_category)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'code_priority' => 'required|string|max:255',
        ]);

        // Mettre à jour les données de la catégorie de problème avec les données validées
        $problem_category->update($validatedData);

        // Rediriger vers la page de détails de la catégorie de problème mise à jour
        return redirect()->route('problem_categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProblemCategory $problem_category)
    {
        // Supprimer la catégorie de problème spécifiée de la base de données
        $problem_category->delete();

        // Rediriger vers la liste des catégories de problème avec un message de succès
        return redirect()->route('problem_categories.index')->with('success', 'Catégorie de problème supprimée avec succès.');
    }
}
