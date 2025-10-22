<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Tugas Mengajar</title>
    <style>
        @page {
            margin: 2.5cm 2cm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 11pt;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px;
            height: auto;
        }
        .header h1 {
            font-size: 14pt;
            margin: 10px 0;
        }
        .header p {
            font-size: 10pt;
            margin: 5px 0;
        }
        .content {
            margin-top: 30px;
        }
        table.detail {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table.detail th, 
        table.detail td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        table.detail th {
            background-color: #f0f0f0;
        }
        .signature {
            margin-top: 50px;
            text-align: center;
            float: right;
            width: 200px;
        }
        .total-sks {
            margin-top: 10px;
            font-weight: bold;
        }
        .letter-number {
            margin-bottom: 20px;
        }
        .footer-text {
            margin-top: 20px;
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%">
            <tr>
                <td style="width: 15%">
                    <img src="{{ public_path('logo.png') }}" style="width: 80px">
                </td>
                <td style="text-align: center">
                    <h1>RUUQI UNIVERSITY</h1>
                    <p style="font-size: 11pt;">SK. No. : 114/KPT/I/2025</p>
                    <p style="font-size: 11pt;">Terakreditasi BAN-PT</p>
                    <p style="font-size: 10pt;">Kampus : Jl. Raya Cipadung No. 22 Jatinangor – Sumedang 45363</p>
                    <p style="font-size: 10pt;">Telp. (022) 7798430 Fax (022) 7798243</p>
                    <p style="font-size: 10pt;">email : info@masoemuniversity.ac.id Web Site : www.masoemuniversity.ac.id</p>
                </td>
            </tr>
        </table>
        <hr style="border-top: 2px solid black; margin: 20px 0;">
    </div>

    <div class="letter-number" style="text-align: center;">
        <h2 style="font-size: 14pt; margin: 10px 0;">SURAT TUGAS PENGAJARAN</h2>
        <p>Nomor : {{ $suratTugas->nomor_surat }}</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini Dekan Fakultas Komputer, menugaskan kepada:</p>
        
        <table style="margin-left: 30px;">
            <tr>
                <td style="width: 100px">Nama</td>
                <td style="width: 10px">:</td>
                <td>{{ $suratTugas->dosen->nama }}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>{{ $suratTugas->dosen->biodata->nip ?? '-' }}</td>
            </tr>
            <tr>
                <td>NIDN</td>
                <td>:</td>
                <td>{{ $suratTugas->dosen->biodata->nidn ?? '-' }}</td>
            </tr>
        </table>

        <p>Untuk mengampu matakuliah sebagai berikut :</p>

        <table class="detail">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Matakuliah</th>
                    <th>SKS</th>
                    <th>Program</th>
                    <th>SMT</th>
                    <th>Kelas</th>
                    <th>Jml. Kelas</th>
                    <th>Jml.</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $suratTugas->mataKuliah->nama }}</td>
                    <td>{{ $suratTugas->mataKuliah->sks }}</td>
                    <td>{{ $suratTugas->mataKuliah->prodi->kode }}</td>
                    <td>{{ $suratTugas->semester->kode_semester }}</td>
                    <td>{{ $suratTugas->kelas->nama }}</td>
                    <td>1</td>
                    <td>{{ $suratTugas->mataKuliah->sks * 1 }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" style="text-align: center; font-weight: bold;">Total SKS</td>
                    <td style="font-weight: bold;">{{ $suratTugas->mataKuliah->sks * 1 }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer-text" style="margin-top: 20px; font-size: 10pt;">
            <p>Pada butir sampai dengan tersebut di atas untuk semester {{ $suratTugas->semester->tipe == 'ganjil' ? 'Ganjil' : 'Genap' }} tahun akademik {{ now()->format('Y') }}/{{ now()->addYear()->format('Y') }} mulai dari awal sampai akhir semester.</p>

            <p>Atas perhatian dan kerjasamanya diucapkan terimakasih.</p>
        </div>

        <div class="signature" style="margin-top: 20px;">
            <p>Jatinangor, {{ \Carbon\Carbon::parse(now())->isoFormat('D MMMM Y') }}</p>
            <p>Dekan Fakultas Komputer</p>
            <br><br>
            <p><u>Muhammad Nurjaman, S.T., M.A.B</u></p>
        </div>
    </div>
</body>
</html>