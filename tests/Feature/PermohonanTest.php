<?php

namespace Tests\Feature;

use App\Models\DetailTransaksi;
use App\Models\Gudang;
use App\Models\MasterObat;
use App\Models\Opd;
use App\Models\Pengangkut;
use App\Models\Permohonan;
use App\Models\Program;
use App\Models\StokObat;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PermohonanTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'opd', 'guard_name' => 'web']);
    }

    public function test_opd_user_can_view_permohonan_index(): void
    {
        $opd = Opd::create([
            'nama_opd' => 'Puskesmas Uji Coba',
            'status_kantor' => 'milik_sendiri',
            'alamat' => 'Jl. Uji Coba No. 1',
        ]);

        $user = User::factory()->create([
            'opd' => $opd->nama_opd,
            'opd_id' => $opd->id,
        ]);
        $user->assignRole('opd');

        $response = $this->actingAs($user)->get(route('permohonan.index'));
        $response->assertStatus(200);
        $response->assertSee('Permohonan Obat');
    }

    public function test_opd_user_can_submit_permohonan(): void
    {
        $opd = Opd::create([
            'nama_opd' => 'Puskesmas Sukajadi',
            'status_kantor' => 'milik_sendiri',
        ]);

        $user = User::factory()->create([
            'opd' => $opd->nama_opd,
            'opd_id' => $opd->id,
        ]);
        $user->assignRole('opd');

        $obat = MasterObat::create([
            'kode_obat' => 'OBT-TEST-001',
            'nama_obat' => 'Paracetamol 500mg',
            'kategori' => 'Generik',
            'satuan' => 'Tablet',
            'status' => 'published',
        ]);

        $postData = [
            'tanggal_permohonan' => now()->toDateString(),
            'nomor_permohonan' => 'PRM/TEST/001',
            'keperluan' => 'Stok Rutin Bulanan',
            'items' => [
                [
                    'master_obat_id' => $obat->id,
                    'jumlah_diminta' => 100,
                    'catatan' => 'Segera dikirim',
                ],
            ],
        ];

        $response = $this->actingAs($user)->post(route('permohonan.store'), $postData);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('permohonans', [
            'nomor_permohonan' => 'PRM/TEST/001',
            'opd_id' => $opd->id,
            'status' => 'menunggu',
        ]);

        $this->assertDatabaseHas('detail_permohonans', [
            'master_obat_id' => $obat->id,
            'jumlah_diminta' => 100,
        ]);
    }

    public function test_super_admin_can_verify_permohonan(): void
    {
        $opd = Opd::create(['nama_opd' => 'RSUD Uji']);
        $opdUser = User::factory()->create(['opd_id' => $opd->id]);
        $opdUser->assignRole('admin');

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');

        $permohonan = Permohonan::create([
            'nomor_permohonan' => 'PRM/VERIF/001',
            'tanggal_permohonan' => now()->toDateString(),
            'opd_id' => $opd->id,
            'user_id' => $opdUser->id,
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($superAdmin)->post(route('permohonan.verifikasi', $permohonan->id), [
            'status' => 'disetujui',
            'catatan_verifikasi' => 'Stok tersedia di gudang utama',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('permohonans', [
            'id' => $permohonan->id,
            'status' => 'disetujui',
            'verified_by' => $superAdmin->id,
        ]);
    }

    public function test_permohonan_print_view(): void
    {
        $opd = Opd::create(['nama_opd' => 'Puskesmas Print']);
        $user = User::factory()->create(['opd_id' => $opd->id]);
        $user->assignRole('opd');

        $permohonan = Permohonan::create([
            'nomor_permohonan' => 'PRM/PRINT/001',
            'tanggal_permohonan' => now()->toDateString(),
            'opd_id' => $opd->id,
            'user_id' => $user->id,
            'status' => 'disetujui',
        ]);

        $response = $this->actingAs($user)->get(route('permohonan.print', $permohonan->id));
        $response->assertStatus(200);
        $response->assertSee('PRM/PRINT/001');
        $response->assertSee('Puskesmas Print');
    }

    public function test_pengeluaran_from_permohonan_sets_status_to_selesai(): void
    {
        $gudang = Gudang::firstOrCreate(['nama_gudang' => 'Gudang Utama Farmasi'], ['tipe' => 'pusat']);
        $program = Program::firstOrCreate(['nama' => 'Program Rutin'], ['kode' => 'PRG-01']);
        $pengangkut = Pengangkut::firstOrCreate(['nama' => 'Kurir Dinkes'], ['jenis_kendaraan' => 'Mobil Box']);
        $opd = Opd::create(['nama_opd' => 'Puskesmas Rumbai']);
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');

        $obat = MasterObat::create([
            'kode_obat' => 'OBT-SBBK-001',
            'nama_obat' => 'Amoxicillin 500mg',
            'kategori' => 'Antibiotik',
            'satuan' => 'Kapsul',
            'status' => 'published',
        ]);

        StokObat::create([
            'gudang_id' => $gudang->id,
            'master_obat_id' => $obat->id,
            'no_batch' => 'BATCH-TEST-01',
            'exp_date' => now()->addYear()->toDateString(),
            'jumlah' => 500,
        ]);

        $permohonan = Permohonan::create([
            'nomor_permohonan' => 'PRM/SBBK/001',
            'tanggal_permohonan' => now()->toDateString(),
            'opd_id' => $opd->id,
            'user_id' => $superAdmin->id,
            'status' => 'disetujui',
        ]);

        $response = $this->actingAs($superAdmin)->post(route('pengeluaran.store'), [
            'tanggal' => now()->toDateString(),
            'nomor_surat' => 'SBBK/TEST/001',
            'permohonan_id' => $permohonan->id,
            'gudang_id' => $gudang->id,
            'program_id' => $program->id,
            'pengangkut_id' => $pengangkut->id,
            'instansi_id' => $opd->id,
            'pajak_invoice' => 'NO TAX',
            'master_obat_id' => [$obat->id],
            'no_batch' => ['BATCH-TEST-01'],
            'jumlah' => [50],
            'harga_satuan' => [1500],
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('permohonans', [
            'id' => $permohonan->id,
            'status' => 'selesai',
        ]);
        $this->assertDatabaseHas('transaksis', [
            'nomor_surat' => 'SBBK/TEST/001',
            'permohonan_id' => $permohonan->id,
            'jenis_transaksi' => 'pengeluaran',
        ]);
    }

    public function test_approved_permohonan_sbbk_is_visible_in_opd_pemasukan_index(): void
    {
        $opd = Opd::create(['nama_opd' => 'Puskesmas Rejosari']);
        $opdAdmin = User::factory()->create(['opd_id' => $opd->id]);
        $opdAdmin->assignRole('admin');

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');

        $obat = MasterObat::create([
            'kode_obat' => 'OBT-MASUK-01',
            'nama_obat' => 'Amoxicillin 500mg',
            'kategori' => 'Antibiotik',
            'satuan' => 'Kapsul',
            'status' => 'published',
        ]);

        $gudang = Gudang::firstOrCreate(['nama_gudang' => 'Gudang Farmasi Pusat'], ['tipe' => 'pusat', 'status' => 'aktif']);

        $permohonan = Permohonan::create([
            'nomor_permohonan' => 'PRM/MASUK/01',
            'tanggal_permohonan' => now()->toDateString(),
            'opd_id' => $opd->id,
            'user_id' => $opdAdmin->id,
            'status' => 'disetujui',
        ]);

        // Simulasikan transaksi SBBK keluar dari Pusat yang ditujukan ke OPD ini
        $sbbk = Transaksi::create([
            'nomor_surat' => 'SBBK/MASUK/001',
            'tanggal' => now()->toDateString(),
            'jenis_transaksi' => 'pengeluaran',
            'gudang_asal_id' => $gudang->id,
            'instansi_id' => $opd->id,
            'permohonan_id' => $permohonan->id,
            'user_id' => $superAdmin->id,
        ]);

        DetailTransaksi::create([
            'transaksi_id' => $sbbk->id,
            'master_obat_id' => $obat->id,
            'no_batch' => 'BATCH-IN-01',
            'jumlah' => 100,
            'harga_satuan' => 2000,
        ]);

        // Admin OPD membuka daftar pemasukan, harus melihat SBBK ini sebagai barang masuk
        $response = $this->actingAs($opdAdmin)->get(route('pemasukan.index'));
        $response->assertStatus(200);
        $response->assertSee('SBBK/MASUK/001');
        $response->assertSee('PRM/MASUK/01');
    }

    public function test_admin_opd_can_create_pengeluaran_pelayanan(): void
    {
        $opd = Opd::create(['nama_opd' => 'Puskesmas Payung Sekaki']);
        $opdAdmin = User::factory()->create(['opd_id' => $opd->id]);
        $opdAdmin->assignRole('admin');

        $obat = MasterObat::create([
            'kode_obat' => 'OBT-PEL-01',
            'nama_obat' => 'Oralit Sachet',
            'kategori' => 'Generik',
            'satuan' => 'Sachet',
            'status' => 'published',
        ]);

        // Form create pengeluaran dapat dibuka oleh Admin OPD
        $responseCreate = $this->actingAs($opdAdmin)->get(route('pengeluaran.create'));
        $responseCreate->assertStatus(200);
        $responseCreate->assertSee('Formulir Pengeluaran Obat / Pelayanan Pasien');

        // Submit pengeluaran pelayanan
        $responseStore = $this->actingAs($opdAdmin)->post(route('pengeluaran.store'), [
            'nomor_surat' => 'OUT-OPD-TEST-001',
            'tanggal' => now()->toDateString(),
            'tujuan_pengeluaran' => 'Poli Umum',
            'catatan' => 'Pelayanan pasien ISPA',
            'items' => [
                [
                    'master_obat_id' => $obat->id,
                    'no_batch' => 'BATCH-TEST-01',
                    'jumlah' => 20,
                ],
            ],
        ]);

        $responseStore->assertSessionHasNoErrors();
        $this->assertDatabaseHas('transaksis', [
            'nomor_surat' => 'OUT-OPD-TEST-001',
            'jenis_transaksi' => 'pengeluaran',
            'instansi_id' => $opd->id,
        ]);
    }

    public function test_admin_opd_can_create_internal_pemindahan(): void
    {
        $opd = Opd::create(['nama_opd' => 'Puskesmas Rumbai']);
        $opdAdmin = User::factory()->create(['opd_id' => $opd->id]);
        $opdAdmin->assignRole('admin');

        $obat = MasterObat::create([
            'kode_obat' => 'OBT-MUT-01',
            'nama_obat' => 'Betadine 30ml',
            'kategori' => 'Antiseptik',
            'satuan' => 'Botol',
            'status' => 'published',
        ]);

        // Form create pemindahan OPD dapat dibuka
        $responseCreate = $this->actingAs($opdAdmin)->get(route('pemindahan.create'));
        $responseCreate->assertStatus(200);
        $responseCreate->assertSee('Formulir Pemindahan / Mutasi Obat Antar Ruangan');

        // Submit pemindahan mutasi internal OPD
        $responseStore = $this->actingAs($opdAdmin)->post(route('pemindahan.store'), [
            'nomor_surat' => 'MUT-OPD-TEST-001',
            'tanggal' => now()->toDateString(),
            'unit_asal' => 'Kamar Obat Induk',
            'unit_tujuan' => 'Depo IGD',
            'catatan' => 'Pergeseran stok tindakan darurat',
            'items' => [
                [
                    'master_obat_id' => $obat->id,
                    'no_batch' => 'BATCH-MUT-01',
                    'jumlah' => 10,
                ],
            ],
        ]);

        $responseStore->assertSessionHasNoErrors();
        $this->assertDatabaseHas('transaksis', [
            'nomor_surat' => 'MUT-OPD-TEST-001',
            'jenis_transaksi' => 'pemindahan',
            'instansi_id' => $opd->id,
        ]);
    }

    public function test_all_roles_can_access_pengeluaran_index_without_errors(): void
    {
        // 1. Super Admin
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');
        $resSuper = $this->actingAs($superAdmin)->get(route('pengeluaran.index'));
        $resSuper->assertStatus(200);
        $resSuper->assertSee('Daftar Surat Bukti Barang Keluar');

        // 2. Admin OPD
        $opd = Opd::create(['nama_opd' => 'Puskesmas Tenayan Raya']);
        $opdAdmin = User::factory()->create(['opd_id' => $opd->id]);
        $opdAdmin->assignRole('admin');
        $resOpd = $this->actingAs($opdAdmin)->get(route('pengeluaran.index'));
        $resOpd->assertStatus(200);
        $resOpd->assertSee('Pengeluaran Obat Pelayanan OPD');

        // 3. User biasa / role opd
        $userOpd = User::factory()->create(['opd_id' => $opd->id]);
        $userOpd->assignRole('opd');
        $resUserOpd = $this->actingAs($userOpd)->get(route('pengeluaran.index'));
        $resUserOpd->assertStatus(200);

        // 4. Cek akses form create pengeluaran untuk Super Admin & Admin OPD
        $resSuperCreate = $this->actingAs($superAdmin)->get(route('pengeluaran.create'));
        $resSuperCreate->assertStatus(200);

        $resOpdCreate = $this->actingAs($opdAdmin)->get(route('pengeluaran.create'));
        $resOpdCreate->assertStatus(200);

        // 5. Cek akses form create pemindahan untuk Super Admin & Admin OPD
        $resSuperPindah = $this->actingAs($superAdmin)->get(route('pemindahan.create'));
        $resSuperPindah->assertStatus(200);

        $resOpdPindah = $this->actingAs($opdAdmin)->get(route('pemindahan.create'));
        $resOpdPindah->assertStatus(200);
    }
}
