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
        return $this->belongsTo(User::class,'user_id');
    }

    // Relation avec la catégorie de problème
    public function problemCategory()
    {
        return $this->belongsTo(ProblemCategory::class, 'problem_category_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'technician_id', 'id');
    }
}
