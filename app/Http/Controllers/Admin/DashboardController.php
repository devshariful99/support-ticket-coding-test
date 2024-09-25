<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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
        $data['users'] = Admin::all();
        return view('admin.dashboard.dashboard', $data);
    }
}
