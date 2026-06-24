<?php

namespace Database\Seeders;

use App\Models\Berkas;
use App\Models\Departemen;
use App\Models\Inventaris;
use App\Models\NotulensiRapat;
use App\Models\PeminjamanInventaris;
use App\Models\Presensi;
use App\Models\ProgramKerja;
use App\Models\RapatAkbar;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================================
        // 1. DEPARTEMEN
        // ============================================================
        $departemens = [
            ['nama_departemen' => 'Presidium',   'deskripsi' => 'Pimpinan organisasi mahasiswa yang mengkoordinasikan seluruh kegiatan organisasi.', 'icon' => 'star'],
            ['nama_departemen' => 'PSDM',        'deskripsi' => 'Pengembangan Sumber Daya Manusia, bertanggung jawab atas rekrutmen dan pelatihan anggota.', 'icon' => 'users'],
            ['nama_departemen' => 'Media',       'deskripsi' => 'Mengelola publikasi, dokumentasi, dan media komunikasi organisasi.', 'icon' => 'camera'],
            ['nama_departemen' => 'Pendidikan',  'deskripsi' => 'Mengelola program pendidikan, pelatihan akademik, dan peningkatan kompetensi anggota.', 'icon' => 'academic-cap'],
            ['nama_departemen' => 'Inventaris',  'deskripsi' => 'Mengelola seluruh aset dan inventaris organisasi mahasiswa.', 'icon' => 'archive-box'],
        ];

        foreach ($departemens as $dep) {
            Departemen::create($dep);
        }

        $depPresidium   = Departemen::where('nama_departemen', 'Presidium')->first();
        $depPSDM        = Departemen::where('nama_departemen', 'PSDM')->first();
        $depMedia       = Departemen::where('nama_departemen', 'Media')->first();
        $depPendidikan  = Departemen::where('nama_departemen', 'Pendidikan')->first();
        $depInventaris  = Departemen::where('nama_departemen', 'Inventaris')->first();

        // ============================================================
        // 2. USERS (Admin + 30 Anggota)
        // ============================================================

        // Admin Utama
        $admin = User::create([
            'name' => 'Admin SIMOM',
            'email' => 'admin@simom.ac.id',
            'password' => Hash::make('password'),
            'nim' => '2021001001',
            'no_hp' => '081234567890',
            'angkatan' => '2021',
            'jabatan' => 'Ketua Umum',
            'role' => 'admin',
            'departemen_id' => $depPresidium->id,
        ]);

        // Anggota per departemen (6 orang masing-masing)
        $anggotaData = [
            // Presidium (6 orang)
            ['name' => 'Rafi Ardian Saputra',    'nim' => '2021001002', 'angkatan' => '2021', 'jabatan' => 'Kepala Departemen', 'role' => 'kepala_departemen', 'departemen_id' => $depPresidium->id],
            ['name' => 'Nadia Kusuma Dewi',       'nim' => '2021001003', 'angkatan' => '2021', 'jabatan' => 'Sekretaris',        'role' => 'anggota',           'departemen_id' => $depPresidium->id],
            ['name' => 'Bagas Prasetyo Nugroho',  'nim' => '2022001004', 'angkatan' => '2022', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPresidium->id],
            ['name' => 'Siti Rahayu Ningsih',     'nim' => '2022001005', 'angkatan' => '2022', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPresidium->id],
            ['name' => 'Dimas Fajar Wicaksono',   'nim' => '2023001006', 'angkatan' => '2023', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPresidium->id],
            ['name' => 'Anisa Putri Handayani',   'nim' => '2023001007', 'angkatan' => '2023', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPresidium->id],

            // PSDM (6 orang)
            ['name' => 'Rizky Maulana Hakim',     'nim' => '2021002001', 'angkatan' => '2021', 'jabatan' => 'Kepala Departemen', 'role' => 'kepala_departemen', 'departemen_id' => $depPSDM->id],
            ['name' => 'Dwi Anggraini Putri',     'nim' => '2021002002', 'angkatan' => '2021', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPSDM->id],
            ['name' => 'Fajar Nurul Hidayat',     'nim' => '2022002003', 'angkatan' => '2022', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPSDM->id],
            ['name' => 'Mega Wulandari Sari',     'nim' => '2022002004', 'angkatan' => '2022', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPSDM->id],
            ['name' => 'Andika Surya Pratama',    'nim' => '2023002005', 'angkatan' => '2023', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPSDM->id],
            ['name' => 'Yuni Rahmawati Azizah',   'nim' => '2023002006', 'angkatan' => '2023', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPSDM->id],

            // Media (6 orang)
            ['name' => 'Gilang Permana Putra',    'nim' => '2021003001', 'angkatan' => '2021', 'jabatan' => 'Kepala Departemen', 'role' => 'kepala_departemen', 'departemen_id' => $depMedia->id],
            ['name' => 'Putri Ayu Lestari',       'nim' => '2021003002', 'angkatan' => '2021', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depMedia->id],
            ['name' => 'Ihsan Maulana Yusuf',     'nim' => '2022003003', 'angkatan' => '2022', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depMedia->id],
            ['name' => 'Rina Febriani Susanti',   'nim' => '2022003004', 'angkatan' => '2022', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depMedia->id],
            ['name' => 'Kevin Ardiansyah',        'nim' => '2023003005', 'angkatan' => '2023', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depMedia->id],
            ['name' => 'Fitriani Nur Cahyani',    'nim' => '2023003006', 'angkatan' => '2023', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depMedia->id],

            // Pendidikan (6 orang)
            ['name' => 'Arif Budi Santoso',       'nim' => '2021004001', 'angkatan' => '2021', 'jabatan' => 'Kepala Departemen', 'role' => 'kepala_departemen', 'departemen_id' => $depPendidikan->id],
            ['name' => 'Riska Amalia Dewi',       'nim' => '2021004002', 'angkatan' => '2021', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPendidikan->id],
            ['name' => 'Wahyu Eko Prabowo',       'nim' => '2022004003', 'angkatan' => '2022', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPendidikan->id],
            ['name' => 'Laila Nur Fadilah',       'nim' => '2022004004', 'angkatan' => '2022', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPendidikan->id],
            ['name' => 'Surya Adi Kusuma',        'nim' => '2023004005', 'angkatan' => '2023', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPendidikan->id],
            ['name' => 'Desi Ratnasari',          'nim' => '2023004006', 'angkatan' => '2023', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depPendidikan->id],

            // Inventaris (6 orang)
            ['name' => 'Hendra Gunawan Wijaya',   'nim' => '2021005001', 'angkatan' => '2021', 'jabatan' => 'Kepala Departemen', 'role' => 'kepala_inventaris', 'departemen_id' => $depInventaris->id],
            ['name' => 'Tika Rahmadani',          'nim' => '2021005002', 'angkatan' => '2021', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depInventaris->id],
            ['name' => 'Bimo Prasetya Aji',       'nim' => '2022005003', 'angkatan' => '2022', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depInventaris->id],
            ['name' => 'Indah Permata Sari',      'nim' => '2022005004', 'angkatan' => '2022', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depInventaris->id],
            ['name' => 'Yoga Dwi Prakoso',        'nim' => '2023005005', 'angkatan' => '2023', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depInventaris->id],
            ['name' => 'Niken Ayu Pratiwi',       'nim' => '2023005006', 'angkatan' => '2023', 'jabatan' => 'Staff',             'role' => 'anggota',           'departemen_id' => $depInventaris->id],
        ];

        $emailDomains = ['@student.simom.ac.id'];
        foreach ($anggotaData as $a) {
            $email = strtolower(str_replace(' ', '.', $a['name'])) . $emailDomains[0];
            User::create([
                'name'         => $a['name'],
                'email'        => $email,
                'password'     => Hash::make('password'),
                'nim'          => $a['nim'],
                'no_hp'        => '08' . rand(100000000, 999999999),
                'angkatan'     => $a['angkatan'],
                'jabatan'      => $a['jabatan'],
                'role'         => $a['role'],
                'departemen_id'=> $a['departemen_id'],
            ]);
        }

        // ============================================================
        // 3. PROGRAM KERJA (15 proker)
        // ============================================================
        $prokerData = [
            // Presidium (5 proker)
            ['nama_proker' => 'Musyawarah Besar Organisasi',        'departemen_id' => $depPresidium->id,  'pic' => 'Rafi Ardian Saputra',   'tanggal_mulai' => '2024-02-01', 'tanggal_selesai' => '2024-03-15', 'status' => 'Selesai',      'progress' => 100, 'deskripsi' => 'Musyawarah besar tahunan organisasi mahasiswa untuk evaluasi dan perencanaan.'],
            ['nama_proker' => 'Rapat Koordinasi Bulanan',           'departemen_id' => $depPresidium->id,  'pic' => 'Rafi Ardian Saputra',   'tanggal_mulai' => '2024-03-01', 'tanggal_selesai' => '2024-12-31', 'status' => 'Berjalan',     'progress' => 60,  'deskripsi' => 'Rapat koordinasi rutin seluruh kepala departemen setiap bulan.'],
            ['nama_proker' => 'Pelantikan Pengurus Baru',           'departemen_id' => $depPresidium->id,  'pic' => 'Nadia Kusuma Dewi',     'tanggal_mulai' => '2024-04-01', 'tanggal_selesai' => '2024-04-30', 'status' => 'Selesai',      'progress' => 100, 'deskripsi' => 'Pelantikan resmi pengurus organisasi periode baru.'],
            ['nama_proker' => 'Studi Banding ke Universitas Lain',  'departemen_id' => $depPresidium->id,  'pic' => 'Bagas Prasetyo Nugroho','tanggal_mulai' => '2024-07-01', 'tanggal_selesai' => '2024-08-31', 'status' => 'Perencanaan',  'progress' => 20,  'deskripsi' => 'Kunjungan studi banding ke organisasi mahasiswa universitas lain.'],
            ['nama_proker' => 'Evaluasi Akhir Tahun',               'departemen_id' => $depPresidium->id,  'pic' => 'Rafi Ardian Saputra',   'tanggal_mulai' => '2024-11-01', 'tanggal_selesai' => '2024-12-15', 'status' => 'Perencanaan',  'progress' => 10,  'deskripsi' => 'Evaluasi capaian seluruh departemen di akhir tahun kepengurusan.'],

            // PSDM (4 proker)
            ['nama_proker' => 'Orientasi Anggota Baru',             'departemen_id' => $depPSDM->id,       'pic' => 'Rizky Maulana Hakim',   'tanggal_mulai' => '2024-02-15', 'tanggal_selesai' => '2024-03-31', 'status' => 'Selesai',      'progress' => 100, 'deskripsi' => 'Program orientasi dan pengenalan organisasi kepada anggota baru.'],
            ['nama_proker' => 'Pelatihan Leadership & Soft Skill',  'departemen_id' => $depPSDM->id,       'pic' => 'Dwi Anggraini Putri',   'tanggal_mulai' => '2024-05-01', 'tanggal_selesai' => '2024-06-30', 'status' => 'Berjalan',     'progress' => 70,  'deskripsi' => 'Workshop pengembangan jiwa kepemimpinan dan soft skill anggota.'],
            ['nama_proker' => 'Assessment Anggota Tahunan',         'departemen_id' => $depPSDM->id,       'pic' => 'Rizky Maulana Hakim',   'tanggal_mulai' => '2024-09-01', 'tanggal_selesai' => '2024-10-31', 'status' => 'Perencanaan',  'progress' => 30,  'deskripsi' => 'Penilaian kinerja dan keaktifan seluruh anggota organisasi.'],
            ['nama_proker' => 'Gathering & Team Building',          'departemen_id' => $depPSDM->id,       'pic' => 'Fajar Nurul Hidayat',   'tanggal_mulai' => '2024-08-01', 'tanggal_selesai' => '2024-08-31', 'status' => 'Perencanaan',  'progress' => 15,  'deskripsi' => 'Kegiatan gathering dan team building seluruh anggota organisasi.'],

            // Media (5 proker)
            ['nama_proker' => 'Redesain Media Sosial Organisasi',   'departemen_id' => $depMedia->id,      'pic' => 'Gilang Permana Putra',  'tanggal_mulai' => '2024-01-15', 'tanggal_selesai' => '2024-02-28', 'status' => 'Selesai',      'progress' => 100, 'deskripsi' => 'Peremajaan tampilan dan konten media sosial organisasi.'],
            ['nama_proker' => 'Pembuatan Profil Video Organisasi',  'departemen_id' => $depMedia->id,      'pic' => 'Ihsan Maulana Yusuf',   'tanggal_mulai' => '2024-03-01', 'tanggal_selesai' => '2024-04-30', 'status' => 'Selesai',      'progress' => 100, 'deskripsi' => 'Produksi video profil resmi organisasi mahasiswa.'],
            ['nama_proker' => 'Konten Edukasi Digital Bulanan',     'departemen_id' => $depMedia->id,      'pic' => 'Putri Ayu Lestari',     'tanggal_mulai' => '2024-03-01', 'tanggal_selesai' => '2024-12-31', 'status' => 'Berjalan',     'progress' => 55,  'deskripsi' => 'Pembuatan dan publikasi konten edukasi di platform digital setiap bulan.'],
            ['nama_proker' => 'Dokumentasi Kegiatan Organisasi',    'departemen_id' => $depMedia->id,      'pic' => 'Rina Febriani Susanti',  'tanggal_mulai' => '2024-01-01', 'tanggal_selesai' => '2024-12-31', 'status' => 'Berjalan',     'progress' => 65,  'deskripsi' => 'Pendokumentasian semua kegiatan organisasi sepanjang tahun.'],
            ['nama_proker' => 'Newsletter Bulanan Digital',         'departemen_id' => $depMedia->id,      'pic' => 'Kevin Ardiansyah',      'tanggal_mulai' => '2024-06-01', 'tanggal_selesai' => '2024-12-31', 'status' => 'Perencanaan',  'progress' => 25,  'deskripsi' => 'Penerbitan newsletter digital berisi info dan prestasi organisasi.'],

            // Pendidikan (3 proker)
            ['nama_proker' => 'Seminar Nasional Teknik Informatika', 'departemen_id' => $depPendidikan->id, 'pic' => 'Arif Budi Santoso',     'tanggal_mulai' => '2024-05-01', 'tanggal_selesai' => '2024-07-31', 'status' => 'Berjalan',     'progress' => 45,  'deskripsi' => 'Penyelenggaraan seminar nasional dengan narasumber dari industri teknologi.'],
            ['nama_proker' => 'Pelatihan Sertifikasi IT',           'departemen_id' => $depPendidikan->id, 'pic' => 'Wahyu Eko Prabowo',     'tanggal_mulai' => '2024-07-01', 'tanggal_selesai' => '2024-09-30', 'status' => 'Perencanaan',  'progress' => 20,  'deskripsi' => 'Workshop persiapan ujian sertifikasi teknologi informasi untuk anggota.'],
            ['nama_proker' => 'Bimbel & Mentoring Akademik',        'departemen_id' => $depPendidikan->id, 'pic' => 'Arif Budi Santoso',     'tanggal_mulai' => '2024-02-01', 'tanggal_selesai' => '2024-06-30', 'status' => 'Selesai',      'progress' => 100, 'deskripsi' => 'Program bimbingan belajar dan mentoring untuk anggota semester awal.'],

            // Inventaris (3 proker)
            ['nama_proker' => 'Pendataan & Audit Inventaris',       'departemen_id' => $depInventaris->id, 'pic' => 'Hendra Gunawan Wijaya', 'tanggal_mulai' => '2024-01-15', 'tanggal_selesai' => '2024-02-28', 'status' => 'Selesai',      'progress' => 100, 'deskripsi' => 'Pendataan ulang dan audit menyeluruh seluruh aset organisasi.'],
            ['nama_proker' => 'Pengadaan Peralatan Baru',           'departemen_id' => $depInventaris->id, 'pic' => 'Tika Rahmadani',        'tanggal_mulai' => '2024-04-01', 'tanggal_selesai' => '2024-06-30', 'status' => 'Berjalan',     'progress' => 80,  'deskripsi' => 'Pengadaan peralatan dan perlengkapan baru untuk mendukung kegiatan organisasi.'],
            ['nama_proker' => 'Pemeliharaan & Perawatan Aset',      'departemen_id' => $depInventaris->id, 'pic' => 'Bimo Prasetya Aji',     'tanggal_mulai' => '2024-03-01', 'tanggal_selesai' => '2024-12-31', 'status' => 'Berjalan',     'progress' => 50,  'deskripsi' => 'Program rutin pemeliharaan dan perawatan seluruh aset inventaris organisasi.'],
        ];

        foreach ($prokerData as $pk) {
            ProgramKerja::create($pk);
        }

        // ============================================================
        // 4. RAPAT AKBAR (9 rapat)
        // ============================================================
        $rapatData = [
            ['nama_rapat' => 'Rapat Akbar Perdana 2024',              'tanggal' => '2024-02-10', 'waktu' => '09:00', 'lokasi' => 'Aula Gedung A Lt. 3',       'agenda' => "1. Pembukaan dan sambutan\n2. Laporan awal kepengurusan\n3. Pemaparan program kerja seluruh departemen\n4. Diskusi dan tanya jawab\n5. Penutup",              'status' => 'Selesai'],
            ['nama_rapat' => 'Rapat Evaluasi Triwulan I',              'tanggal' => '2024-03-28', 'waktu' => '13:00', 'lokasi' => 'Ruang Rapat Utama',          'agenda' => "1. Evaluasi proker Januari-Maret\n2. Laporan per departemen\n3. Pembahasan kendala\n4. Rencana ke depan",                                                    'status' => 'Selesai'],
            ['nama_rapat' => 'Rapat Persiapan Seminar Nasional',       'tanggal' => '2024-05-15', 'waktu' => '10:00', 'lokasi' => 'Sekretariat BEM Lt. 2',      'agenda' => "1. Pembahasan teknis seminar\n2. Pembagian tugas panitia\n3. Anggaran seminar\n4. Promosi dan publikasi",                                              'status' => 'Selesai'],
            ['nama_rapat' => 'Rapat Akbar Tengah Tahun',               'tanggal' => '2024-06-20', 'waktu' => '09:00', 'lokasi' => 'Auditorium Utama',           'agenda' => "1. Evaluasi semester I\n2. Laporan keuangan\n3. Pencapaian dan hambatan\n4. Target semester II",                                                         'status' => 'Selesai'],
            ['nama_rapat' => 'Rapat Koordinasi Persiapan Ospek',       'tanggal' => '2024-07-10', 'waktu' => '14:00', 'lokasi' => 'Ruang Meeting Dekanat',      'agenda' => "1. Persiapan OSPEK mahasiswa baru\n2. Koordinasi kepanitiaan\n3. Teknis pelaksanaan\n4. Briefing panitia",                                              'status' => 'Selesai'],
            ['nama_rapat' => 'Rapat Evaluasi Program PSDM',            'tanggal' => '2024-08-05', 'waktu' => '13:30', 'lokasi' => 'Sekretariat BEM Lt. 2',      'agenda' => "1. Evaluasi orientasi anggota baru\n2. Review pelatihan leadership\n3. Rencana assessment\n4. Gathering anggota",                                     'status' => 'Berlangsung'],
            ['nama_rapat' => 'Rapat Akbar Triwulan III',               'tanggal' => '2024-09-25', 'waktu' => '09:00', 'lokasi' => 'Aula Gedung A Lt. 3',       'agenda' => "1. Evaluasi proker Juli-September\n2. Update status inventaris\n3. Laporan media sosial\n4. Persiapan evaluasi akhir tahun",                          'status' => 'Dijadwalkan'],
            ['nama_rapat' => 'Rapat Persiapan Akhir Tahun',            'tanggal' => '2024-11-15', 'waktu' => '10:00', 'lokasi' => 'Ruang Rapat Utama',          'agenda' => "1. Persiapan evaluasi akhir tahun\n2. Laporan pertanggungjawaban\n3. Rencana serah terima kepengurusan\n4. Persiapan Musyawarah Besar",              'status' => 'Dijadwalkan'],
            ['nama_rapat' => 'Musyawarah Besar Akhir Tahun 2024',      'tanggal' => '2024-12-10', 'waktu' => '08:00', 'lokasi' => 'Auditorium Utama',           'agenda' => "1. LPJ kepengurusan 2024\n2. Pemilihan ketua baru\n3. Penetapan AD/ART\n4. Serah terima kepengurusan\n5. Penutupan",                                  'status' => 'Dijadwalkan'],
        ];

        $allUsers = User::all();

        foreach ($rapatData as $r) {
            $rapat = RapatAkbar::create($r);

            // Buat presensi untuk semua user
            foreach ($allUsers as $user) {
                $statusOptions = ['Hadir', 'Hadir', 'Hadir', 'Izin', 'Tidak Hadir'];
                $status = $r['status'] === 'Dijadwalkan' ? 'Tidak Hadir' : $statusOptions[array_rand($statusOptions)];
                Presensi::create([
                    'rapat_akbar_id' => $rapat->id,
                    'user_id'        => $user->id,
                    'status'         => $status,
                    'keterangan'     => $status === 'Izin' ? 'Ada kepentingan mendadak' : null,
                ]);
            }

            // Buat notulensi untuk rapat yang sudah selesai
            if ($r['status'] === 'Selesai') {
                NotulensiRapat::create([
                    'rapat_akbar_id'  => $rapat->id,
                    'judul_notulensi' => 'Notulensi ' . $r['nama_rapat'],
                    'isi_notulensi'   => '<h2>Ringkasan ' . $r['nama_rapat'] . '</h2><p>Rapat berlangsung pada ' . $r['tanggal'] . ' pukul ' . $r['waktu'] . ' di ' . $r['lokasi'] . '.</p><h3>Hasil Rapat</h3><ul><li>Seluruh agenda telah dibahas dengan baik.</li><li>Semua departemen memaparkan progress kerja masing-masing.</li><li>Diperoleh beberapa keputusan strategis untuk kemajuan organisasi.</li><li>Tindak lanjut ditetapkan dan akan dipantau pada rapat berikutnya.</li></ul><h3>Keputusan</h3><p>Rapat berjalan lancar dan semua poin agenda berhasil diselesaikan. Seluruh keputusan bersifat mengikat dan wajib ditindaklanjuti oleh masing-masing departemen.</p>',
                    'penulis_id'      => $admin->id,
                    'tanggal'         => $r['tanggal'],
                ]);
            }
        }

        // ============================================================
        // 5. INVENTARIS (15 barang)
        // ============================================================
        $inventarisData = [
            ['nama_barang' => 'Laptop Asus VivoBook',      'kategori' => 'Elektronik',    'jumlah' => 3,  'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Lemari A - Rak 1', 'status' => 'Tersedia',    'keterangan' => 'Digunakan untuk presentasi dan dokumentasi'],
            ['nama_barang' => 'Proyektor Epson EB-X51',    'kategori' => 'Elektronik',    'jumlah' => 2,  'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Lemari A - Rak 2', 'status' => 'Dipinjam',    'keterangan' => 'Proyektor HD untuk seminar dan rapat'],
            ['nama_barang' => 'Kamera Canon EOS 800D',     'kategori' => 'Elektronik',    'jumlah' => 2,  'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Lemari B - Rak 1', 'status' => 'Tersedia',    'keterangan' => 'Kamera DSLR untuk dokumentasi kegiatan'],
            ['nama_barang' => 'Tripod Kamera',             'kategori' => 'Perlengkapan',  'jumlah' => 3,  'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Lemari B - Rak 2', 'status' => 'Tersedia',    'keterangan' => null],
            ['nama_barang' => 'Microphone Wireless',       'kategori' => 'Elektronik',    'jumlah' => 4,  'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Lemari A - Rak 3', 'status' => 'Tersedia',    'keterangan' => 'Mic wireless 2 channel untuk acara'],
            ['nama_barang' => 'Whiteboard Portable',       'kategori' => 'Perlengkapan',  'jumlah' => 2,  'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Gudang Sekretariat', 'status' => 'Tersedia',   'keterangan' => null],
            ['nama_barang' => 'Banner Stand Roll-Up',      'kategori' => 'Perlengkapan',  'jumlah' => 4,  'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Gudang Sekretariat', 'status' => 'Tersedia',   'keterangan' => 'Banner stand untuk acara dan pameran'],
            ['nama_barang' => 'Printer Canon PIXMA',       'kategori' => 'Elektronik',    'jumlah' => 1,  'kondisi' => 'Rusak Ringan',  'lokasi_penyimpanan' => 'Sekretariat',       'status' => 'Maintenance', 'keterangan' => 'Sedang dalam perbaikan cartridge'],
            ['nama_barang' => 'Speaker Bluetooth JBL',    'kategori' => 'Elektronik',    'jumlah' => 2,  'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Lemari A - Rak 3', 'status' => 'Tersedia',    'keterangan' => null],
            ['nama_barang' => 'Meja Lipat Portable',       'kategori' => 'Perlengkapan',  'jumlah' => 10, 'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Gudang Sekretariat', 'status' => 'Tersedia',   'keterangan' => 'Meja lipat untuk keperluan bazar/stand'],
            ['nama_barang' => 'Kursi Lipat',               'kategori' => 'Perlengkapan',  'jumlah' => 30, 'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Gudang Sekretariat', 'status' => 'Tersedia',   'keterangan' => null],
            ['nama_barang' => 'Stempel Organisasi',        'kategori' => 'ATK',           'jumlah' => 2,  'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Laci Sekretariat',  'status' => 'Tersedia',    'keterangan' => null],
            ['nama_barang' => 'Alat Tulis (Set)',          'kategori' => 'ATK',           'jumlah' => 5,  'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Laci Sekretariat',  'status' => 'Tersedia',    'keterangan' => 'Bolpoin, spidol, penggaris, dll'],
            ['nama_barang' => 'Spanduk Acara (Set)',       'kategori' => 'Dokumentasi',   'jumlah' => 3,  'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Lemari C',          'status' => 'Tersedia',    'keterangan' => 'Spanduk blank untuk berbagai acara'],
            ['nama_barang' => 'Hard Disk External 1TB',   'kategori' => 'Elektronik',    'jumlah' => 2,  'kondisi' => 'Baik',          'lokasi_penyimpanan' => 'Lemari B - Rak 1', 'status' => 'Tersedia',    'keterangan' => 'Penyimpanan arsip digital organisasi'],
        ];

        foreach ($inventarisData as $inv) {
            Inventaris::create($inv);
        }

        // ============================================================
        // 6. PEMINJAMAN INVENTARIS (10 pengajuan)
        // ============================================================
        $kepalaPresidium   = User::where('departemen_id', $depPresidium->id)->whereIn('role', ['kepala_departemen'])->first();
        $kepalaPSDM        = User::where('departemen_id', $depPSDM->id)->where('role', 'kepala_departemen')->first();
        $kepalaMedia       = User::where('departemen_id', $depMedia->id)->where('role', 'kepala_departemen')->first();
        $kepalaPendidikan  = User::where('departemen_id', $depPendidikan->id)->where('role', 'kepala_departemen')->first();
        $kepalaInventaris  = User::where('departemen_id', $depInventaris->id)->where('role', 'kepala_inventaris')->first();

        $proyektor = Inventaris::where('nama_barang', 'like', '%Proyektor%')->first();
        $laptop    = Inventaris::where('nama_barang', 'like', '%Laptop%')->first();
        $kamera    = Inventaris::where('nama_barang', 'like', '%Kamera%')->first();
        $speaker   = Inventaris::where('nama_barang', 'like', '%Speaker%')->first();
        $mic       = Inventaris::where('nama_barang', 'like', '%Microphone%')->first();
        $meja      = Inventaris::where('nama_barang', 'like', '%Meja%')->first();

        $peminjamanData = [
            ['peminjam_id' => $kepalaMedia->id,      'departemen_id' => $depMedia->id,      'inventaris_id' => $proyektor->id, 'jumlah' => 1, 'tanggal_pinjam' => '2024-05-10', 'tanggal_kembali' => '2024-05-12', 'alasan' => 'Untuk presentasi pada Seminar Nasional Teknik Informatika', 'status_pengajuan' => 'Approved', 'approved_by' => $kepalaInventaris->id, 'approved_at' => now()],
            ['peminjam_id' => $kepalaPSDM->id,       'departemen_id' => $depPSDM->id,       'inventaris_id' => $laptop->id,    'jumlah' => 2, 'tanggal_pinjam' => '2024-05-20', 'tanggal_kembali' => '2024-05-22', 'alasan' => 'Pelatihan Leadership menggunakan media presentasi PowerPoint', 'status_pengajuan' => 'Approved', 'approved_by' => $admin->id,            'approved_at' => now()],
            ['peminjam_id' => $kepalaMedia->id,      'departemen_id' => $depMedia->id,      'inventaris_id' => $kamera->id,    'jumlah' => 1, 'tanggal_pinjam' => '2024-06-15', 'tanggal_kembali' => '2024-06-17', 'alasan' => 'Dokumentasi Rapat Akbar Tengah Tahun organisasi', 'status_pengajuan' => 'Approved', 'approved_by' => $kepalaInventaris->id, 'approved_at' => now()],
            ['peminjam_id' => $kepalaPendidikan->id, 'departemen_id' => $depPendidikan->id, 'inventaris_id' => $mic->id,       'jumlah' => 2, 'tanggal_pinjam' => '2024-07-05', 'tanggal_kembali' => '2024-07-06', 'alasan' => 'Koordinasi persiapan ospek mahasiswa baru', 'status_pengajuan' => 'Rejected', 'approved_by' => $kepalaInventaris->id, 'approved_at' => now(), 'catatan_approval' => 'Mic sedang digunakan untuk kegiatan lain'],
            ['peminjam_id' => $kepalaPresidium->id,  'departemen_id' => $depPresidium->id,  'inventaris_id' => $speaker->id,   'jumlah' => 1, 'tanggal_pinjam' => '2024-07-10', 'tanggal_kembali' => '2024-07-11', 'alasan' => 'Rapat evaluasi program PSDM', 'status_pengajuan' => 'Approved', 'approved_by' => $admin->id, 'approved_at' => now()],
            ['peminjam_id' => $kepalaPSDM->id,       'departemen_id' => $depPSDM->id,       'inventaris_id' => $meja->id,      'jumlah' => 5, 'tanggal_pinjam' => '2024-08-01', 'tanggal_kembali' => '2024-08-03', 'alasan' => 'Gathering & Team Building anggota organisasi', 'status_pengajuan' => 'Pending', 'approved_by' => null, 'approved_at' => null],
            ['peminjam_id' => $kepalaMedia->id,      'departemen_id' => $depMedia->id,      'inventaris_id' => $laptop->id,    'jumlah' => 1, 'tanggal_pinjam' => '2024-08-10', 'tanggal_kembali' => '2024-08-15', 'alasan' => 'Pengeditan dan produksi konten video profile organisasi', 'status_pengajuan' => 'Pending', 'approved_by' => null, 'approved_at' => null],
            ['peminjam_id' => $kepalaPendidikan->id, 'departemen_id' => $depPendidikan->id, 'inventaris_id' => $proyektor->id, 'jumlah' => 1, 'tanggal_pinjam' => '2024-09-01', 'tanggal_kembali' => '2024-09-03', 'alasan' => 'Pelatihan sertifikasi IT untuk anggota', 'status_pengajuan' => 'Pending', 'approved_by' => null, 'approved_at' => null],
            ['peminjam_id' => $kepalaPresidium->id,  'departemen_id' => $depPresidium->id,  'inventaris_id' => $kamera->id,    'jumlah' => 1, 'tanggal_pinjam' => '2024-09-25', 'tanggal_kembali' => '2024-09-26', 'alasan' => 'Dokumentasi Rapat Akbar Triwulan III', 'status_pengajuan' => 'Pending', 'approved_by' => null, 'approved_at' => null],
            ['peminjam_id' => $kepalaPSDM->id,       'departemen_id' => $depPSDM->id,       'inventaris_id' => $mic->id,       'jumlah' => 2, 'tanggal_pinjam' => '2024-10-05', 'tanggal_kembali' => '2024-10-07', 'alasan' => 'Assessment anggota tahunan memerlukan pengeras suara', 'status_pengajuan' => 'Pending', 'approved_by' => null, 'approved_at' => null],
        ];

        foreach ($peminjamanData as $p) {
            PeminjamanInventaris::create($p);
        }

        // ============================================================
        // 7. BERKAS (18 berkas)
        // ============================================================
        $berkasData = [
            ['judul_berkas' => 'Proposal Seminar Nasional TI 2024',            'kategori' => 'Proposal',      'deskripsi' => 'Proposal kegiatan Seminar Nasional Teknik Informatika 2024',                      'nama_file' => 'Proposal_Semnas_TI_2024.pdf',            'ukuran_file' => '2.3 MB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Proposal Pelatihan Leadership PSDM',           'kategori' => 'Proposal',      'deskripsi' => 'Proposal kegiatan pelatihan leadership dan soft skill anggota',                   'nama_file' => 'Proposal_Pelatihan_Leadership.pdf',      'ukuran_file' => '1.8 MB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Proposal Gathering & Team Building',           'kategori' => 'Proposal',      'deskripsi' => 'Proposal kegiatan gathering dan team building seluruh anggota organisasi',        'nama_file' => 'Proposal_Gathering_2024.pdf',            'ukuran_file' => '1.5 MB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'LPJ Orientasi Anggota Baru 2024',              'kategori' => 'LPJ',           'deskripsi' => 'Laporan pertanggungjawaban kegiatan orientasi anggota baru',                     'nama_file' => 'LPJ_Orientasi_Anggota_2024.pdf',         'ukuran_file' => '3.1 MB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'LPJ Pelantikan Pengurus 2024',                 'kategori' => 'LPJ',           'deskripsi' => 'Laporan pertanggungjawaban kegiatan pelantikan pengurus organisasi',              'nama_file' => 'LPJ_Pelantikan_Pengurus_2024.pdf',       'ukuran_file' => '2.7 MB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'LPJ Musyawarah Besar 2024',                    'kategori' => 'LPJ',           'deskripsi' => 'Laporan pertanggungjawaban kegiatan musyawarah besar organisasi',                 'nama_file' => 'LPJ_Mubes_2024.pdf',                     'ukuran_file' => '4.2 MB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Notulen Rapat Perdana 2024',                   'kategori' => 'Notulen',       'deskripsi' => 'Catatan hasil rapat akbar perdana tahun 2024',                                   'nama_file' => 'Notulen_Rapat_Perdana_2024.docx',        'ukuran_file' => '340 KB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Notulen Rapat Evaluasi Triwulan I',            'kategori' => 'Notulen',       'deskripsi' => 'Catatan hasil rapat evaluasi triwulan pertama 2024',                             'nama_file' => 'Notulen_Evaluasi_TW1_2024.docx',         'ukuran_file' => '420 KB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Notulen Rapat Tengah Tahun',                   'kategori' => 'Notulen',       'deskripsi' => 'Catatan hasil rapat akbar tengah tahun 2024',                                    'nama_file' => 'Notulen_Tengah_Tahun_2024.docx',         'ukuran_file' => '380 KB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Surat Keputusan Pengurus 2024',                'kategori' => 'Surat',         'deskripsi' => 'SK resmi penetapan pengurus organisasi mahasiswa periode 2024',                  'nama_file' => 'SK_Pengurus_2024.pdf',                   'ukuran_file' => '890 KB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Surat Permohonan Peminjaman Aula',             'kategori' => 'Surat',         'deskripsi' => 'Surat permohonan peminjaman aula untuk kegiatan seminar nasional',               'nama_file' => 'Surat_Peminjaman_Aula.pdf',              'ukuran_file' => '210 KB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Surat Undangan Seminar Nasional',              'kategori' => 'Surat',         'deskripsi' => 'Surat undangan resmi untuk peserta seminar nasional TI 2024',                    'nama_file' => 'Surat_Undangan_Semnas.pdf',              'ukuran_file' => '195 KB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Surat Kerjasama Sponsor Seminar',              'kategori' => 'Surat',         'deskripsi' => 'Surat kerjasama dengan sponsor untuk mendukung seminar nasional',                'nama_file' => 'Surat_Kerjasama_Sponsor.pdf',            'ukuran_file' => '225 KB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Dokumentasi Foto Pelantikan Pengurus',         'kategori' => 'Dokumentasi',   'deskripsi' => 'Kumpulan foto dokumentasi kegiatan pelantikan pengurus baru 2024',               'nama_file' => 'Foto_Pelantikan_2024.zip',               'ukuran_file' => '45.2 MB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Dokumentasi Foto Seminar Nasional',            'kategori' => 'Dokumentasi',   'deskripsi' => 'Kumpulan foto dan video dokumentasi kegiatan seminar nasional TI',               'nama_file' => 'Dokumentasi_Semnas_TI.zip',              'ukuran_file' => '78.5 MB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Dokumentasi Foto Rapat Perdana',               'kategori' => 'Dokumentasi',   'deskripsi' => 'Foto-foto kegiatan rapat akbar perdana tahun kepengurusan 2024',                 'nama_file' => 'Dokumentasi_Rapat_Perdana.zip',          'ukuran_file' => '22.8 MB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Anggaran Dasar & Anggaran Rumah Tangga',       'kategori' => 'Dokumentasi',   'deskripsi' => 'Dokumen AD/ART organisasi mahasiswa yang berlaku saat ini',                      'nama_file' => 'ADART_Organisasi_2024.pdf',              'ukuran_file' => '1.2 MB', 'uploaded_by' => $admin->id],
            ['judul_berkas' => 'Rencana Program Kerja Semester II',            'kategori' => 'Proposal',      'deskripsi' => 'Dokumen perencanaan program kerja seluruh departemen untuk semester kedua 2024',  'nama_file' => 'Rencana_Proker_Semester2.xlsx',          'ukuran_file' => '680 KB', 'uploaded_by' => $admin->id],
        ];

        foreach ($berkasData as $b) {
            Berkas::create([
                'judul_berkas' => $b['judul_berkas'],
                'kategori'     => $b['kategori'],
                'deskripsi'    => $b['deskripsi'],
                'file_path'    => 'berkas/dummy_' . $b['nama_file'],
                'nama_file'    => $b['nama_file'],
                'ukuran_file'  => $b['ukuran_file'],
                'uploaded_by'  => $b['uploaded_by'],
            ]);
        }
    }
}
