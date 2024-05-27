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

    /**
     * Boot method for the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate a unique API key when creating a new application
        static::creating(function ($application) {
            $application->unique_code = bin2hex(random_bytes(30));
        });
    }

    /**
     * Get the company that owns the application.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * Get the problem categories for the application.
     */
    public function problemCategories()
    {
        return $this->hasMany(ProblemCategory::class);
    }

    /**
     * Get the tickets for the application.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
