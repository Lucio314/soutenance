<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [

        'code',
        'cpn_name',
        'cpn_email',
        'company_phone',
        'cpn_address',
        'is_active',
        'user_id'
    ];
    // Relation avec l'utilisateur (représentant de l'entreprise)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    // Relation avec les applications
    public function applications()
    {
        return $this->hasMany(Application::class, 'company_id', 'id');
    }
    public function technicians()
    {
        return $this->hasMany(Technician::class, 'technician_id', 'id');
    }
}
