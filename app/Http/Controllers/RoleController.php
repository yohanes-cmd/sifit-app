<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::with('permissions')->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('jumlah_permission', function($row){
                        return $row->permissions->count(); 
                    })
                    ->addColumn('action', function($row){
                        $btn = '<button data-id="'.$row->id.'" class="btn btn-warning btn-sm editRole text-white">Ubah</button> ';
                        $btn .= '<button data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteRole">Hapus</button>';
                        return $btn;
                    })
                    ->rawColumns(['action']) 
                    ->make(true);
        }

        return view('roles.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z\s_]+$/|unique:roles,name',
            // Opsi 'Personal' ditambahkan ke dalam validasi
            'akses_data' => 'required|string|in:Global,OPD,Personal', 
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        // 1. Paksa Simpan Role langsung ke Database (Bypass Spatie)
        $roleId = DB::table('roles')->insertGetId([
            'name' => $request->name,
            'guard_name' => 'web',
            'akses_data' => $request->akses_data,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 2. Ambil instance role untuk sinkronisasi permissions
        $role = Role::find($roleId);
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['status' => 'success', 'message' => 'Role dan Permission berhasil ditambahkan!']);
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        
        // Ambil daftar nama permission yang sudah dimiliki role ini
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return response()->json([
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z\s_]+$/|unique:roles,name,'.$id,
            // Opsi 'Personal' ditambahkan ke dalam validasi
            'akses_data' => 'required|string|in:Global,OPD,Personal',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        // 1. Paksa Update Role langsung ke Database (Bypass Spatie)
        DB::table('roles')->where('id', $id)->update([
            'name' => $request->name,
            'akses_data' => $request->akses_data,
            'updated_at' => now()
        ]);

        // 2. Sinkronisasi permissions dari checkbox kotak-kotak
        $role = Role::find($id);
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['status' => 'success', 'message' => 'Data Role dan Permission berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        Role::find($id)->delete();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return response()->json(['status' => 'success', 'message' => 'Role berhasil dihapus!']);
    }
}