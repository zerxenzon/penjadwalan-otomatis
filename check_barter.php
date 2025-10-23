<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== SEMUA BARTER JADWAL ===" . PHP_EOL;
$allBarter = \App\Models\BarterJadwal::with(['dosenPengaju.biodata', 'dosenTujuan.biodata', 'status'])->get();

foreach ($allBarter as $barter) {
    echo "\n--- Barter ID: {$barter->id} ---" . PHP_EOL;
    echo "Dosen Pengaju: " . ($barter->dosenPengaju->biodata->nama ?? $barter->dosenPengaju->username) . " (User ID: {$barter->dosen_pengaju_id})" . PHP_EOL;
    echo "Dosen Tujuan: " . ($barter->dosenTujuan->biodata->nama ?? $barter->dosenTujuan->username) . " (User ID: {$barter->dosen_tujuan_id})" . PHP_EOL;
    echo "Status: {$barter->status->nama}" . PHP_EOL;
}

echo "\n\n=== SEMUA USER DOSEN ===" . PHP_EOL;
$dosens = \App\Models\User::whereHas('role', function($q) {
    $q->where('nama', 'dosen');
})->with('biodata')->get();

foreach ($dosens as $dosen) {
    $nama = $dosen->biodata->nama ?? $dosen->username;
    echo "- {$nama} (User ID: {$dosen->id}, Username: {$dosen->username})" . PHP_EOL;
}
