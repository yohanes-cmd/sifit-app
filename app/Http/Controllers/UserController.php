<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Opd; // <-- 1. Memanggil Model OPD
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Mengambil data user beserta role-nya
            $data = User::with('roles')->select('users.*');
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('role_name', function($row){
                        // Menampilkan badge role yang dimiliki user
                        $roles = $row->getRoleNames();
                        if(count($roles) > 0){
                            return '<span class="badge bg-success">'.ucfirst($roles[0]).'</span>';
                        }
                        return '<span class="badge bg-secondary">Tanpa Role</span>';
                    })
                    ->addColumn('action', function($row){
                        $btn = '<button data-id="'.$row->id.'" class="btn btn-warning btn-sm editUser text-white">Ubah</button> ';
                        $btn .= '<button data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteUser">Hapus</button>';
                        return $btn;
                    })
                    ->rawColumns(['role_name', 'action'])
                    ->make(true);
        }

        // 2. Mengirim data role DAN opd ke view untuk pilihan di modal dropdown
        $roles = Role::all();
        $opds = Opd::all(); 
        
        return view('users.index', compact('roles', 'opds'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
            'opd' => 'required|string' // <-- 3. Validasi OPD wajib diisi
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        // 4. Buat user baru dengan menyertakan OPD
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'opd' => $request->opd, 
        ]);

        // Assign role menggunakan Spatie
        $user->assignRole($request->role);

        return response()->json(['status' => 'success', 'message' => 'Pengguna berhasil ditambahkan!']);
    }

    public function edit($id)
    {
        $user = User::with('roles')->find($id);
        $userRole = $user->getRoleNames()->first();
        return response()->json(['user' => $user, 'role' => $userRole]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required',
            'opd' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->opd = $request->opd; // <-- 5. Pastikan OPD ikut diperbarui
        
        // Password opsional diisi saat edit
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Sinkronisasi ulang role
        $user->syncRoles([$request->role]);

        return response()->json(['status' => 'success', 'message' => 'Data pengguna berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Pengguna berhasil dihapus!']);
    }
}