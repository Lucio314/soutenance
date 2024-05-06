<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les applications de la company actuellement connectée
        $company = Auth::user()->company;
        $applications = Application::where("company_id", $company->id)->with('problemCategories', 'company');

        // Retourner la vue avec les applications
        return view('applications.index', compact('company', 'applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $company = Auth::user()->company;
        // Retourner la vue pour créer une nouvelle application
        return view('applications.create', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->all();

        // Ajouter l'ID de la company actuellement connectée
        $validatedData['company_id'] = Auth::user()->company->id;

        // Créer une nouvelle application avec les données validées
        $application = Application::create($validatedData);

        // Rediriger vers la page de détails de la nouvelle application
        return redirect()->route('applications.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        // Afficher les détails de l'application spécifiée
        return view('applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        // Afficher le formulaire pour modifier l'application spécifiée
        return view('applications.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        // Valider les données du formulaire
        $validatedData = $request->all();

        // Mettre à jour les données de l'application avec les données validées
        $application->update($validatedData);

        // Rediriger vers la page de détails de l'application mise à jour
        return redirect()->route('applications.show', $application);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
       
        // Supprimer l'application spécifiée de la base de données
        $application->delete();

        // Rediriger vers la liste des applications avec un message de succès
        return redirect()->route('applications.index')->with('success', 'Application supprimée avec succès.');
    }
}
