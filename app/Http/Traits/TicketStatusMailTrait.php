<?php

namespace App\Http\Traits;

use App\Mail\TicketCloseMail;
use App\Mail\TicketCreateMail;
use App\Mail\TicketStatusMail;
use Illuminate\Support\Facades\Mail;

trait TicketStatusMailTrait
{
    private function ticketCreateMail($ticket)
    {
        $data = [
            'subject' => 'A new ticket created',
            'ticket_number' => $ticket->ticket_number,
            'title' => $ticket->title,
            'description' => $ticket->description,
            'author' => user()->name,
            'url' => route('ticket.details', encrypt($ticket->id)),
        ];
        Mail::to('admin@dev.com')
            ->send(new TicketCreateMail($data));
    }

    private function ticketCloseMail($ticket)
    {
        $data = [
            'subject' => "Ticket $ticket->ticket_number has been closed",
            'ticket_number' => $ticket->ticket_number,
            'title' => $ticket->title,
            'description' => $ticket->description,
            'author' => $ticket->creater->name,
            'close_by' => admin()->name,
            'url' => route('user.ticket.details', encrypt($ticket->id)),
        ];
        Mail::to('user@dev.com')
            ->send(new TicketCloseMail($data));
    }
}
