<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tickets = Ticket::all();
        if ($request->ajax()) {
            $tickets = $tickets->sortBy('sort_order');
            return DataTables::of($tickets)
                ->editColumn('title', function ($ticket) {
                    return str_limit($ticket->title, 20);
                })
                ->editColumn('status', function ($ticket) {
                    return "<span class='" . $ticket->getStatusBadgeBg() . "'>" . $ticket->getStatusBadgeTitle() . "</span>";
                })
                ->editColumn('created_at', function ($ticket) {
                    return timeFormat($ticket->created_at);
                })
                ->editColumn('created_by', function ($ticket) {
                    return creater_name($ticket->creater);
                })
                ->editColumn('action', function ($ticket) {
                    return view('admin.includes.action_buttons', [
                        'menuItems' => [
                            ['routeName' => 'ticket.details', 'params' => [encrypt($ticket->id)], 'label' => 'Details'],
                        ],
                    ]);
                })
                ->rawColumns(['title', 'status', 'created_at', 'created_by', 'action'])
                ->make(true);
        }
        return view('admin.ticket_management.index', compact('tickets'));
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
        return view('admin.ticket_management.details', compact('ticket'));
    }

    public function close(string $id): RedirectResponse
    {
        $ticket = Ticket::findOrFail(decrypt($id));
        $ticket->status = 2;
        $ticket->updater()->associate(admin());
        $ticket->update();
        session()->flash('success', "Ticket $ticket->ticket_number closed successfully");
        return redirect()->route('ticket.details', $id);
    }
}
