<!DOCTYPE html>
<html>
<head>
    <title>Daftar Dosen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2cm;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        h1 {
            font-size: 18pt;
            margin: 0 0 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 9pt;
        }
        th {
            background-color: #f0f0f0;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .ttd {
            margin-top: 80px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DAFTAR DOSEN</h1>
        <p>Per Tanggal: {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama</th>
                <th width="15%">NIP</th>
                <th width="25%">Email</th>
                <th width="20%">No. Telepon</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dosen as $index => $d)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->biodata->nip ?? '-' }}</td>
                <td>{{ $d->email }}</td>
                <td>{{ $d->biodata->no_telp ?? '-' }}</td>
                <td align="center">{{ $d->status->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>{{ config('app.name') }}</p>
        <div class="ttd">
            <p>{{ auth()->user()->role->nama == 'dekan' ? 'Dekan' : 'Kaprodi' }},</p>
            <br><br><br>
            <p>{{ auth()->user()->nama }}</p>
            <p>NIP. {{ auth()->user()->biodata->nip ?? '-' }}</p>
        </div>
    </div>
</body>
</html>