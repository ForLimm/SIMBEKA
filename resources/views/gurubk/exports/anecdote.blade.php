<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Anekdot Siswa</title>
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
        
        /* STUDENT METADATA */
        .student-info-table {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .student-info-table td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 11pt;
        }
        .student-info-table td.label {
            width: 140px;
            font-weight: normal;
        }
        .student-info-table td.colon {
            width: 15px;
            text-align: center;
        }
        
        /* TABLE ANEKDOT */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.data th {
            border: 1px solid #000;
            padding: 10px 8px;
            text-align: center;
            font-weight: bold;
            font-size: 11pt;
            background-color: #f2f2f2;
        }
        table.data td {
            border: 1px solid #000;
            padding: 10px 8px;
            font-size: 10pt;
            vertical-align: top;
            line-height: 1.4;
        }
        .empty-state {
            text-align: center;
            font-style: italic;
            color: #555;
            padding: 20px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    @foreach($students as $index => $student)
        {{-- KOP SURAT --}}
        <div class="kop-container">
            <img class="kop-img" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/kop_surat.png'))) }}" />
        </div>

        {{-- METADATA SISWA --}}
        <table class="student-info-table">
            <tr>
                <td class="label">NAMA SISWA</td>
                <td class="colon">:</td>
                <td><strong>{{ strtoupper($student->name ?? ($student->user->name ?? '-')) }}</strong></td>
            </tr>
            <tr>
                <td class="label">KELAS</td>
                <td class="colon">:</td>
                <td>{{ strtoupper($student->class ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">NIS</td>
                <td class="colon">:</td>
                <td>{{ $student->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">ALAMAT</td>
                <td class="colon">:</td>
                <td>{{ $student->address ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">AGAMA</td>
                <td class="colon">:</td>
                <td>{{ strtoupper($student->religion ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">NO HP</td>
                <td class="colon">:</td>
                <td>{{ $student->phone ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">NAMA IBU</td>
                <td class="colon">:</td>
                <td>{{ strtoupper($student->mother_name ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">NAMA AYAH</td>
                <td class="colon">:</td>
                <td>{{ strtoupper($student->father_name ?? '-') }}</td>
            </tr>
        </table>

        {{-- TABEL CATATAN ANEKDOT --}}
        <table class="data">
            <thead>
                <tr>
                    <th style="width: 6%;">No</th>
                    <th style="width: 18%;">Hari/Tanggal</th>
                    <th style="width: 36%;">Permasalahan</th>
                    <th style="width: 20%;">Layanan yang diterima</th>
                    <th style="width: 20%;">Tindak lanjut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($student->counselingSessions as $session)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td style="text-align: center;">
                            {{ $session->counseling_date->translatedFormat('l') }}/<br/>
                            {{ $session->counseling_date->translatedFormat('d F Y') }}
                        </td>
                        <td>{{ $session->summary ?? '-' }}</td>
                        <td style="text-align: center;">{{ $session->category ?? '-' }}</td>
                        <td>{{ $session->follow_up ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">Tidak ada catatan anekdot untuk periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>
</html>