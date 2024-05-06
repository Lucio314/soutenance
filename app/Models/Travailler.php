<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travailler extends Model
{
    use HasFactory;
    protected $table = 'travaillers'; // Nom de la table pivot
    protected $primaryKey = [
        'technician_id',
        'ticket_id',
    ];
    public $incrementing = false;
    protected $fillable = [
        'technician_id',
        'ticket_id',
        'transferred_to',
    ];

    public $timestamps = true;
    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id');
    }

    // Relation avec le ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
