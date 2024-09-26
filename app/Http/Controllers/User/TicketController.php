<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Traits\FileManagementTrait;


class TicketController extends Controller
{
    use FileManagementTrait;
    public function create(): View
    {
        return view('user.ticket.create');
    }
    public function store(TicketRequest $req)
    {
        $ticket = new Ticket();
        $ticket->ticket_number = generateTicketNumber();
        $ticket->title = $req->title;
        $ticket->description = $req->description;
        $this->handleFileUpload($req, $ticket, 'files', 'tickets/', true);
        $ticket->creater()->associate(user());
        $ticket->save();
        session()->flash('success', "Your ticket created successfully");
        return redirect()->route('user.dashboard');
    }

    public function details(string $id)
    {
        $ticket = Ticket::with('messages')->findOrFail(decrypt($id));
        return view('user.ticket.details', compact('ticket'));
    }
}
