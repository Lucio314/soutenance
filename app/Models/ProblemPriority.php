<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemPriority extends Model
{
    use HasFactory;
    protected $primaryKey = 'code_priority';
    public $incrementing = false;
    protected $fillable = [
        'code_priority',
        'name_priority',
    ];
    public function problemCategories()
    {
        return $this->hasMany(ProblemCategory::class, 'code_priority', 'code_priority');
    }
}
