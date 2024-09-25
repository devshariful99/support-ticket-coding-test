<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Traits\AuditColumnsDataTrait;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\FileManagementTrait;

class AdminController extends Controller
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
        $admins = Admin::all();
        if ($request->ajax()) {
            $admins = $admins->sortBy('sort_order');
            return DataTables::of($admins)
                ->editColumn('status', function ($admin) {
                    return "<span class='" . $admin->getStatusBadgeBg() . "'>" . $admin->getStatusBadgeTitle() . "</span>";
                })
                ->editColumn('created_at', function ($admin) {
                    return timeFormat($admin->created_at);
                })
                ->editColumn('created_by', function ($admin) {
                    return creater_name($admin->creater_admin);
                })
                ->editColumn('action', function ($admin) {
                    return view('admin.includes.action_buttons', [
                        'menuItems' => [
                            ['routeName' => 'javascript:void(0)', 'data-id' => $admin->id, 'className' => 'view', 'label' => 'Details'],
                            ['routeName' => 'admin.edit', 'params' => [$admin->id], 'label' => 'Edit'],
                            ['routeName' => 'admin.status', 'params' => [$admin->id], 'label' => $admin->getStatusBtnTitle()],
                            ['routeName' => 'admin.destroy', 'params' => [$admin->id], 'label' => 'Delete', 'delete' => true],
                        ],
                    ]);
                })
                ->rawColumns(['status', 'created_at', 'created_by', 'action'])
                ->make(true);
        }
        return view('admin.admin_management.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin_management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $req)
    {
        $admin = new Admin();
        $this->handleFileUpload($req, $admin, 'image', 'admins/');
        $admin->name = $req->name;
        $admin->email = $req->email;
        $admin->password = $req->password;
        $admin->created_by = admin()->id;
        $admin->save();
        session()->flash('success', "$admin->name created successfully");
        return redirect()->route('admin.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $data = Admin::findOrFail($id);
        $this->AdminAuditColumnsData($data);
        $this->StatusData($data);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $data['admin'] = Admin::findOrFail($id);
        return view('admin.admin_management.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $req, int $id)
    {
        $admin = Admin::findOrFail($id);
        $this->handleFileUpload($req, $admin, 'image', 'admins/');
        $admin->name = $req->name;
        $admin->email = $req->email;
        if ($req->filled('password')) {
            $admin->password = $req->password;
        }
        $admin->updated_by = admin()->id;
        $admin->update();
        session()->flash('success', "$admin->name updated successfully");
        return redirect()->route('admin.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->update(['deleted_by' => admin()->id]);
        $admin->delete();
        session()->flash('success', "$admin->name deleted successfully");
        return redirect()->route('admin.index');
    }

    public function status(int $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->status = !$admin->status;
        $admin->updated_by = admin()->id;
        $admin->update();
        session()->flash('success', "$admin->name status updated successfully");
        return redirect()->route('admin.index');
    }
}
