<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Tugas Pengajaran</title>
    <style>
        @page {
            margin: 1.5cm 2cm 1.5cm 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            font-size: 11pt;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 5px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-cell {
            width: 90px;
            text-align: left;
            padding-right: 5px;
        }
        .logo-cell img {
            width: 75px;
            height: auto;
        }
        .info-cell {
            text-align: center;
            padding-left: 0;
        }
        .university-name {
            font-size: 15pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
            color: #000000;
        }
        .sk-number {
            font-size: 8.5pt;
            margin: 1px 0;
            line-height: 1.3;
        }
        .address-line {
            font-size: 8.5pt;
            margin: 0;
            line-height: 1.3;
        }
        .header-divider {
            border: none;
            border-top: 3px solid #000;
            margin: 8px 0 12px 0;
        }
        .title {
            text-align: center;
            margin: 12px 0 8px 0;
        }
        .title h2 {
            font-size: 12pt;
            font-weight: bold;
            margin: 3px 0;
            text-decoration: underline;
        }
        .nomor-surat {
            font-size: 10pt;
            margin: 3px 0;
        }
        .content {
            margin-top: 12px;
            text-align: justify;
        }
        .content p {
            margin: 8px 0;
            line-height: 1.5;
        }
        .data-dosen {
            margin: 10px 0 10px 50px;
            line-height: 1.6;
        }
        .data-dosen table {
            border: none;
        }
        .data-dosen td {
            padding: 2px 0;
            vertical-align: top;
        }
        .data-dosen .label {
            width: 100px;
        }
        .data-dosen .colon {
            width: 15px;
        }
        table.detail {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
            page-break-inside: auto;
        }
        table.detail thead {
            display: table-header-group;
        }
        table.detail tbody tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        table.detail th, 
        table.detail td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: center;
            font-size: 9.5pt;
            line-height: 1.3;
        }
        table.detail th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        table.detail td {
            vertical-align: middle;
        }
        table.detail .text-left {
            text-align: left;
            padding-left: 8px;
        }
        table.detail tfoot td {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .footer-text {
            margin-top: 12px;
            text-align: justify;
            line-height: 1.5;
            font-size: 10.5pt;
            page-break-inside: avoid;
        }
        .footer-text p {
            margin: 6px 0;
        }
        .signature-section {
            margin-top: 20px;
            text-align: center;
            page-break-inside: avoid;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            margin-left: 58%;
        }
        .signature-place {
            margin-bottom: 3px;
            font-size: 10.5pt;
        }
        .signature-title {
            margin-bottom: 45px;
            font-size: 10.5pt;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            font-size: 10.5pt;
            margin-bottom: 0;
        }
        .signature-nip {
            font-size: 9pt;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <img src="{{ public_path('logo.png') }}" alt="Logo">
                </td>
                <td class="info-cell">
                    <h1 class="university-name">RUUQI UNIVERSITY</h1>
                    <p class="sk-number">SK. No. : 114/KPT/I/2025</p>
                    <p class="sk-number">Terakreditasi BAN-PT</p>
                    <p class="address-line">Kampus : Jl. Raya Cipadung No. 22 Jatinangor - Sumedang 45363</p>
                    <p class="address-line">Telp. (022) 7798430 Fax. (022) 7798243</p>
                    <p class="address-line">email : info@ruuqiuniversity.ac.id Web Site : www.ruuqiuniversity.ac.id</p>
                </td>
            </tr>
        </table>
        <hr class="header-divider">
    </div>

    <!-- TITLE -->
    <div class="title">
        <h2>SURAT TUGAS PENGAJARAN</h2>
        <p class="nomor-surat">Nomor : {{ $suratTugas->nomor_surat ?? '-' }}</p>
    </div>

    <!-- CONTENT -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini Dekan Fakultas Komputer, menugaskan kepada:</p>
        
        <div class="data-dosen">
            <table>
                <tr>
                    <td class="label">Nama</td>
                    <td class="colon">:</td>
                    <td>{{ $suratTugas->dosen->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">NIDN</td>
                    <td class="colon">:</td>
                    <td>{{ $suratTugas->dosen->biodata->nidn ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <p>Untuk mengampu matakuliah sebagai berikut :</p>

        <!-- TABLE MATAKULIAH -->
        <table class="detail">
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 26%;">Matakuliah</th>
                    <th style="width: 5%;">SKS</th>
                    <th style="width: 9%;">Program</th>
                    <th style="width: 6%;">SMT</th>
                    <th style="width: 8%;">Kelas</th>
                    <th style="width: 7%;">Jml.<br>Kelas</th>
                    <th style="width: 7%;">Jml.<br>SKS</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $totalSKS = 0;
                @endphp
                @forelse($mataKuliahList as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td class="text-left">{{ $item->mataKuliah->nama ?? '-' }}</td>
                        <td>{{ $item->mataKuliah->sks ?? 0 }}</td>
                        <td>{{ $item->mataKuliah->prodi->kode ?? 'S1 IF' }}</td>
                        <td>{{ $item->semester->kode_semester ?? '1' }}</td>
                        <td>{{ $item->kelas->nama ?? '-' }}</td>
                        <td>1</td>
                        <td>{{ ($item->mataKuliah->sks ?? 0) * 1 }}</td>
                    </tr>
                    @php
                        $totalSKS += ($item->mataKuliah->sks ?? 0) * 1;
                    @endphp
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 20px;">
                            <em>Tidak ada data mata kuliah</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" style="text-align: center;">Total SKS</td>
                    <td>{{ $totalSKS }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- FOOTER TEXT -->
        <div class="footer-text">
            @php
                $semesterTipe = $suratTugas->semester->tipe == 'ganjil' ? 'Ganjil' : 'Genap';
                $tahunAkademik = $suratTugas->semester->tahun_akademik ?? now()->year . '/' . now()->addYear()->year;
                $tanggalMulai = \Carbon\Carbon::parse($suratTugas->semester->tanggal_mulai ?? now())->locale('id')->isoFormat('DD MMMM Y');
            @endphp
            <p style="text-indent: 50px;">
                Perlu kami sampaikan bahwa perkuliahan semester {{ $semesterTipe }} 
                tahun akademik {{ $tahunAkademik }} Insya Allah akan dimulai tanggal {{ $tanggalMulai }}, 
                untuk itu kami mohon Bapak/Ibu dapat mempersiapkan <strong>Rencana Pembelajaran Semester (RPS) 
                dan Bahan Ajar</strong> untuk matakuliah di atas dan menyampaikannya ke Fakultas Komputer 
                RUUQI University <strong>paling lambat diminggu pertama perkuliahan.</strong>
            </p>
            <p>Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
        </div>

        <!-- SIGNATURE -->
        <div class="signature-section">
            <div class="signature-box">
                <p class="signature-place">Garut, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('DD MMMM Y') }}</p>
                <p class="signature-title">Dekan Fakultas Komputer</p>
                <br><br><br>
                <p class="signature-name">Muhammad Nurjaman, S.T., M.A.B</p>
                <p class="signature-nip">NIM: 24205033</p>
            </div>
        </div>
    </div>
</body>
</html>