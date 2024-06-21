<?php

// app/Models/Comment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'ticket_id',
        'body',
        'client_email',
        'is_technician',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
