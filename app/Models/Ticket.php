<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_email',
        'application_id',
        'category_id',
        'object',
        'content',
        'status',
        // 'company_id',
        'uploaded_files',
    ];

    // Relation avec l'application
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // Relation avec la catégorie de problème
    public function problemCategory()
    {
        return $this->belongsTo(ProblemCategory::class, 'problem_category_id');
    }
<<<<<<< HEAD
    public function travaillers()
    {
        return $this->hasMany(Travailler::class);
    }
    // Relation avec les techniciens à travers la table pivot Travailler
    public function technicians()
    {
        return $this->belongsToMany(Technician::class, 'travaillers','ticket_id','technician_id')
            ->withPivot('transferred_to', 'created_at', 'updated_at')
            ->withTimestamps();
    }
=======

    // Relation avec la société
    // public function company()
    // {
    //     return $this->belongsTo(Company::class);
    // }
>>>>>>> 7300c5caa7056006324d5c9a26a6f8206b730999
}
