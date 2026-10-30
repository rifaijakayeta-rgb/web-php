<?php
$matkul = [
    [
        "nama"  => "Pemrograman Web Lanjut",
        "sks"   => 3,
        "nilai" => 85
    ],
    [
        "nama"  => "Basis Data Terdistribusi",
        "sks"   => 4,
        "nilai" => 55
    ],
    [
        "nama"  => "Kecerdasan Buatan",
        "sks"   => 3,
        "nilai" => 78
    ],
    [
        "nama"  => "Jaringan Komputer",
        "sks"   => 3,
        "nilai" => 42
    ],
    [
        "nama"  => "Sistem Operasi",
        "sks"   => 3,
        "nilai" => 90
    ]
];

function hitungBobot($nilai) {
    if ($nilai >= 80) {
        return ["huruf" => "A", "bobot" => 4.0];
    } elseif ($nilai >= 70) {
        return ["huruf" => "B", "bobot" => 3.0];
    } elseif ($nilai >= 60) {
        return ["huruf" => "C", "bobot" => 2.0];
    } elseif ($nilai >= 50) {
        return ["huruf" => "D", "bobot" => 1.0];
    } else {
        return ["huruf" => "E", "bobot" => 0.0];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transkrip Nilai & Hitung IPS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container my-5">
        <h2 class="mb-4 text-center fw-bold">Transkrip Nilai & Evaluasi IPS Mahasiswa</h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Nilai Angka</th>
                            <th>Nilai Huruf</th>
                            <th>Bobot</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $total_sks = 0;
                        $total_mutu = 0;

                        foreach ($matkul as $mk): 
                            $hasil_konversi = hitungBobot($mk['nilai']);
                            $huruf = $hasil_konversi['huruf'];
                            $bobot = $hasil_konversi['bobot'];

                            if ($bobot >= 2.0) {
                                $status = "LULUS";
                                $class_row = ""; 
                            } else {
                                $status = "MENGULANG";
                                $class_row = "table-danger text-danger"; 
                            }

                            $total_sks += $mk['sks'];
                            $total_mutu += ($bobot * $mk['sks']);
                        ?>
                        <tr class="<?= $class_row ?>">
                            <td><?= $no++ ?></td>
                            <td class="text-start"><?= $mk['nama'] ?></td>
                            <td><?= $mk['sks'] ?></td>
                            <td><?= $mk['nilai'] ?></td>
                            <td class="fw-bold"><?= $huruf ?></td>
                            <td><?= number_format($bobot, 1) ?></td>
                            <td class="fw-bold"><?= $status ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php 
        $ips = ($total_sks > 0) ? ($total_mutu / $total_sks) : 0;

        if ($ips >= 3.00) {
            $max_sks = 24;
        } else {
            $max_sks = 20;
        }
        ?>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-primary">
                    <div class="card-body">
                        <h5 class="card-title text-primary fw-bold">Ringkasan IPS</h5>
                        <hr>
                        <p class="mb-1">Total SKS Diambil: <strong><?= $total_sks ?></strong></p>
                        <p class="mb-1">Total Nilai Mutu: <strong><?= number_format($total_mutu, 2) ?></strong></p>
                        <h4 class="mt-3">Indeks Prestasi Semester (IPS): <span class="text-success fw-bold"><?= number_format($ips, 2) ?></span></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-success">
                    <div class="card-body">
                        <h5 class="card-title text-success fw-bold">Batas Maksimal SKS Semester Depan</h5>
                        <hr>
                        <p class="text-muted">Berdasarkan pencapaian IPS Anda semester ini:</p>
                        <h3 class="text-dark fw-bold"><?= $max_sks ?> SKS</h3>
                        <p class="small text-secondary mb-0">
                            <?php if ($ips >= 3.00): ?>
                                Selamat! Karena IPS Anda &ge; 3.00, Anda berhak mengambil maksimal 24 SKS.
                            <?php else: ?>
                                Karena IPS Anda &lt; 3.00, batas maksimal SKS yang dapat diambil adalah 20 SKS.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
