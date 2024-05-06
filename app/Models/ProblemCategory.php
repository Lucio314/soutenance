<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'application_id',
        'code_priority'
    ];

    // Relation avec l'application
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }
    public function problem_priority()
    {
        return $this->belongsTo(ProblemPriority::class, 'code_priority', 'code_priority');
    }
    public function technicians()
    {
        return $this->belongsToMany(Technician::class, 'gerers', 'problem_category_id', 'technician_id');
    }
    public function gerers()
    {
        return $this->hasMany(Gerer::class, 'proble_category_id');
    }
}
