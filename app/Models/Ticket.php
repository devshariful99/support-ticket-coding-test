<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends BaseModel
{
    use HasFactory;

    public function messages()
    {
        return $this->hasMany(Message::class, 'ticket_id');
    }

    public function getStatusBadgeTitle()
    {
        switch ($this->status) {
            case 1:
                return 'Open';
            case 2:
                return 'Closed';
            default:
                return 'Pending';
        }
    }
    public function getStatusBadgeBg()
    {
        switch ($this->status) {
            case 1:
                return 'badge bg-success';
            case 2:
                return 'badge bg-secondary';
            default:
                return 'badge bg-info';
        }
    }
}
