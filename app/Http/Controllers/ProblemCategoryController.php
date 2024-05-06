<?php

namespace App\Http\Controllers;

use App\Models\ProblemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProblemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = Auth::user()->company;
        // Récupérer toutes les catégories de problème liées à l'application de la société de l'utilisateur authentifié
        $categories = ProblemCategory::whereHas('application', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->get();
        return view('problem_categories.index', compact('categories', 'company'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Afficher le formulaire pour créer une nouvelle catégorie de problème
        return view('problem_categories.create');
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
        return redirect()->route('problem_categories.show', $category);
    }


    /**
     * Display the specified resource.
     */
    public function show(ProblemCategory $problemCategory)
    {
        // Afficher les détails de la catégorie de problème spécifiée
        return view('problem_categories.show', compact('problemCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProblemCategory $problemCategory)
    {
        // Afficher le formulaire pour modifier la catégorie de problème spécifiée
        return view('problem_categories.edit', compact('problemCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProblemCategory $problemCategory)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'code_priority' => 'nullable|string|max:255',
        ]);

        // Mettre à jour les données de la catégorie de problème avec les données validées
        $problemCategory->update($validatedData);

        // Rediriger vers la page de détails de la catégorie de problème mise à jour
        return redirect()->route('problem_categories.show', $problemCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProblemCategory $problemCategory)
    {
        // Supprimer la catégorie de problème spécifiée de la base de données
        $problemCategory->delete();

        // Rediriger vers la liste des catégories de problème avec un message de succès
        return redirect()->route('problem_categories.index')->with('success', 'Catégorie de problème supprimée avec succès.');
    }
}
