<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends BaseModel
{
    use HasFactory;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
