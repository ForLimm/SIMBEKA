<!DOCTYPE html>
<html>
<head>
    <title>Surat Panggilan Orang Tua</title>
    <style>
        @page { margin: 2cm 2.5cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.6; color: #000; }
        
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 5px; }
        .kop .instansi { font-size: 11pt; font-weight: bold; margin: 0; }
        .kop .dinas { font-size: 13pt; font-weight: bold; margin: 0; }
        .kop .sekolah { font-size: 16pt; font-weight: bold; margin: 0; }
        .kop .alamat { font-size: 9pt; margin: 2px 0 0 0; }
        
        .nomor-surat { margin-top: 15px; }
        .nomor-surat table td { padding: 1px 5px; font-size: 12pt; vertical-align: top; }
        
        .tujuan { text-align: right; margin: 15px 0; }
        .tujuan p { margin: 0; }
        
        .isi { text-align: justify; }
        .isi p { margin: 5px 0; }
        
        .data-table { margin-left: 40px; margin-bottom: 5px; }
        .data-table td { padding: 2px 5px; font-size: 12pt; vertical-align: top; }
        .data-table td:first-child { width: 130px; }
        
        .ttd-wrap { width: 100%; margin-top: 30px; }
        .ttd-left, .ttd-right { width: 45%; vertical-align: top; }
        .ttd-left { text-align: left; }
        .ttd-right { text-align: left; padding-left: 30px; }
        .ttd-space { height: 60px; }
        .ttd-name { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        <p class="instansi">PEMERINTAH KABUPATEN ................</p>
        <p class="dinas">DINAS PENDIDIKAN DAN KEBUDAYAAN</p>
        <p class="sekolah">SMA NEGERI 1 ................</p>
        <p class="alamat">Jl. Pendidikan No. 1, Kec. ............, Kab. ............, Kode Pos : ............</p>
        <p class="alamat">E-mail : sekolah@email.sch.id</p>
    </div>

    {{-- NOMOR SURAT --}}
    <div class="nomor-surat">
        <table>
            <tr>
                <td>Nomor</td>
                <td>: ........ / {{ date('Y') }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>: -</td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>: <strong><u>PANGGILAN ORANG TUA</u></strong></td>
            </tr>
        </table>
    </div>

    {{-- TUJUAN SURAT --}}
    <div class="tujuan">
        <p>Kepada</p>
        <p>Yth : Bpk/Ibu <strong>{{ $father_name ?? $mother_name ?? '........................' }}</strong></p>
        <p>Di_</p>
        <p style="font-style: italic;">{{ $parents_address ?? '........................' }}</p>
    </div>

    {{-- ISI SURAT --}}
    <div class="isi">
        <p>Yang bertanda tangan dibawah ini :</p>

        <table class="data-table">
            <tr>
                <td>N a m a</td>
                <td>: {{ $teacher_name }}</td>
            </tr>
            <tr>
                <td>N I P</td>
                <td>: {{ $nip ?? '-' }}</td>
            </tr>
            <tr>
                <td>Guru BK</td>
                <td>: SMA Negeri 1 ................</td>
            </tr>
        </table>

        <p>Dengan ini kami menerangkan bahwa :</p>

        <table class="data-table">
            <tr>
                <td>Nama</td>
                <td>: <strong>{{ $student_name }}</strong></td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>: {{ $nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>: {{ $class }}</td>
            </tr>
        </table>

        <p>Untuk menjalin hubungan dan komunikasi yang baik antara orang tua/wali siswa dengan pihak sekolah dalam rangka tanggung jawab bersama dalam mendidik dan melatih anak kita ke arah yang baik, maka dengan ini kami pihak sekolah perlu memanggil Bapak/Ibu Orang Tua/wali siswa bahwa siswa yang bersangkutan telah melakukan pelanggaran tata tertib sekolah.</p>

        <table class="data-table" style="margin-top: 10px;">
            <tr>
                <td><strong>Hari / Tanggal</strong></td>
                <td>: <strong>{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong></td>
            </tr>
            <tr>
                <td><strong>Jam</strong></td>
                <td>: <strong>{{ $time ?? '09:00' }} WITA</strong></td>
            </tr>
        </table>

        <p style="margin-top: 5px;"><strong>Keterangan :</strong></p>
        <p style="margin-left: 40px;">{{ $reason }}</p>

        <p style="margin-top: 15px;">Demikian Surat pemberitahuan ini kami sampaikan untuk dapat diketahui oleh orang tua/wali siswa, atas perhatian dan kerjasamanya diucapkan terima kasih.</p>
    </div>

    {{-- TANDA TANGAN --}}
    <table class="ttd-wrap">
        <tr>
            <td class="ttd-left">
                <p>Mengetahui,</p>
                <p>KEPALA SEKOLAH</p>
                <div class="ttd-space"></div>
                <p class="ttd-name">........................</p>
                <p>Nip. ........................</p>
            </td>
            <td class="ttd-right">
                <p>................, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</p>
                <p>Guru BK,</p>
                <div class="ttd-space"></div>
                <p class="ttd-name">{{ $teacher_name }}</p>
                <p>Nip. {{ $nip ?? '-' }}</p>
            </td>
        </tr>
    </table>

</body>
</html>
