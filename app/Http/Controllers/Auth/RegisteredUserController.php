<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Gerer; // Importer le modèle Gerer
use App\Models\Technician;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.index');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'], // Ajout de la validation pour le rôle
            'company_id' => ['required', 'exists:companies,id'], // Validation de l'existence de l'ID de la société
            'problem_category_id' => ['required', 'array'], // Les catégories doivent être un tableau
            'problem_category_id.*' => ['exists:problem_categories,id'], // Chaque catégorie doit exister
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        if ($request->role == 'technician') {
            $technician = Technician::create([
                'user_id' => $user->id,
                'company_id' => $request->company_id,
            ]);

            // Enregistrer les relations entre le technicien et les catégories de problèmes
            foreach ($request->problem_category_id as $categoryId) {
                Gerer::create([
                    'technician_id' => $technician->id,
                    'problem_category_id' => $categoryId,
                ]);
            }

            return redirect()->route('technicians.index')->with('success', 'Technicien créé avec succès.');
        }

        Auth::login($user);

        return redirect()->route('companies.create');
    }
}
