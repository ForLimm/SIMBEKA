<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Surat Panggilan Orang Tua</title>
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
            margin-left: 2.5cm;
            margin-right: 2.5cm;
        }
        
        .kop-container {
            text-align: center;
            margin-bottom: 15px;
        }
        .kop-img {
            width: 100%;
            height: auto;
        }
        
        .meta-table {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .meta-table td {
            vertical-align: top;
            padding: 1px 0;
        }
        .meta-left {
            width: 60%;
        }
        .meta-right {
            width: 40%;
            text-align: left;
            padding-left: 20px;
        }
        
        .content {
            text-align: justify;
            margin-bottom: 20px;
        }
        .content p {
            margin: 10px 0;
            text-indent: 40px;
        }
        
        .detail-table {
            width: 90%;
            margin: 15px auto;
            border-collapse: collapse;
        }
        .detail-table td {
            padding: 4px 8px;
            vertical-align: top;
        }
        .detail-table td.label {
            width: 150px;
        }
        .detail-table td.colon {
            width: 10px;
            text-align: center;
        }
        
        .closing {
            margin-top: 20px;
            text-align: justify;
        }
        
        .signature-table {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signature-table td {
            vertical-align: top;
            width: 50%;
        }
        .sig-left {
            text-align: left;
            padding-left: 20px;
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
            text-decoration: underline;
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
                        <td><strong>Undangan Orang Tua/Wali Siswa</strong></td>
                    </tr>
                </table>
            </td>
            <td class="meta-right">
                Kepada :<br/>
                Yth. Bapak/Ibu Orang Tua/Wali<br/>
                <strong>{{ $father_name ?? $mother_name ?? '' }}</strong><br/>
                Di -<br/>
                <span style="padding-left: 20px; font-style: italic;">Tempat</span>
            </td>
        </tr>
    </table>

    {{-- ISI SURAT --}}
    <div class="content">
        <p style="text-indent: 0;">Dengan Hormat,</p>
        <p>Sehubungan dengan adanya permasalahan/pelanggaran tata tertib yang dilakukan oleh putra/putri Bapak/Ibu, maka kami mengharapkan kehadiran Bapak/Ibu pada:</p>

        <table class="detail-table">
            <tr>
                <td class="label">Hari / Tanggal</td>
                <td class="colon">:</td>
                <td><strong>{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong></td>
            </tr>
            <tr>
                <td class="label">Jam</td>
                <td class="colon">:</td>
                <td><strong>{{ $time ?? '09:00' }} WITA</strong></td>
            </tr>
            <tr>
                <td class="label">Tempat</td>
                <td class="colon">:</td>
                <td><strong>Ruang Bimbingan Konseling (BK) SMP Negeri 6 Palu</strong></td>
            </tr>
            <tr>
                <td class="label">Keterangan / Alasan</td>
                <td class="colon">:</td>
                <td style="font-weight: bold;">{!! nl2br(e($reason)) !!}</td>
            </tr>
        </table>

        <p class="closing">Mengingat pentingnya hal tersebut, maka kami mengharapkan Bapak/Ibu untuk datang tepat waktu sesuai dengan waktu yang telah ditentukan.</p>
        <p class="closing">Demikian surat panggilan ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
    </div>

    {{-- TANDA TANGAN --}}
    <table class="signature-table">
        <tr>
            <td style="width: 55%;"></td>
            <td class="sig-right" style="width: 45%;">
                <div class="sig-image-container">
                    <img class="sig-image" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/cap_signature.png'))) }}" />
                </div>
                <p style="margin-bottom: 0; position: relative; z-index: 2;">Palu, {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('D MMMM Y') }}</p>
                <p style="margin-top: 5px; margin-bottom: 0; position: relative; z-index: 2;">Mengetahui,<br/>Kepala Sekolah,</p>
                <div class="sig-space"></div>
                <p class="sig-name" style="margin-top: 0; margin-bottom: 0; position: relative; z-index: 2;">Hartadi Gatot, S.Pd., M.P.Mat.</p>
                <p style="margin-top: 0; position: relative; z-index: 2;">NIP. 198211112009031002</p>
            </td>
        </tr>
    </table>

</body>
</html>
