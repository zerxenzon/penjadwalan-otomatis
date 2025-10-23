<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kuliah - {{ $kelas->nama ?? 'N/A' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }
        .info-box {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-left: 4px solid #007bff;
        }
        .info-box p {
            margin: 5px 0;
        }
        .day-section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .day-header {
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th {
            background-color: #e9ecef;
            color: #333;
            padding: 10px 8px;
            text-align: left;
            border: 1px solid #dee2e6;
            font-weight: bold;
        }
        table td {
            padding: 8px;
            border: 1px solid #dee2e6;
        }
        table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #333;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
        .badge-secondary {
            background-color: #6c757d;
            color: white;
        }
        .summary {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            text-align: center;
        }
        .summary-item {
            flex: 1;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            margin: 0 5px;
        }
        .summary-item h3 {
            margin: 0;
            font-size: 24px;
            color: #007bff;
        }
        .summary-item p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>UNIVERSITAS PAMULANG</h1>
        <h2>Fakultas Teknik</h2>
        <h2>JADWAL KULIAH</h2>
    </div>

    <!-- Info Mahasiswa & Kelas -->
    <div class="info-box">
        <p><strong>Nama:</strong> {{ $mahasiswa->nama ?? 'N/A' }}</p>
        <p><strong>Kelas:</strong> {{ $kelas->nama ?? 'N/A' }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i') }}</p>
    </div>

    <!-- Summary Statistics -->
    <div class="summary">
        <div class="summary-item">
            <h3>{{ $jadwalGrouped->flatten()->count() }}</h3>
            <p>Total Sesi Kuliah</p>
        </div>
        <div class="summary-item">
            <h3>{{ $jadwalGrouped->flatten()->unique('suratTugasMengajar.mata_kuliah_id')->count() }}</h3>
            <p>Mata Kuliah</p>
        </div>
        <div class="summary-item">
            <h3>{{ $jadwalGrouped->count() }}</h3>
            <p>Hari Kuliah</p>
        </div>
        <div class="summary-item">
            <h3>{{ $jadwalGrouped->flatten()->sum(function($j) { return $j->suratTugasMengajar->mataKuliah->sks ?? 0; }) }}</h3>
            <p>Total SKS</p>
        </div>
    </div>

    <!-- Jadwal per Hari -->
    @if($jadwalGrouped->count() > 0)
        @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'] as $hari)
            @if($jadwalGrouped->has($hari))
            <div class="day-section">
                <div class="day-header">
                    {{ strtoupper($hari) }} ({{ $jadwalGrouped[$hari]->count() }} Sesi)
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 15%">Waktu</th>
                            <th style="width: 30%">Mata Kuliah</th>
                            <th style="width: 25%">Dosen</th>
                            <th style="width: 20%">Ruangan</th>
                            <th style="width: 10%">SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwalGrouped[$hari]->sortBy('jam_mulai') as $jadwal)
                        <tr>
                            <td>
                                <strong>{{ date('H:i', strtotime($jadwal->jam_mulai)) }}</strong>
                                -
                                <strong>{{ date('H:i', strtotime($jadwal->jam_selesai)) }}</strong>
                            </td>
                            <td>
                                <strong>{{ $jadwal->suratTugasMengajar->mataKuliah->nama ?? 'N/A' }}</strong>
                                <br>
                                <small style="color: #666;">{{ $jadwal->suratTugasMengajar->mataKuliah->kode ?? 'N/A' }}</small>
                            </td>
                            <td>{{ $jadwal->suratTugasMengajar->dosen->nama ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-info">{{ $jadwal->ruangan->nama ?? 'N/A' }}</span>
                                <br>
                                <small style="color: #666;">Kapasitas: {{ $jadwal->ruangan->kapasitas ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $jadwal->suratTugasMengajar->mataKuliah->sks ?? 'N/A' }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        @endforeach
    @else
    <div style="text-align: center; padding: 40px; background-color: #f8f9fa; border: 1px solid #dee2e6;">
        <p style="margin: 0; color: #666;">Belum ada jadwal untuk kelas ini.</p>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari Sistem Penjadwalan UNPAM</p>
        <p>Jika ada perubahan jadwal, mohon cek sistem secara berkala</p>
        <p>&copy; {{ now()->format('Y') }} Universitas Pamulang - Fakultas Teknik</p>
    </div>
</body>
</html>
