<?php
// 1. Array multidimensi mata kuliah (nama, sks, nilai 0-100)
$matkul = [
    ['nama' => 'Algoritma dan Pemrograman', 'sks' => 3, 'nilai' => 88],
    ['nama' => 'Struktur Data',             'sks' => 3, 'nilai' => 76],
    ['nama' => 'Basis Data',                'sks' => 3, 'nilai' => 64],
    ['nama' => 'Matematika Diskrit',        'sks' => 2, 'nilai' => 48],
    ['nama' => 'Jaringan Komputer',         'sks' => 3, 'nilai' => 81],
    ['nama' => 'Pemrograman Web',           'sks' => 3, 'nilai' => 92],
    ['nama' => 'Statistika',                'sks' => 2, 'nilai' => 35],
];

// 2. Fungsi helper: konversi nilai angka ke huruf dan bobot
function hitungBobot($nilai)
{
    if ($nilai >= 85) {
        return ['huruf' => 'A', 'bobot' => 4.0];
    } elseif ($nilai >= 70) {
        return ['huruf' => 'B', 'bobot' => 3.0];
    } elseif ($nilai >= 55) {
        return ['huruf' => 'C', 'bobot' => 2.0];
    } elseif ($nilai >= 40) {
        return ['huruf' => 'D', 'bobot' => 1.0];
    } else {
        return ['huruf' => 'E', 'bobot' => 0.0];
    }
}

// Proses data: hitung huruf, bobot, status, dan total untuk IPS
$totalSks   = 0;
$totalMutu  = 0;
$jmlLulus   = 0;
$jmlUlang   = 0;

foreach ($matkul as $i => $mk) {
    $hasil  = hitungBobot($mk['nilai']);
    $status = $hasil['bobot'] >= 2.0 ? 'LULUS' : 'MENGULANG';

    $matkul[$i]['huruf']  = $hasil['huruf'];
    $matkul[$i]['bobot']  = $hasil['bobot'];
    $matkul[$i]['mutu']   = $hasil['bobot'] * $mk['sks'];
    $matkul[$i]['status'] = $status;

    $totalSks  += $mk['sks'];
    $totalMutu += $matkul[$i]['mutu'];
    $status === 'LULUS' ? $jmlLulus++ : $jmlUlang++;
}

// 5. Ringkasan IPS
$ips = $totalSks > 0 ? $totalMutu / $totalSks : 0;

// 6. Batas maksimal SKS semester depan
$maxSks = $ips >= 3.00 ? 24 : 20;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Hasil Studi</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
            margin: 0;
            padding: 32px 16px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
            padding: 28px;
        }
        h1 { margin: 0 0 4px; font-size: 24px; }
        .sub { margin: 0 0 24px; color: #6b7280; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px 12px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #1e3a8a; color: #fff; font-weight: 600; }
        td.c, th.c { text-align: center; }
        tr.mengulang td { background: #fee2e2; color: #b91c1c; font-weight: 600; }
        .badge { padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .badge.lulus { background: #dcfce7; color: #166534; }
        .badge.ulang { background: #dc2626; color: #fff; }
        tfoot td { font-weight: 700; background: #f9fafb; }
        .ringkasan {
            margin-top: 24px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
        }
        .kartu { border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px 16px; }
        .kartu .label { font-size: 13px; color: #6b7280; }
        .kartu .nilai { font-size: 24px; font-weight: 700; margin-top: 4px; }
        .kartu.utama { background: #1e3a8a; color: #fff; border-color: #1e3a8a; }
        .kartu.utama .label { color: #c7d2fe; }
        .info { margin-top: 16px; padding: 12px 16px; border-left: 4px solid #1e3a8a; background: #eef2ff; border-radius: 4px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Kartu Hasil Studi</h1>
    <p class="sub">Daftar nilai mata kuliah semester ini</p>

    <!-- 3 & 4. Tabel nilai, baris MENGULANG berwarna merah -->
    <table>
        <thead>
            <tr>
                <th class="c">No</th>
                <th>Mata Kuliah</th>
                <th class="c">SKS</th>
                <th class="c">Nilai Angka</th>
                <th class="c">Nilai Huruf</th>
                <th class="c">Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($matkul as $no => $mk): ?>
            <tr class="<?= $mk['status'] === 'MENGULANG' ? 'mengulang' : '' ?>">
                <td class="c"><?= $no + 1 ?></td>
                <td><?= htmlspecialchars($mk['nama']) ?></td>
                <td class="c"><?= $mk['sks'] ?></td>
                <td class="c"><?= $mk['nilai'] ?></td>
                <td class="c"><?= $mk['huruf'] ?></td>
                <td class="c">
                    <span class="badge <?= $mk['status'] === 'LULUS' ? 'lulus' : 'ulang' ?>">
                        <?= $mk['status'] ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total SKS</td>
                <td class="c"><?= $totalSks ?></td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>

    <!-- 5. Ringkasan IPS -->
    <h2 style="margin-top:28px;font-size:18px;">Ringkasan IPS</h2>
    <div class="ringkasan">
        <div class="kartu utama">
            <div class="label">Indeks Prestasi Semester</div>
            <div class="nilai"><?= number_format($ips, 2) ?></div>
        </div>
        <div class="kartu">
            <div class="label">Total SKS / Total Mutu</div>
            <div class="nilai"><?= $totalSks ?> / <?= number_format($totalMutu, 1) ?></div>
        </div>
        <div class="kartu">
            <div class="label">Lulus / Mengulang</div>
            <div class="nilai"><?= $jmlLulus ?> / <?= $jmlUlang ?></div>
        </div>
        <div class="kartu">
            <div class="label">Maks. SKS Semester Depan</div>
            <div class="nilai"><?= $maxSks ?> SKS</div>
        </div>
    </div>

    <!-- 6. Batas maksimal SKS semester depan -->
    <div class="info">
        IPS kamu <strong><?= number_format($ips, 2) ?></strong>
        (<?= $ips >= 3.00 ? '&ge; 3.00' : '&lt; 3.00' ?>), sehingga semester depan
        boleh mengambil maksimal <strong><?= $maxSks ?> SKS</strong>.
    </div>
</div>
</body>
</html>
