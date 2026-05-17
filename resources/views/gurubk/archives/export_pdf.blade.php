<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bimbingan & Konseling</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 10px; color: #666; }
        
        .info { margin-bottom: 20px; }
        .info table { width: 100%; }
        .info td { padding: 2px 0; }
        
        .section-title { background: #f4f4f4; padding: 8px; font-weight: bold; margin: 20px 0 10px; border-left: 4px solid #2563EB; }
        
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data th { background: #2563EB; color: white; padding: 10px; text-align: left; font-size: 10px; text-transform: uppercase; }
        table.data td { border: 1px solid #eee; padding: 10px; font-size: 10px; }
        table.data tr:nth-child(even) { background: #fafafa; }
        
        .footer { margin-top: 50px; text-align: right; }
        .signature-box { display: inline-block; text-align: center; width: 200px; }
        .signature-space { height: 60px; }
        
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Rekapitulasi Bimbingan & Konseling</h1>
        <p>SMP NEGERI 6 PALU</p>
        <p>Jl. Jenderal Sudirman No. 1, Kota Palu, Sulawesi Tengah</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="100">Guru Pembimbing</td>
                <td>: {{ $teacher->user->name }}</td>
                <td width="100" style="text-align: right;">Tanggal Cetak</td>
                <td width="100">: {{ now()->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>: {{ $teacher->nip }}</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    @if(isset($data['archives']) && $data['archives']->count() > 0)
        <div class="section-title">Data Konsultasi & Pelaporan</div>
        <table class="data">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th width="80">Jenis</th>
                    <th>Judul / Perihal</th>
                    <th width="120">Siswa</th>
                    <th width="80">Tanggal Selesai</th>
                    <th width="60">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['archives'] as $index => $archive)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ ucfirst($archive->report->type) }}</td>
                        <td>{{ $archive->report->title }}</td>
                        <td>{{ $archive->student?->name ?? $archive->student?->user?->name ?? $archive->report?->reporter?->username ?? $archive->report?->reporter?->name ?? '-' }}</td>
                        <td>{{ $archive->completed_date->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($archive->report->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(isset($data['letters']) && $data['letters']->count() > 0)
        <div class="section-title">Data Pengarsipan Surat</div>
        <table class="data">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Jenis Surat</th>
                    <th width="120">Siswa Penerima</th>
                    <th width="100">Tanggal Terbit</th>
                    <th width="100">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['letters'] as $index => $letter)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ str_replace('_', ' ', ucfirst($letter->type)) }}</td>
                        <td>{{ $letter->student->user->name }}</td>
                        <td>{{ $letter->created_at->format('d/m/Y') }}</td>
                        <td>Arsip Digital Terverifikasi</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <div class="signature-box">
            <p>Palu, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Guru Pembimbing,</p>
            <div class="signature-space"></div>
            <p><strong>{{ $teacher->user->name }}</strong></p>
            <p>NIP. {{ $teacher->nip }}</p>
        </div>
    </div>
</body>
</html>
