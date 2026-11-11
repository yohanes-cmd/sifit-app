<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Display the site settings management page.
     */
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key');

        return view('pengaturan.site_settings.index', compact('settings'));
    }

    /**
     * Update the site settings.
     */
    public function update(Request $request)
    {
        $fields = [
            // Beranda
            'beranda_hero_ringkasan' => 'tentang',

            // Tentang & Profil
            'tentang_judul' => 'tentang',
            'tentang_tagline' => 'tentang',
            'tentang_instansi' => 'tentang',
            'tentang_motto' => 'tentang',
            'tentang_deskripsi' => 'tentang',

            // Visi & Misi
            'visi_sifit' => 'visi_misi',
            'misi_sifit' => 'visi_misi',

            // Sasaran / Nilai
            'tujuan_1_judul' => 'tujuan',
            'tujuan_1_isi' => 'tujuan',
            'tujuan_2_judul' => 'tujuan',
            'tujuan_2_isi' => 'tujuan',
            'tujuan_3_judul' => 'tujuan',
            'tujuan_3_isi' => 'tujuan',

            // Kontak & Lokasi
            'kontak_alamat' => 'kontak',
            'kontak_telepon' => 'kontak',
            'kontak_email' => 'kontak',
            'kontak_jam_layanan' => 'kontak',
            'kontak_maps_embed' => 'kontak',
        ];

        foreach ($fields as $key => $group) {
            if ($request->has($key)) {
                SiteSetting::set($key, $request->input($key), $group);
            }
        }

        SiteSetting::clearCache();

        $activeTab = $request->input('active_tab', 'profil');

        return redirect()->route('site-settings.index')
            ->with('success', 'Konten profil dan informasi SIFIT berhasil diperbarui!')
            ->with('active_tab', $activeTab);
    }
}
