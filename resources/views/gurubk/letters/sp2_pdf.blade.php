<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Peringatan Kedua (SP2)</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            margin-top: 1.8cm;
            margin-bottom: 2cm;
            margin-left: 2.5cm;
            margin-right: 2cm;
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
        
        /* META SURAT */
        .meta-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .meta-table td {
            vertical-align: top;
            padding: 2px 0;
        }
        .meta-left {
            width: 60%;
        }
        .meta-right {
            width: 40%;
            text-align: left;
        }
        
        /* ISI SURAT */
        .content {
            text-align: justify;
            margin-bottom: 30px;
        }
        .content p {
            margin-top: 0;
            margin-bottom: 12px;
            text-indent: 30px;
        }
        .content p.no-indent {
            text-indent: 0;
        }
        
        /* DETAIL SISWA TABLE */
        .detail-table {
            width: 90%;
            margin: 15px auto;
            border-collapse: collapse;
        }
        .detail-table td {
            padding: 4px 5px;
            vertical-align: top;
        }
        .detail-table td.label {
            width: 130px;
        }
        .detail-table td.colon {
            width: 10px;
            text-align: center;
        }
        
        /* TANDA TANGAN */
        .signature-table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }
        .signature-table td {
            vertical-align: top;
            width: 50%;
        }
        .sig-right {
            text-align: left;
            padding-left: 50px;
            position: relative;
        }
        
        .sig-space {
            height: 55px;
        }
        .sig-image-container {
            position: absolute;
            top: 55px;
            left: -20px;
            z-index: -1;
        }
        .sig-image {
            width: 200px;
            height: auto;
        }
        .sig-name {
            font-weight: bold;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop-container">
        <img class="kop-img" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/kop_surat.png'))) }}" />
    </div>

    {{-- META SURAT & TUJUAN --}}
    <table class="meta-table">
        <tr>
            <td class="meta-left">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 80px;">Nomor</td>
                        <td style="width: 10px;">:</td>
                        <td>{{ $letter_number }}</td>
                    </tr>
                    <tr>
                        <td>Lampiran</td>
                        <td>:</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Hal</td>
                        <td>:</td>
                        <td><strong>Surat Peringatan Kedua (SP2)</strong></td>
                    </tr>
                </table>
            </td>
            <td class="meta-right">
                Kepada :<br/>
                Yth. Bpk/Ibu Orang Tua/Wali<br/>
                An. <strong>{{ $student_name }}</strong><br/>
                Di -<br/>
                <span style="padding-left: 20px;">Tempat</span>
            </td>
        </tr>
    </table>

    {{-- ISI SURAT --}}
    <div class="content">
        <p class="no-indent" style="margin-bottom: 15px;">Dengan hormat,</p>
        <p class="no-indent">Sehubungan dengan pelanggaran yang dilakukan oleh siswa :</p>

        <table class="detail-table">
            <tr>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td><strong>{{ $student_name }}</strong></td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td class="colon">:</td>
                <td>{{ $class }}</td>
            </tr>
            <tr>
                <td class="label">Pelanggaran</td>
                <td class="colon">:</td>
                <td>{!! nl2br(e($reason)) !!}</td>
            </tr>
        </table>

        <p class="no-indent" style="margin-top: 15px;">Kami pihak sekolah memberikan surat peringatan kedua atau yang biasa disebut <strong>SP 2</strong>. Jika 
terjadi pelanggaran yang sama atau berbeda, maka pihak sekolah akan memberikan surat 
peringatan ketiga atau siswa akan dikembalikan ke orang tuanya. Apabila dalam masa 
pemantauan siswa menunjukaan perubahan dan bersikap baik, maka SP 2 ini akan diputihkan.</p>
        
        <p class="no-indent" style="margin-top: 15px;">Demikian surat peringatan ini dibuat agar siswa dapat memperbaiki perilakunya. Atas 
perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
    </div>

    {{-- TANDA TANGAN --}}
    <table class="signature-table">
        <tr>
            <td style="width: 55%;"></td>
            <td class="sig-right" style="width: 45%;">
                <div class="sig-image-container">
                    <img class="sig-image" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/cap_signature.png'))) }}" />
                </div>
                <p style="margin-bottom: 0; position: relative; z-index: 2;">Palu, {{ \Carbon\Carbon::now('Asia/Makassar')->locale('id')->isoFormat('D MMMM Y') }}</p>
                <p style="margin-top: 5px; margin-bottom: 0; position: relative; z-index: 2;">Mengetahui,<br/>Kepala Sekolah,</p>
                <div class="sig-space"></div>
                <p class="sig-name" style="margin-top: 0; margin-bottom: 0; position: relative; z-index: 2;">Hartadi Gatot, S.Pd., M.P.Mat.</p>
                <p style="margin-top: 0; position: relative; z-index: 2;">NIP. 198211112009031002</p>
            </td>
        </tr>
    </table>

</body>
</html>
