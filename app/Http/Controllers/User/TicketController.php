<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Http\Traits\FileManagementTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketController extends Controller
{
    use FileManagementTrait;


    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        $ticket = Ticket::where('creater_id', user()->id)->where('creater_type', get_class(user()))->latest()->where('status', 1)->orWhere('status', 0)->first();
        if ($ticket) {
            session()->flash('warning', "You already have created a ticket $ticket->ticket_number. Please wait for response");
            return redirect()->route('user.dashboard');
        }
        return view('user.ticket.create');
    }
    public function store(TicketRequest $req): RedirectResponse
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

    public function details(string $id): View
    {
        $ticket = Ticket::with('messages.creater')->findOrFail(decrypt($id));
        $ticket->getStatusBadgeBg = $ticket->getStatusBadgeBg();
        $ticket->getStatusBadgeTitle = $ticket->getStatusBadgeTitle();
        $ticket->messages->each(function (&$message) {
            $message->created_at = $message->created_at->diffForHumans();
            $message->author = getModelName($message->creater_type);
            $message->author_image = auth_storage_url($message->creater->image, $message->creater->gender);
        });
        return view('user.ticket.details', compact('ticket'));
    }
}
