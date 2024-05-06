<?php

namespace App\Http\Controllers;

use App\Models\ProblemCategory;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Gerer;


class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Auth::user()->company;
        // Récupérer tous les techniciens avec leurs catégories de problèmes associées
        $technicians = Technician::with('problemCategories', 'company')->where('company_id', $company->id)->get();
        // Retourner la vue avec les techniciens
        return view('technicians.index', compact('technicians', 'company'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Auth::user()->company;
        $problem_categories = ProblemCategory::all();
        // Retourner la vue pour créer un nouveau technicien
        return view('technicians.create', compact('company', 'problem_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'problem_category_id' => 'required|array', // Les catégories doivent être un tableau
            'problem_category_id.*' => 'exists:problem_categories,id', // Chaque catégorie doit exister
            'company_id' => 'required|exists:companies,id',
        ]);

        // Créer un nouveau technicien avec les données validées
        $technician = Technician::create([
            'user_id' => $validatedData['user_id'],
            'company_id' => $validatedData['company_id'],
        ]);

        // Attacher les catégories de problèmes au technicien
        $technician->problemCategories()->attach($validatedData['problem_category_id']);

        // Rediriger avec un message de succès
        return redirect()->route('technicians.index')->with('success', 'Technicien créé avec succès.');
    }
    public function dashboard()
    {

        return view('technicians.dashboard');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function show(Technician $technician)
    {
        // Retourner la vue avec le détail du technicien
        return view('technicians.show', compact('technician'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function edit(Technician $technician)
    {

        $company = Auth::user()->company;

        $problem_categories = ProblemCategory::all();
        // Retourner la vue pour éditer le technicien
        return view('technicians.edit', compact('technician', 'company', 'problem_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technician  $technician
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Technician $technician)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'problem_category_id' => 'required|array',
            'problem_category_id.*' => 'exists:problem_categories,id',
        ]);

        // Mettre à jour les données du technicien avec les données validées
        //  $technician->update($validatedData);

        // Mettre à jour les catégories de problèmes associées au technicien dans la table pivot "gerers"
        $technician->problemCategories()->sync($validatedData['problem_category_id']);

        // Rediriger avec un message de succès
        return redirect()->route('technicians.index')->with('success', 'Technicien mis à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technician  $technician
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technician $technician)
    {
        // Supprimer le technicien de la base de données
        $technician->delete();

        // Rediriger avec un message de succès
        return redirect()->route('technicians.index')->with('success', 'Technicien supprimé avec succès.');
    }
}
