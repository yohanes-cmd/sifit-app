<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::with('permissions')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jumlah_permission', function ($row) {
                    return $row->permissions->count();
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button data-id="'.$row->id.'" class="btn btn-warning btn-sm editRole text-white">Ubah</button> ';
                    $btn .= '<button data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteRole">Hapus</button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $permissionGroups = [
            'Transaksi & Distribusi Farmasi' => [
                'permohonan' => [
                    'label' => 'Permohonan Obat (OPD)',
                    'actions' => ['view' => 'Lihat', 'create' => 'Tambah', 'edit' => 'Edit', 'delete' => 'Hapus', 'verify' => 'Verifikasi', 'print' => 'Cetak'],
                ],
                'pengeluaran' => [
                    'label' => 'Pengeluaran Obat (SBBK)',
                    'actions' => ['view' => 'Lihat', 'create' => 'Realisasi / SBBK', 'delete' => 'Hapus', 'print' => 'Cetak SBBK'],
                ],
                'pemasukan' => [
                    'label' => 'Pemasukan Obat (Gudang)',
                    'actions' => ['view' => 'Lihat', 'create' => 'Tambah', 'delete' => 'Hapus', 'import' => 'Import', 'print' => 'Cetak'],
                ],
                'pemindahan' => [
                    'label' => 'Pemindahan Antar Gudang',
                    'actions' => ['view' => 'Lihat', 'create' => 'Tambah', 'delete' => 'Hapus', 'print' => 'Cetak'],
                ],
            ],
            'Master & Stok Obat' => [
                'master-obat' => [
                    'label' => 'Master Obat & Alkes',
                    'actions' => ['view' => 'Lihat', 'create' => 'Tambah', 'edit' => 'Edit', 'delete' => 'Hapus', 'export' => 'Export'],
                ],
                'stok-obat' => [
                    'label' => 'Stok & Kartu Stok',
                    'actions' => ['view' => 'Lihat', 'create' => 'Tambah', 'edit' => 'Edit', 'delete' => 'Hapus', 'export' => 'Export', 'print' => 'Cetak'],
                ],
            ],
            'Master OPD & Wilayah' => [
                'opd' => [
                    'label' => 'Master OPD / Instansi',
                    'actions' => ['view' => 'Lihat', 'create' => 'Tambah', 'edit' => 'Edit', 'delete' => 'Hapus', 'import' => 'Import'],
                ],
            ],
            'Manajemen Pengguna & Sistem' => [
                'user' => [
                    'label' => 'Pengguna (User)',
                    'actions' => ['view' => 'Lihat', 'create' => 'Tambah', 'edit' => 'Edit', 'delete' => 'Hapus'],
                ],
                'role' => [
                    'label' => 'Manajemen Role & RBAC',
                    'actions' => ['view' => 'Lihat', 'create' => 'Tambah', 'edit' => 'Edit', 'delete' => 'Hapus'],
                ],
                'pengaturan' => [
                    'label' => 'Pengaturan Aplikasi',
                    'actions' => ['view' => 'Lihat', 'manage' => 'Kelola'],
                ],
                'berita' => [
                    'label' => 'Berita & Informasi Portal',
                    'actions' => ['view' => 'Lihat', 'create' => 'Tambah', 'edit' => 'Edit', 'delete' => 'Hapus'],
                ],
            ],
        ];

        return view('roles.index', compact('permissionGroups'));
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
            'updated_at' => now(),
        ]);

        // 2. Ambil instance role untuk sinkronisasi permissions
        $role = Role::find($roleId);
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['status' => 'success', 'message' => 'Role dan Permission berhasil ditambahkan!']);
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);

        // Ambil daftar nama permission yang sudah dimiliki role ini
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return response()->json([
            'role' => $role,
            'rolePermissions' => $rolePermissions,
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
            'updated_at' => now(),
        ]);

        // 2. Sinkronisasi permissions dari checkbox kotak-kotak
        $role = Role::find($id);
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['status' => 'success', 'message' => 'Data Role dan Permission berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        Role::find($id)->delete();
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        return response()->json(['status' => 'success', 'message' => 'Role berhasil dihapus!']);
    }
}
