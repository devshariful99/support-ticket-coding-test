<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    public function dashboard(Request $request)
    {
        $tickets = Ticket::where('creater_id', user()->id)->where('creater_type', get_class(user()))->latest()->get();
        if ($request->ajax()) {
            $tickets = $tickets->sortBy('status');
            return DataTables::of($tickets)
                ->editColumn('title', function ($ticket) {
                    return str_limit($ticket->title, 30);
                })
                ->editColumn('description', function ($ticket) {
                    return str_limit($ticket->description, 45);
                })
                ->editColumn('status', function ($ticket) {
                    return "<span class='" . $ticket->getStatusBadgeBg() . "'>" . $ticket->getStatusBadgeTitle() . "</span>";
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
                ->rawColumns(['title', 'description', 'status', 'created_at', 'action'])
                ->make(true);
        }
        return view('user.dashboard', compact('tickets'));
    }
}
