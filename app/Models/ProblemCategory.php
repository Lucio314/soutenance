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
    ];

    // Relation avec l'application
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
    public function problem_priority()
    {
        return $this->belongsTo(ProblemPriority::class, 'code_priority', 'code_priority');
    }
}
