<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function  dashboard(): View
    {
        $data['admins'] = Admin::all();
        $data['users'] = User::all();
        $data['tickets'] = Ticket::all();
        return view('admin.dashboard.dashboard', $data);
    }
}
