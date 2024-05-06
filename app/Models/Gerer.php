<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gerer extends Model
{
    use HasFactory;
    protected $table = 'gerers';
    protected $primaryKey = ['technician_id', 'problem_category_id'];
    public $incrementing = false;

    protected $fillable = [
        'technician_id',
        'problem_category_id'
    ];

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id', 'id');
    }


    // Relation avec le modèle ProblemCategory
    public function problemCategory()
    {
        return $this->belongsTo(ProblemCategory::class, 'problem_category_id', 'id');
    }
}
