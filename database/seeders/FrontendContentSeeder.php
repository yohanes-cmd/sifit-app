<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Gallery;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;

class FrontendContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. SITE SETTINGS: Profil Resmi Pemerintahan Berstandar Dinkes Riau
        $settings = [
            // PROFIL & IDENTITAS RESMI
            'tentang_judul' => [
                'value' => 'Profil Resmi Sistem Informasi Farmasi Terintegrasi (SIFIT) Provinsi Riau',
                'group' => 'tentang',
                'label' => 'Judul Profil Resmi',
            ],
            'tentang_tagline' => [
                'value' => 'Sistem Informasi Publik & Tata Kelola Logistik Farmasi Daerah',
                'group' => 'tentang',
                'label' => 'Tagline Pemerintahan',
            ],
            'tentang_instansi' => [
                'value' => 'Dinas Kesehatan Pemerintah Provinsi Riau',
                'group' => 'tentang',
                'label' => 'Nama Instansi Pengelola',
            ],
            'tentang_motto' => [
                'value' => 'Terintegrasi, Akuntabel, dan Transparan Menuju Riau Sehat Bermartabat',
                'group' => 'tentang',
                'label' => 'Motto Pelayanan Publik',
            ],
            'tentang_deskripsi' => [
                'value' => "Sistem Informasi Farmasi Terintegrasi (SIFIT) Provinsi Riau merupakan sarana keterbukaan informasi publik dan transformasi digital tata kelola kefarmasian yang dikembangkan oleh Seksi Kefarmasian & Alat Kesehatan UPT Instalasi Farmasi dan Logistik Kesehatan Dinas Kesehatan Provinsi Riau.\n\nSistem ini dibangun atas amanat Undang-Undang Nomor 17 Tahun 2023 tentang Kesehatan dan Peraturan Menteri Kesehatan RI mengenai Standar Pelayanan Kefarmasian. SIFIT berfungsi ganda:\n1. Sebagai portal informasi publik resmi untuk menjamin hak masyarakat memperoleh edukasi penggunaan obat yang rasional (Gerakan Masyarakat Cerdas Menggunakan Obat - GeMa CerMat dengan prinsip DAGUSIBU).\n2. Sebagai wadah transparansi akuntabilitas publik melalui publikasi warta dinas, kebijakan sediaan farmasi, dan dokumentasi visual penyaluran obat ke seluruh fasilitas pelayanan kesehatan (Puskesmas dan Rumah Sakit Daerah) di 12 Kabupaten/Kota se-Provinsi Riau.",
                'group' => 'tentang',
                'label' => 'Deskripsi Profil Lengkap SIFIT',
            ],

            // VISI & MISI
            'visi_sifit' => [
                'value' => 'Terwujudnya tata kelola informasi dan logistik kefarmasian yang terintegrasi, transparan, akuntabel, dan berdaya jangkau luas guna mendukung pelayanan kesehatan bermutu dan berkeadilan bagi seluruh masyarakat Provinsi Riau.',
                'group' => 'visi_misi',
                'label' => 'Visi Resmi SIFIT',
            ],
            'misi_sifit' => [
                'value' => "Mewujudkan keterbukaan informasi publik terkait kebijakan, regulasi, dan sediaan kefarmasian daerah secara tepat waktu dan tepercaya.\nMeningkatkan literasi dan kemandirian masyarakat dalam penggunaan obat yang tepat dan aman melalui sosialisasi berkelanjutan pedoman DAGUSIBU (Dapatkan, Gunakan, Simpan, dan Buang).\nMengoptimalkan pengawasan serta transparansi rantai pasok dan distribusi obat publik dari instalasi farmasi provinsi hingga fasilitas kesehatan tingkat pertama di 12 Kabupaten/Kota.\nMendukung integrasi data kesehatan terpadu Pemerintah Provinsi Riau berbasis digital demi akuntabilitas tata kelola pemerintahan yang bersih dan melayani.",
                'group' => 'visi_misi',
                'label' => 'Misi Resmi SIFIT (Satu poin per baris)',
            ],

            // SASARAN & TUJUAN LAYANAN STRATEGIS
            'tujuan_1_judul' => [
                'value' => 'Transparansi & Akuntabilitas Logistik',
                'group' => 'tujuan',
                'label' => 'Judul Sasaran 1',
            ],
            'tujuan_1_isi' => [
                'value' => 'Menyajikan keterbukaan tata kelola perbekalan farmasi pemerintah daerah untuk mencegah kekosongan obat dan memastikan distribusi merata di fasilitas pelayanan kesehatan.',
                'group' => 'tujuan',
                'label' => 'Isi Sasaran 1',
            ],
            'tujuan_2_judul' => [
                'value' => 'Edukasi Penggunaan Obat Rasional (DAGUSIBU)',
                'group' => 'tujuan',
                'label' => 'Judul Sasaran 2',
            ],
            'tujuan_2_isi' => [
                'value' => 'Meningkatkan pemahaman masyarakat tentang kepatuhan resep dokter, penyimpanan obat rumah tangga, serta pemusnahan obat kedaluwarsa sesuai regulasi Kemenkes.',
                'group' => 'tujuan',
                'label' => 'Isi Sasaran 2',
            ],
            'tujuan_3_judul' => [
                'value' => 'Kanal Publikasi & Dokumentasi Resmi',
                'group' => 'tujuan',
                'label' => 'Judul Sasaran 3',
            ],
            'tujuan_3_isi' => [
                'value' => 'Menyediakan wadah resmi dokumentasi kegiatan monitoring, pembinaan apoteker, dan penyaluran logistik kesehatan yang dapat dipantau langsung oleh publik.',
                'group' => 'tujuan',
                'label' => 'Isi Sasaran 3',
            ],

            // KONTAK & JAM LAYANAN PEMERINTAHAN
            'kontak_alamat' => [
                'value' => 'Dinas Kesehatan Provinsi Riau, Gedung UPT Instalasi Farmasi, Jl. Cut Nyak Dien No. 03, Kel. Jadirejo, Kec. Sukajadi, Kota Pekanbaru, Riau 28121',
                'group' => 'kontak',
                'label' => 'Alamat Kantor Lengkap',
            ],
            'kontak_telepon' => [
                'value' => '(0761) 23547 / 0811-7500-119',
                'group' => 'kontak',
                'label' => 'Nomor Telepon & Helpdesk',
            ],
            'kontak_email' => [
                'value' => 'dinkes@riau.go.id / farmasi.dinkesriau@gmail.com',
                'group' => 'kontak',
                'label' => 'Alamat Email Resmi',
            ],
            'kontak_jam_layanan' => [
                'value' => 'Senin - Kamis: 08:00 - 16:00 WIB | Jumat: 08:00 - 16:30 WIB',
                'group' => 'kontak',
                'label' => 'Jam Layanan Operasional Kantor',
            ],
            'kontak_maps_embed' => [
                'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.658742880949!2d101.44474707472346!3d0.5124968994825316!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5ac018f6c5ea3%3A0x6b70ad9c3b49e1a8!2sDinas%20Kesehatan%20Provinsi%20Riau!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid',
                'group' => 'kontak',
                'label' => 'URL Embed Google Maps',
            ],
        ];

        foreach ($settings as $key => $data) {
            SiteSetting::set($key, $data['value'], $data['group'], $data['label']);
        }

        // 2. FAQ SEEDER (Pertanyaan Resmi Publikasi Pemerintah)
        $faqs = [
            [
                'question' => 'Apa dasar hukum dan tujuan dibentuknya portal SIFIT Provinsi Riau?',
                'answer' => 'SIFIT (Sistem Informasi Farmasi Terintegrasi) dikembangkan merujuk pada Undang-Undang Nomor 17 Tahun 2023 tentang Kesehatan dan Peraturan Daerah Provinsi Riau tentang Keterbukaan Informasi Publik. Tujuannya adalah menghadirkan satu pintu informasi terpadu terkait tata kelola logistik farmasi daerah, edukasi keselamatan obat (DAGUSIBU), serta publikasi resmi kegiatan kefarmasian bagi faskes dan masyarakat luas.',
                'order' => 1,
            ],
            [
                'question' => 'Apakah masyarakat dapat membeli atau memesan sediaan farmasi langsung dari website SIFIT?',
                'answer' => 'Tidak. SIFIT merupakan portal resmi pemerintah daerah untuk transparansi informasi publik, monitoring logistik, dan edukasi kesehatan. SIFIT bukan fasilitas kefarmasian niaga atau apotek daring komersial. Untuk memperoleh obat, masyarakat dapat mendatangi fasilitas pelayanan kesehatan berizin seperti Puskesmas, Rumah Sakit, dan Apotek resmi dengan membawa resep dokter atau petunjuk apoteker.',
                'order' => 2,
            ],
            [
                'question' => 'Apa itu pedoman DAGUSIBU dan mengapa sangat dianjurkan oleh Dinas Kesehatan?',
                'answer' => 'DAGUSIBU adalah akronim dari Dapatkan, Gunakan, Simpan, dan Buang yang merupakan pedoman resmi Kementerian Kesehatan RI dalam Gerakan Masyarakat Cerdas Menggunakan Obat (GeMa CerMat). Pedoman ini mengedukasi masyarakat agar: (1) Mendapatkan obat dari sarana resmi berizin, (2) Menggunakan obat sesuai dosis dan indikasi medis, (3) Menyimpan obat pada suhu dan wadah yang tepat, serta (4) Membuang sisa obat kedaluwarsa secara aman guna mencegah penyalahgunaan obat dan pencemaran lingkungan.',
                'order' => 3,
            ],
            [
                'question' => 'Fasilitas apa saja yang terhubung dalam koordinasi distribusi UPT Instalasi Farmasi Provinsi Riau?',
                'answer' => 'UPT Instalasi Farmasi dan Pengelolaan Logistik Kesehatan Dinas Kesehatan Provinsi Riau mengoordinasikan penerimaan, penyimpanan standar Cara Distribusi Obat yang Baik (CDOB), dan penyaluran logistik obat program pemerintah ke Gudang Farmasi Kabupaten/Kota, Puskesmas, serta Rumah Sakit Umum Daerah (RSUD) di 12 Kabupaten/Kota se-Provinsi Riau.',
                'order' => 4,
            ],
            [
                'question' => 'Bagaimana mekanisme penyampaian pengaduan atau permohonan informasi kefarmasian publik?',
                'answer' => 'Permohonan informasi dan konsultasi kefarmasian dapat disampaikan secara resmi melalui Formulir Pengaduan pada menu "Kontak Kami", menghubungi Call Center (0761) 23547 / WhatsApp resmi, atau datang langsung ke Gedung UPT Instalasi Farmasi Dinkes Riau pada jam operasional kedinasan (Senin–Jumat).',
                'order' => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'order' => $faq['order'],
                    'is_active' => true,
                ]
            );
        }

        // 3. SAMPLE GALLERIES (Dokumentasi Resmi Kegiatan Pemerintahan)
        $firstUser = User::first();
        $userId = $firstUser ? $firstUser->id : 1;

        $samples = [
            [
                'title' => 'Monitoring dan Evaluasi Kelayakan Ruang Penyimpanan Suhu Dingin (Cold Chain) Instalasi Farmasi',
                'type' => 'photo',
                'file_path' => null,
                'youtube_url' => null,
                'description' => 'Pelaksanaan inspeksi berkala terhadap sarana cold chain dan chiller vaksin di UPT Instalasi Farmasi Provinsi Riau guna memastikan stabilitas mutu obat dan vaksin sensitif suhu sesuai standar Cara Distribusi Obat yang Baik (CDOB) Badan POM RI.',
            ],
            [
                'title' => 'Sosialisasi GeMa CerMat dan Pendampingan Penggunaan Obat Rasional bagi Kader Kesehatan Kabupaten/Kota',
                'type' => 'photo',
                'file_path' => null,
                'youtube_url' => null,
                'description' => 'Kegiatan bimbingan teknis peningkatan kapasitas apoteker fasilitator dan kader kesehatan masyarakat dalam mengedukasi pencegahan resistensi antimikroba dan penerapan perilaku DAGUSIBU di lingkungan keluarga.',
            ],
            [
                'title' => 'Video Edukasi Pengelolaan Obat Kedaluwarsa dan Pencegahan Pencemaran Lingkungan di Rumah Tangga',
                'type' => 'video',
                'file_path' => null,
                'youtube_url' => 'https://www.youtube.com/watch?v=21X5lGlDOfg',
                'description' => 'Materi sosialisasi audio-visual tentang langkah-langkah aman merusak kemasan, memisahkan label obat, dan memusnahkan sediaan obat kadaluwarsa di tingkat rumah tangga agar tidak disalahgunakan atau mencemari ekosistem air tanah.',
            ],
        ];

        foreach ($samples as $sample) {
            Gallery::updateOrCreate(
                ['title' => $sample['title']],
                [
                    'user_id' => $userId,
                    'type' => $sample['type'],
                    'file_path' => $sample['file_path'],
                    'youtube_url' => $sample['youtube_url'],
                    'description' => $sample['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
