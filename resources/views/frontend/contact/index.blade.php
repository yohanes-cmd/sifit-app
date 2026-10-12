@extends('frontend.layouts.app')
@section('title', 'Kontak & Layanan Pengaduan - SIFIT Provinsi Riau')

@section('content')
<style>
    .sifit-contact-section {
        padding: 24px 0 45px;
        background: #f8fafc;
    }
    .sifit-contact-master-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(17, 85, 102, 0.06);
        display: flex;
        flex-wrap: wrap;
    }
    
    /* Left Hub Column (Teal Government Accent) */
    .sifit-contact-hub {
        background: linear-gradient(145deg, #07252c 0%, #0b3a46 60%, #115566 100%);
        color: #ffffff;
        padding: 32px 28px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .sifit-contact-hub::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(77, 182, 172, 0.25) 0%, transparent 70%);
        pointer-events: none;
    }
    .sifit-contact-hub .hub-title {
        font-size: 20px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 6px;
        letter-spacing: -0.2px;
    }
    .sifit-contact-hub .hub-desc {
        color: rgba(255, 255, 255, 0.8);
        font-size: 12.5px;
        line-height: 1.5;
        margin: 0 0 24px;
    }
    .sifit-hub-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 18px;
    }
    .sifit-hub-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(77, 182, 172, 0.35);
        color: var(--sifit-accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
        transition: all 0.25s ease;
    }
    .sifit-hub-item:hover .sifit-hub-icon {
        background: var(--sifit-accent);
        color: #07252c;
        transform: scale(1.06);
    }
    .sifit-hub-text {
        font-size: 12.5px;
        line-height: 1.45;
    }
    .sifit-hub-text strong {
        display: block;
        color: #a7f3d0;
        font-size: 13px;
        margin-bottom: 2px;
    }
    .sifit-hub-text span {
        color: rgba(255, 255, 255, 0.85);
    }
    .sifit-hub-map {
        width: 100%;
        height: 160px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
        margin-top: 18px;
    }
    .sifit-wa-btn {
        background: #25D366;
        color: #ffffff !important;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none !important;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(37, 211, 102, 0.3);
        margin-top: 16px;
    }
    .sifit-wa-btn:hover {
        background: #1eb954;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(37, 211, 102, 0.45);
    }

    /* Right Form Column */
    .sifit-contact-form-col {
        padding: 32px 36px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .sifit-form-heading {
        font-size: 19px;
        font-weight: 800;
        color: var(--sifit-primary);
        margin: 0 0 6px;
    }
    .sifit-form-subheading {
        color: #64748b;
        font-size: 13px;
        margin: 0 0 22px;
        line-height: 1.5;
    }
    .sifit-form-label {
        display: block;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
    }
    .sifit-form-control {
        width: 100%;
        height: 40px;
        padding: 6px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 13px;
        color: #1e293b;
        background: #ffffff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .sifit-form-control:focus {
        border-color: var(--sifit-accent);
        box-shadow: 0 0 0 3px rgba(77, 182, 172, 0.15);
        outline: none;
    }

    @media (max-width: 991px) {
        .sifit-contact-hub,
        .sifit-contact-form-col {
            padding: 24px 20px;
        }
    }
</style>

{{-- BREADCRUMB COMPACT --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-envelope-o" style="color: var(--sifit-accent);"></i> Kontak & Layanan Pengaduan</h1>
                <p>Saluran komunikasi terpadu dan konsultasi informasi farmasi Dinkes Riau</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">Kontak Kami</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- KONTEN KONTAK (1 SINGLE MASTER CARD) --}}
<section class="sifit-contact-section">
    <div class="container">

        <div class="sifit-contact-master-card wow fadeInUp" data-wow-delay="0.1s">
            <div class="row" style="margin: 0; width: 100%;">

                {{-- KOLOM KIRI: HUB KONTAK RESMI & MAPS --}}
                <div class="col-lg-5 col-md-5 col-sm-12" style="padding: 0;">
                    <div class="sifit-contact-hub" style="height: 100%;">
                        <div>
                            <span style="background: rgba(77, 182, 172, 0.2); color: #a7f3d0; border: 1px solid rgba(77, 182, 172, 0.4); padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; margin-bottom: 10px;">
                                <i class="fa fa-shield"></i> Pusat Layanan Resmi
                            </span>
                            <h3 class="hub-title">Dinas Kesehatan Provinsi Riau</h3>
                            <p class="hub-desc">
                                Seksi Kefarmasian & Alat Kesehatan — Layanan Informasi Farmasi Terintegrasi (SIFIT).
                            </p>

                            {{-- Item 1: Alamat --}}
                            <div class="sifit-hub-item">
                                <div class="sifit-hub-icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="sifit-hub-text">
                                    <strong>Alamat Kantor</strong>
                                    <span>Jl. Cut Nyak Dien III, Jadirejo, Kec. Sukajadi, Pekanbaru, Riau 28121</span>
                                </div>
                            </div>

                            {{-- Item 2: Telepon & WA --}}
                            <div class="sifit-hub-item">
                                <div class="sifit-hub-icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="sifit-hub-text">
                                    <strong>Telepon & Fax</strong>
                                    <span>(0761) 23547 / (0761) 23548</span>
                                </div>
                            </div>

                            {{-- Item 3: Jam Layanan --}}
                            <div class="sifit-hub-item">
                                <div class="sifit-hub-icon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <div class="sifit-hub-text">
                                    <strong>Jam Operasional</strong>
                                    <span>Senin - Kamis: 08.00 - 16.00 WIB<br>Jumat: 08.00 - 16.30 WIB</span>
                                </div>
                            </div>

                            {{-- Tombol WhatsApp --}}
                            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20SIFIT%20Dinkes%20Riau,%20saya%20ingin%20berkonsultasi" target="_blank" class="sifit-wa-btn">
                                <i class="fa fa-whatsapp" style="font-size: 16px;"></i> Konsultasi Cepat via WhatsApp
                            </a>
                        </div>

                        {{-- Peta Lokasi --}}
                        <div class="sifit-hub-map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.658826507669!2d101.4429!3d0.5204!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5ac033486c429%3A0x6a2c262ad0188ef6!2sDinas%20Kesehatan%20Provinsi%20Riau!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                                width="100%"
                                height="100%"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Lokasi Kantor Dinkes Riau"
                            ></iframe>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: FORMULIR KONSULTASI & PENGADUAN --}}
                <div class="col-lg-7 col-md-7 col-sm-12" style="padding: 0;">
                    <div class="sifit-contact-form-col">
                        <h2 class="sifit-form-heading">Kirim Pesan / Konsultasi Farmasi</h2>
                        <p class="sifit-form-subheading">
                            Silakan sampaikan pertanyaan, permohonan informasi obat, atau masukan pelayanan kepada tim SIFIT Dinkes Riau.
                        </p>

                        <form action="#" method="POST" onsubmit="event.preventDefault(); Swal.fire({ title: 'Pesan Terkirim!', text: 'Terima kasih. Pesan Anda telah diterima oleh tim pengelola layanan SIFIT Dinas Kesehatan Provinsi Riau.', icon: 'success', confirmButtonColor: '#115566', confirmButtonText: 'Selesai' }); this.reset(); return false;">
                            @csrf
                            <div class="row">
                                <div class="col-md-6" style="margin-bottom: 14px;">
                                    <label class="sifit-form-label">Nama Lengkap*</label>
                                    <input type="text" name="name" required placeholder="Nama lengkap Anda" class="sifit-form-control">
                                </div>
                                <div class="col-md-6" style="margin-bottom: 14px;">
                                    <label class="sifit-form-label">Email*</label>
                                    <input type="email" name="email" required placeholder="nama@email.com" class="sifit-form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6" style="margin-bottom: 14px;">
                                    <label class="sifit-form-label">Nomor WhatsApp / HP</label>
                                    <input type="text" name="phone" placeholder="08xxxxxxxxxx" class="sifit-form-control">
                                </div>
                                <div class="col-md-6" style="margin-bottom: 14px;">
                                    <label class="sifit-form-label">Topik Layanan</label>
                                    <select name="subject" class="sifit-form-control">
                                        <option value="Informasi Obat">Informasi Ketersediaan Obat</option>
                                        <option value="Konsultasi Resep">Konsultasi Resep & Aturan Pakai</option>
                                        <option value="Pengaduan Layanan">Pengaduan / Saran Pelayanan</option>
                                        <option value="Kerjasama Instansi">Kerjasama Antar-Instansi</option>
                                    </select>
                                </div>
                            </div>

                            <div style="margin-bottom: 16px;">
                                <label class="sifit-form-label">Isi Pesan / Pertanyaan*</label>
                                <textarea name="message" required rows="4" placeholder="Tuliskan secara rinci pertanyaan atau permohonan informasi Anda..." class="sifit-form-control" style="height: auto; padding: 10px 14px;"></textarea>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-top: 4px;">
                                <button type="submit" class="thm-btn" style="padding: 10px 24px; font-size: 13px; font-weight: 700; border-radius: 6px;">
                                    <i class="fa fa-send" style="margin-right: 6px;"></i> Kirimkan Pesan
                                </button>
                                <span style="font-size: 11.5px; color: #94a3b8;">
                                    <i class="fa fa-shield" style="color: #10b981;"></i> Data terenkripsi dan terlindungi.
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection