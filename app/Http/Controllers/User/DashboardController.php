<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\FileManageController;
use App\Http\Traits\FileManagementTrait;

class DashboardController extends Controller
{
    use FileManagementTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(Request $request)
    {
        $user = User::findOrFail(user()->id);
        return view('user.dashboard', compact('user'));
    }

    public function profileUpdate(UserRequest $req, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $this->handleFileUpload($req, $user, 'image', 'users/');
        $user->name = $req->name;
        $user->email = $req->email;
        if ($req->filled('password')) {
            $user->password = $req->password;
        }
        $user->updater()->associate(user());
        $user->update();
        session()->flash('success', "Profile data updated successfully");
        return redirect()->route('user.dashboard');
    }
}
