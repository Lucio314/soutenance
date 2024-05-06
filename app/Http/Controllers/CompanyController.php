<?php

namespace App\Http\Controllers;

use App\Models\Company;
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

        return view('companies.dashboard', compact('company'));
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
