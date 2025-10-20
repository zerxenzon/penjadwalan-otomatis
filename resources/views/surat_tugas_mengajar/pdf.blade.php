<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Tugas Mengajar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .content {
            margin-top: 20px;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        td {
            padding: 8px;
            border: 1px solid #999;
        }
        .label {
            font-weight: bold;
            width: 30%;
            background-color: #f0f0f0;
        }
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-around;
        }
        .signature-box {
            text-align: center;
            width: 40%;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SURAT TUGAS MENGAJAR</h1>
        <p>Universitas XYZ - Fakultas Teknik</p>
        <p>Tahun Akademik {{ $suratTugas->semester->kode_semester }}</p>
    </div>

    <div class="content">
        <table>
            <tr>
                <td class="label">Dosen Pengajar</td>
                <td>: {{ $suratTugas->dosen->nama }}</td>
            </tr>
            <tr>
                <td class="label">NIP</td>
                <td>: {{ $suratTugas->dosen->biodata->nip ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Mata Kuliah</td>
                <td>: {{ $suratTugas->mataKuliah->nama }} ({{ $suratTugas->mataKuliah->kode }})</td>
            </tr>
            <tr>
                <td class="label">SKS</td>
                <td>: {{ $suratTugas->mataKuliah->sks }} SKS</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td>: {{ $suratTugas->kelas->nama }}</td>
            </tr>
            <tr>
                <td class="label">Program Studi</td>
                <td>: {{ $suratTugas->kelas->prodi->nama }}</td>
            </tr>
            <tr>
                <td class="label">Semester</td>
                <td>: {{ $suratTugas->semester->kode_semester }} ({{ ucfirst($suratTugas->semester->tipe) }})</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td>: {{ ucfirst($suratTugas->status->nama) }}</td>
            </tr>
        </table>

        @if ($suratTugas->catatan)
            <p><strong>Catatan:</strong></p>
            <p>{{ $suratTugas->catatan }}</p>
        @endif

        <p style="margin-top: 30px;">
            Dengan ini ditetapkan bahwa Bapak/Ibu <strong>{{ $suratTugas->dosen->nama }}</strong> ditugaskan untuk mengajar mata kuliah 
            <strong>{{ $suratTugas->mataKuliah->nama }}</strong> pada kelas <strong>{{ $suratTugas->kelas->nama }}</strong> 
            dalam semester {{ $suratTugas->semester->kode_semester }}.
        </p>

        <p>Dosen wajib melaksanakan tugas mengajar sesuai dengan jadwal yang telah ditetapkan dan peraturan akademik yang berlaku.</p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p>Dibuat pada:</p>
            <p>{{ $suratTugas->created_at->format('d F Y') }}</p>
        </div>
        <div class="signature-box">
            <p>Dekan,</p>
            <div class="signature-line"></div>
            <p>__________________</p>
        </div>
    </div>
</body>
</html>