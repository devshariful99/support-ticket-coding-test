<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Traits\AuditColumnsDataTrait;
use App\Http\Traits\FileManagementTrait;
use App\Models\User;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    use AuditColumnsDataTrait, FileManagementTrait;
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::all();
        if ($request->ajax()) {
            $users = $users->sortBy('sort_order');
            return DataTables::of($users)
                ->editColumn('status', function ($user) {
                    return "<span class='" . $user->getStatusBadgeBg() . "'>" . $user->getStatusBadgeTitle() . "</span>";
                })
                ->editColumn('created_at', function ($user) {
                    return timeFormat($user->created_at);
                })
                ->editColumn('created_by', function ($user) {
                    return creater_name($user->creater);
                })
                ->editColumn('action', function ($user) {
                    return view('admin.includes.action_buttons', [
                        'menuItems' => [
                            ['routeName' => 'javascript:void(0)', 'data-id' => $user->id, 'className' => 'view', 'label' => 'Details'],
                            ['routeName' => 'user.edit', 'params' => [$user->id], 'label' => 'Edit'],
                            ['routeName' => 'user.status', 'params' => [$user->id], 'label' => $user->getStatusBtnTitle()],
                            ['routeName' => 'user.destroy', 'params' => [$user->id], 'label' => 'Delete', 'delete' => true],
                        ],
                    ]);
                })
                ->rawColumns(['status', 'created_at', 'created_by', 'action'])
                ->make(true);
        }
        return view('admin.user_management.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user_management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $req)
    {
        $user = new User();
        $this->handleFileUpload($req, $user, 'image', 'users/');
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = $req->password;
        $user->creater()->associate(admin());
        $user->save();
        session()->flash('success', "$user->name created successfully");
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $data = User::findOrFail($id);
        $this->MorphAuditColumnsData($data);
        $this->StatusData($data);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $data['user'] = User::findOrFail($id);
        return view('admin.user_management.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $req, int $id)
    {
        $user = User::findOrFail($id);
        $this->handleFileUpload($req, $user, 'image', 'users/');
        $user->name = $req->name;
        $user->email = $req->email;
        if ($req->filled('password')) {
            $user->password = $req->password;
        }
        $user->updater()->associate(admin());
        $user->update();
        session()->flash('success', "$user->name updated successfully");
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        $user->deleter()->associate(admin());
        $user->update();
        $user->delete();
        session()->flash('success', "$user->name deleted successfully");
        return redirect()->route('user.index');
    }

    public function status(int $id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->updater()->associate(admin());
        $user->update();
        session()->flash('success', "$user->name status updated successfully");
        return redirect()->route('user.index');
    }
}
