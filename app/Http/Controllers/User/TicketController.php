<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Http\Traits\FileManagementTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Traits\TicketStatusMailTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    use FileManagementTrait, TicketStatusMailTrait;


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tickets = Ticket::where('creater_id', user()->id)->where('creater_type', get_class(user()))->latest()->get();
        if ($request->ajax()) {
            $tickets = $tickets->sortBy('status');
            return DataTables::of($tickets)
                ->editColumn('ticket_number', function ($ticket) {
                    return "<span>" . $ticket->ticket_number . "</span> <sup><span class='" . $ticket->getStatusBadgeBg() . "'>" . $ticket->getStatusBadgeTitle() . "</span></sup>";
                })
                ->editColumn('title', function ($ticket) {
                    return str_limit($ticket->title, 30);
                })
                ->editColumn('description', function ($ticket) {
                    return str_limit($ticket->description, 45);
                })
                ->editColumn('created_at', function ($ticket) {
                    return timeFormat($ticket->created_at);
                })
                ->editColumn('action', function ($ticket) {
                    return view('user.includes.action_buttons', [
                        'menuItems' => [
                            ['routeName' => 'user.ticket.details', 'params' => [encrypt($ticket->id)], 'label' => 'Details'],
                        ],
                    ]);
                })
                ->rawColumns(['ticket_number', 'title', 'description', 'created_at', 'action'])
                ->make(true);
        }
        return view('user.ticket.index', compact('tickets'));
    }



    public function create()
    {
        $ticket = Ticket::where('creater_id', user()->id)->where('creater_type', get_class(user()))->latest()->whereIn('status', [0, 1])->first();
        if ($ticket) {
            session()->flash('warning', "You already have created a ticket $ticket->ticket_number. Please wait for response");
            return redirect()->route('user.ticket.index');
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

        $this->ticketCreateMail($ticket);

        session()->flash('success', "Your ticket created successfully");
        return redirect()->route('user.ticket.index');
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
