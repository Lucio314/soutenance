<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'problem_category_id',
        'company_id'
    ];

    // Relation avec l'utilisateur
    public function user()
    {
<<<<<<< HEAD
        return $this->belongsTo(User::class, 'user_id');
=======
        return $this->belongsTo(User::class,'user_id');
>>>>>>> 7300c5caa7056006324d5c9a26a6f8206b730999
    }

    // Relation avec la catégorie de problème
    public function problemCategories()
    {
<<<<<<< HEAD
        return $this->belongsToMany(ProblemCategory::class, 'gerers', 'technician_id', 'problem_category_id');
=======
        return $this->belongsTo(ProblemCategory::class, 'problem_category_id');
>>>>>>> 7300c5caa7056006324d5c9a26a6f8206b730999
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function travaillers()
    {
        return $this->hasMany(Travailler::class, 'technician_id');
    }
    public function gerers()
    {
        return $this->hasMany(Gerer::class, 'technician_id');
    }
    public function tickets()
    {
        return $this->belongsToMany(Technician::class, 'travaillers',  'technician_id', 'ticket_id')
            ->withPivot('transferred_to') // Ajoutez d'autres colonnes pivot si nécessaire
            ->withTimestamps(); // Pour ajouter automatiquement les timestamps created_at et updated_at
    }
}
