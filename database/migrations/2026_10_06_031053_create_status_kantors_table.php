<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_kantors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_status');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Data awal (status yang sudah ada sebelumnya)
        DB::table('status_kantors')->insert([
            ['nama_status' => 'Kantor Pusat (Dinkes)', 'slug' => 'kantor_pusat', 'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'Puskesmas',             'slug' => 'puskesmas',    'created_at' => now(), 'updated_at' => now()],
            ['nama_status' => 'UPT Farmasi / Logistik', 'slug' => 'upt',          'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('status_kantors');
    }
};
