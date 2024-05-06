<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer tous les techniciens et les afficher dans une vue
        $technicians = Technician::all();
        return view('technicians.index', compact('technicians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Afficher le formulaire pour créer un nouveau technicien
        return view('technicians.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:technicians,email',
            // Ajouter d'autres règles de validation au besoin
        ]);

        // Créer un nouveau technicien avec les données validées
        $technician = Technician::create($validatedData);

        // Rediriger vers la page de détails du nouveau technicien
        return redirect()->route('technicians.show', $technician);
    }

    /**
     * Display the specified resource.
     */
    public function show(Technician $technician)
    {
        // Afficher les détails du technicien spécifié
        return view('technicians.show', compact('technician'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Technician $technician)
    {
        // Afficher le formulaire pour modifier le technicien spécifié
        return view('technicians.edit', compact('technician'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technician $technician)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:technicians,email,' . $technician->id,
            // Ajouter d'autres règles de validation au besoin
        ]);

        // Mettre à jour les données du technicien avec les données validées
        $technician->update($validatedData);

        // Rediriger vers la page de détails du technicien mis à jour
        return redirect()->route('technicians.show', $technician);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $technician)
    {
        // Supprimer le technicien spécifié de la base de données
        $technician->delete();

        // Rediriger vers la liste des techniciens avec un message de succès
        return redirect()->route('technicians.index')->with('success', 'Technicien supprimé avec succès.');
    }
}
