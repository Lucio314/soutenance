<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable = [
        'app_name',
        'description',
        'is_active',
        'unique_code',
        'app_email',
        'app_phone',
        'company_id',
    ];

    // Relation avec la société
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    // Relation avec les catégories de problèmes
    public function problemCategories()
    {
        return $this->hasMany(ProblemCategory::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
