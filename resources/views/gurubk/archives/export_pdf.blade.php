<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bimbingan & Konseling</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000;
            margin-top: 1.8cm;
            margin-bottom: 2cm;
            margin-left: 1.8cm;
            margin-right: 1.8cm;
        }
        
        /* KOP SURAT */
        .kop-container {
            width: 100%;
            margin-bottom: 15px;
        }
        .kop-img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        /* INFO LAPORAN */
        .info-table {
            width: 100%;
            margin-top: 15px;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 11pt;
        }
        
        /* DATA TABLE */
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 1.5px solid #000;
            padding-bottom: 3px;
        }
        
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }
        table.data th {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
            background-color: #f2f2f2;
            text-transform: uppercase;
            word-wrap: break-word;
        }
        table.data td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 10pt;
            vertical-align: top;
            word-wrap: break-word;
        }
        
        /* TANDA TANGAN */
        .signature-table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }
        .signature-table td {
            vertical-align: top;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop-container">
        <img class="kop-img" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/kop_surat.png'))) }}" />
    </div>

    @php
        $types = [];
        if (isset($data['sessions']) && $data['sessions']->count() > 0) $types[] = 'Konseling';
        if (isset($data['archives'])) {
            $hasKonsul = $data['archives']->contains(fn($a) => $a->report->type === 'konsultasi');
            $hasLapor = $data['archives']->contains(fn($a) => $a->report->type === 'pelaporan');
            if ($hasKonsul) $types[] = 'Konsultasi';
            if ($hasLapor) $types[] = 'Pelaporan';
        }
        if (isset($data['letters']) && $data['letters']->count() > 0) $types[] = 'Surat';

        $laporanTitle = 'Laporan ' . implode(' & ', $types);
        if (empty($types)) {
            $laporanTitle = 'Laporan Rekapitulasi Bimbingan';
        }
    @endphp

    {{-- INFO LAPORAN --}}
    <table class="info-table">
        <tr>
            <td style="width: 130px; font-weight: bold;">Laporan</td>
            <td style="width: 10px;">:</td>
            <td><strong>{{ $laporanTitle }}</strong></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Tanggal Cetak</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</td>
        </tr>
    </table>

    {{-- DATA KONSELING --}}
    @if(isset($data['sessions']) && $data['sessions']->count() > 0)
        <div class="section-title">Data Sesi Bimbingan / Konseling</div>
        <table class="data">
            <thead>
                <tr>
                    <th style="width: 6%;">No</th>
                    <th style="width: 25%;">Siswa Binaan</th>
                    <th style="width: 35%;">Topik / Kategori</th>
                    <th style="width: 20%;">Tanggal Selesai</th>
                    <th style="width: 14%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['sessions'] as $index => $session)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $session->student->name }} (Kelas {{ $session->student->class }})</td>
                        <td>
                            <strong>{{ $session->title ?? 'Sesi Bimbingan Tatap Muka' }}</strong>
                            <br>
                            <span style="font-size: 8pt; color: #555;">Kategori: {{ ucfirst($session->category) }}</span>
                        </td>
                        <td style="text-align: center;">{{ $session->completed_at ? $session->completed_at->format('d/m/Y') : $session->counseling_date->format('d/m/Y') }}</td>
                        <td style="text-align: center;">Selesai</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- DATA KONSULTASI --}}
    @if(isset($data['archives']) && $data['archives']->count() > 0)
        <div class="section-title">Data Konsultasi & Pelaporan</div>
        <table class="data">
            <thead>
                <tr>
                    <th style="width: 6%;">No</th>
                    <th style="width: 15%;">Jenis</th>
                    <th style="width: 34%;">Judul / Perihal</th>
                    <th style="width: 25%;">Siswa Binaan</th>
                    <th style="width: 12%;">Tanggal</th>
                    <th style="width: 8%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['archives'] as $index => $archive)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td style="text-align: center;">{{ ucfirst($archive->report->type) }}</td>
                        <td>{{ $archive->report->title }}</td>
                        <td>{{ $archive->student?->name ?? $archive->student?->user?->name ?? $archive->report?->reporter?->username ?? $archive->report?->reporter?->name ?? '-' }}</td>
                        <td style="text-align: center;">{{ $archive->completed_date->format('d/m/Y') }}</td>
                        <td style="text-align: center;">{{ ucfirst($archive->report->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- DATA ARSIP SURAT --}}
    @if(isset($data['letters']) && $data['letters']->count() > 0)
        <div class="section-title">Data Pengarsipan Surat</div>
        <table class="data">
            <thead>
                <tr>
                    <th style="width: 6%;">No</th>
                    <th style="width: 20%;">Jenis Surat</th>
                    <th style="width: 34%;">Siswa Penerima</th>
                    <th style="width: 18%;">Tanggal Terbit</th>
                    <th style="width: 22%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['letters'] as $index => $letter)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ str_replace('_', ' ', strtoupper($letter->type)) }}</td>
                        <td>{{ $letter->student?->name ?? ($letter->student?->user?->name ?? 'Tanpa Nama') }}</td>
                        <td style="text-align: center;">{{ $letter->created_at->format('d/m/Y') }}</td>
                        <td>Arsip Digital Terverifikasi</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- TANDA TANGAN GURU --}}
    <table class="signature-table">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%; text-align: left; padding-left: 15px;">
                <p style="margin-bottom: 0;">Palu, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
                <p style="margin-top: 5px; margin-bottom: 0;">Guru BK,</p>
                <div style="height: 75px;"></div>
                <p style="margin-top: 0; margin-bottom: 0; font-weight: bold; text-decoration: underline;">{{ $teacher->user->name }}</p>
                <p style="margin-top: 0;">NIP. {{ $teacher->nip }}</p>
            </td>
        </tr>
    </table>

</body>
</html>