@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Selamat datang, ' . Auth::user()->name)

@section('content')
<div style="display:flex; flex-direction:column; gap:20px;">

    {{-- ===== STAT CARDS ===== --}}
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px;">

        @php
        $cards = [
            [
                'label' => 'Total Anggota',
                'value' => $stats['total_anggota'],
                'sub'   => 'Pengguna terdaftar',
                'color' => '#3b82f6',
                'bg'    => '#eff6ff',
                'icon'  => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
            ],
            [
                'label' => 'Departemen',
                'value' => $stats['total_departemen'],
                'sub'   => 'Divisi aktif',
                'color' => '#8b5cf6',
                'bg'    => '#f5f3ff',
                'icon'  => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z',
            ],
            [
                'label' => 'Total Inventaris',
                'value' => $stats['total_inventaris'],
                'sub'   => 'Barang tercatat',
                'color' => '#f97316',
                'bg'    => '#fff7ed',
                'icon'  => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z',
            ],
            [
                'label' => 'Rapat Akbar',
                'value' => $stats['total_rapat'],
                'sub'   => 'Total rapat',
                'color' => '#14b8a6',
                'bg'    => '#f0fdfa',
                'icon'  => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5',
            ],
            [
                'label' => 'Total Berkas',
                'value' => $stats['total_berkas'],
                'sub'   => 'Dokumen tersimpan',
                'color' => '#ec4899',
                'bg'    => '#fdf2f8',
                'icon'  => 'M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776',
            ],
            [
                'label' => 'Peminjaman Pending',
                'value' => $stats['peminjaman_pending'],
                'sub'   => 'Menunggu persetujuan',
                'color' => '#eab308',
                'bg'    => '#fefce8',
                'icon'  => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z',
            ],
        ];
        @endphp

        @foreach($cards as $card)
        <div style="background:#ffffff; border-radius:14px; padding:18px 20px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:14px;">
                <div style="width:38px; height:38px; border-radius:10px; background:{{ $card['bg'] }}; display:flex; align-items:center; justify-content:center;">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="{{ $card['color'] }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
            </div>
            <div style="font-size:28px; font-weight:800; color:#0f172a; line-height:1; margin-bottom:4px;">
                {{ $card['value'] }}
            </div>
            <div style="font-size:12.5px; font-weight:600; color:#374151; margin-bottom:2px;">{{ $card['label'] }}</div>
            <div style="font-size:11px; color:#94a3b8;">{{ $card['sub'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- ===== ROW 2: Progress Departemen + Rapat Terdekat ===== --}}
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:16px;">

        {{-- Progress Departemen --}}
        <div style="background:#ffffff; border-radius:14px; padding:22px 24px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                <div>
                    <div style="font-size:14px; font-weight:700; color:#0f172a;">Progress Departemen</div>
                    <div style="font-size:12px; color:#94a3b8; margin-top:2px;">Capaian program kerja per departemen</div>
                </div>
                <a href="{{ route('departemen.proker') }}" style="font-size:12px; color:#3b82f6; font-weight:500; text-decoration:none;">
                    Lihat semua →
                </a>
            </div>

            @php
            $depColors = [
                'Presidium'  => ['bar'=>'#3b82f6', 'bg'=>'#eff6ff', 'text'=>'#1d4ed8'],
                'PSDM'       => ['bar'=>'#8b5cf6', 'bg'=>'#f5f3ff', 'text'=>'#6d28d9'],
                'Media'      => ['bar'=>'#ec4899', 'bg'=>'#fdf2f8', 'text'=>'#be185d'],
                'Pendidikan' => ['bar'=>'#14b8a6', 'bg'=>'#f0fdfa', 'text'=>'#0f766e'],
                'Inventaris' => ['bar'=>'#f97316', 'bg'=>'#fff7ed', 'text'=>'#c2410c'],
            ];
            @endphp

            <div style="display:flex; flex-direction:column; gap:16px;">
                @foreach($departemens as $dep)
                @php
                    $prog = $dep->getProgressProker();
                    $clr  = $depColors[$dep->nama_departemen] ?? ['bar'=>'#64748b','bg'=>'#f8fafc','text'=>'#475569'];
                @endphp
                <div>
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:8px; height:8px; border-radius:50%; background:{{ $clr['bar'] }};"></div>
                            <span style="font-size:13px; font-weight:600; color:#1e293b;">{{ $dep->nama_departemen }}</span>
                            <span style="font-size:11px; color:#94a3b8;">{{ $dep->getJumlahAnggota() }} anggota</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="font-size:11.5px; font-weight:600; color:#475569;">{{ $prog['selesai'] }}/{{ $prog['total'] }} Proker</span>
                            <span style="font-size:11px; padding:2px 8px; border-radius:20px; background:{{ $clr['bg'] }}; color:{{ $clr['text'] }}; font-weight:600;">
                                {{ $prog['persen'] }}%
                            </span>
                        </div>
                    </div>
                    <div style="width:100%; height:6px; background:#f1f5f9; border-radius:99px; overflow:hidden;">
                        <div style="height:100%; border-radius:99px; background:{{ $clr['bar'] }}; width:{{ $prog['persen'] }}%; transition:width 0.6s ease;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Rapat Terdekat --}}
        <div style="background:#ffffff; border-radius:14px; padding:22px 24px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04); display:flex; flex-direction:column;">
            <div style="font-size:14px; font-weight:700; color:#0f172a; margin-bottom:16px;">Rapat Terdekat</div>

            @if($rapatTerdekat)
            <div style="background:#eff6ff; border-radius:12px; padding:16px; margin-bottom:14px; flex:1;">
                <span style="display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:10px; font-weight:700; background:#dbeafe; color:#1d4ed8; margin-bottom:10px; text-transform:uppercase; letter-spacing:0.05em;">
                    {{ $rapatTerdekat->status }}
                </span>
                <div style="font-size:14px; font-weight:700; color:#0f172a; line-height:1.4; margin-bottom:12px;">
                    {{ $rapatTerdekat->nama_rapat }}
                </div>
                <div style="display:flex; flex-direction:column; gap:7px;">
                    <div style="display:flex; align-items:center; gap:7px; font-size:12px; color:#475569;">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#3b82f6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
                        </svg>
                        {{ $rapatTerdekat->tanggal->translatedFormat('d F Y') }} · {{ $rapatTerdekat->waktu }}
                    </div>
                    <div style="display:flex; align-items:center; gap:7px; font-size:12px; color:#475569;">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#3b82f6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                        </svg>
                        {{ $rapatTerdekat->lokasi }}
                    </div>
                </div>
                <a href="{{ route('rapat.show', $rapatTerdekat) }}"
                   style="display:inline-flex; align-items:center; gap:4px; margin-top:12px; font-size:12px; font-weight:600; color:#3b82f6; text-decoration:none;">
                    Lihat detail
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                    </svg>
                </a>
            </div>
            @else
            <div style="flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:32px 0; color:#94a3b8;">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#cbd5e1" style="margin-bottom:8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
                </svg>
                <div style="font-size:12.5px; color:#94a3b8;">Belum ada rapat terjadwal</div>
            </div>
            @endif

            <a href="{{ route('rapat.index') }}"
               style="display:block; text-align:center; font-size:12px; font-weight:600; color:#3b82f6; text-decoration:none; padding-top:12px; border-top:1px solid #f1f5f9; margin-top:auto;">
                Lihat semua rapat →
            </a>
        </div>
    </div>

    {{-- ===== ROW 3: Peminjaman + Berkas ===== --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

        {{-- Pengajuan Peminjaman --}}
        <div style="background:#ffffff; border-radius:14px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04); overflow:hidden;">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:18px 20px; border-bottom:1px solid #f8fafc;">
                <div>
                    <div style="font-size:14px; font-weight:700; color:#0f172a;">Peminjaman Terbaru</div>
                    <div style="font-size:11.5px; color:#94a3b8; margin-top:2px;">Pengajuan inventaris masuk</div>
                </div>
                <a href="{{ route('inventaris.peminjaman') }}" style="font-size:12px; color:#3b82f6; font-weight:500; text-decoration:none;">
                    Lihat semua →
                </a>
            </div>

            @forelse($peminjamanTerbaru as $p)
            <div style="display:flex; align-items:center; gap:12px; padding:12px 20px; border-bottom:1px solid #f8fafc;">
                <div style="width:36px; height:36px; border-radius:50%; background:#f1f5f9; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:#64748b; flex-shrink:0;">
                    {{ strtoupper(substr($p->peminjam->name ?? 'N/A', 0, 2)) }}
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:13px; font-weight:600; color:#1e293b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $p->inventaris->nama_barang ?? '-' }}
                    </div>
                    <div style="font-size:11px; color:#94a3b8; margin-top:1px;">
                        {{ $p->peminjam->name ?? '-' }} · {{ $p->departemen->nama_departemen ?? '-' }}
                    </div>
                </div>
                <span style="flex-shrink:0; font-size:10.5px; font-weight:600; padding:3px 9px; border-radius:20px; {{ $p->getStatusBadgeClass() }}">
                    {{ $p->status_pengajuan }}
                </span>
            </div>
            @empty
            <div style="padding:40px 20px; text-align:center; color:#94a3b8; font-size:13px;">
                Belum ada pengajuan peminjaman
            </div>
            @endforelse
        </div>

        {{-- Berkas Terbaru --}}
        <div style="background:#ffffff; border-radius:14px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04); overflow:hidden;">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:18px 20px; border-bottom:1px solid #f8fafc;">
                <div>
                    <div style="font-size:14px; font-weight:700; color:#0f172a;">Berkas Terbaru</div>
                    <div style="font-size:11.5px; color:#94a3b8; margin-top:2px;">Dokumen yang baru diunggah</div>
                </div>
                <a href="{{ route('berkas.index') }}" style="font-size:12px; color:#3b82f6; font-weight:500; text-decoration:none;">
                    Lihat semua →
                </a>
            </div>

            @forelse($berkasTerbaru as $b)
            <div style="display:flex; align-items:center; gap:12px; padding:12px 20px; border-bottom:1px solid #f8fafc;">
                <div style="width:36px; height:36px; border-radius:9px; background:#f8fafc; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
                    {{ $b->getFileIcon() }}
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:13px; font-weight:600; color:#1e293b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $b->judul_berkas }}
                    </div>
                    <div style="font-size:11px; color:#94a3b8; margin-top:1px;">
                        {{ $b->ukuran_file }} · {{ $b->created_at->diffForHumans() }}
                    </div>
                </div>
                <span style="flex-shrink:0; font-size:10.5px; font-weight:600; padding:3px 9px; border-radius:20px; {{ $b->getKategoriBadgeClass() }}">
                    {{ $b->kategori }}
                </span>
            </div>
            @empty
            <div style="padding:40px 20px; text-align:center; color:#94a3b8; font-size:13px;">
                Belum ada berkas tersimpan
            </div>
            @endforelse
        </div>
    </div>

    {{-- ===== ROW 4: Rapat Akbar (Kehadiran) ===== --}}
    @if($rapatAkbar->isNotEmpty())
    <div style="background:#ffffff; border-radius:14px; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,0.04); overflow:hidden;">
        <div style="display:flex; align-items:center; justify-content:space-between; padding:18px 24px; border-bottom:1px solid #f8fafc;">
            <div>
                <div style="font-size:14px; font-weight:700; color:#0f172a;">Rekap Kehadiran Rapat</div>
                <div style="font-size:11.5px; color:#94a3b8; margin-top:2px;">8 rapat terakhir</div>
            </div>
            <a href="{{ route('rapat.index') }}" style="font-size:12px; color:#3b82f6; font-weight:500; text-decoration:none;">
                Lihat semua →
            </a>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:10px 20px; text-align:left; font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em;">Rapat</th>
                        <th style="padding:10px 16px; text-align:left; font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em;">Tanggal</th>
                        <th style="padding:10px 16px; text-align:center; font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em;">Hadir</th>
                        <th style="padding:10px 16px; text-align:center; font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em;">Izin</th>
                        <th style="padding:10px 16px; text-align:center; font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em;">Tidak Hadir</th>
                        <th style="padding:10px 16px; text-align:left; font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em;">Status</th>
                        <th style="padding:10px 20px; text-align:right; font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rapatAkbar as $rapat)
                    <tr style="border-top:1px solid #f1f5f9; transition:background 0.1s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                        <td style="padding:13px 20px; font-weight:600; color:#1e293b; max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $rapat->nama_rapat }}
                        </td>
                        <td style="padding:13px 16px; color:#64748b; white-space:nowrap;">
                            {{ $rapat->tanggal->translatedFormat('d M Y') }}
                        </td>
                        <td style="padding:13px 16px; text-align:center;">
                            <span style="font-weight:700; color:#15803d;">{{ $rapat->getJumlahHadir() }}</span>
                        </td>
                        <td style="padding:13px 16px; text-align:center;">
                            <span style="font-weight:700; color:#ca8a04;">{{ $rapat->getJumlahIzin() }}</span>
                        </td>
                        <td style="padding:13px 16px; text-align:center;">
                            <span style="font-weight:700; color:#dc2626;">{{ $rapat->getJumlahTidakHadir() }}</span>
                        </td>
                        <td style="padding:13px 16px;">
                            <span style="font-size:11px; font-weight:600; padding:3px 10px; border-radius:20px; {{ $rapat->getStatusBadgeClass() }}">
                                {{ $rapat->status }}
                            </span>
                        </td>
                        <td style="padding:13px 20px; text-align:right;">
                            <a href="{{ route('rapat.show', $rapat) }}"
                               style="font-size:12px; font-weight:500; color:#3b82f6; text-decoration:none;">
                                Detail →
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>

<style>
    @media (max-width: 1024px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr) !important; }
        .row2-grid { grid-template-columns: 1fr !important; }
        .row3-grid { grid-template-columns: 1fr !important; }
    }
    @media (max-width: 640px) {
        .stat-grid { grid-template-columns: 1fr 1fr !important; }
    }
</style>
@endsection
