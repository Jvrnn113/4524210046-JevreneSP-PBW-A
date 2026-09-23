<?php
//Biodata.php
function statuskelulusan(float $ipk): string{
    if ($ipk >= 3.50) return 'Sangat Memuaskan';
    if ($ipk >= 3.00) return 'Memuaskan';
    return 'Perlu penigkatan';
}
$mahasiswa = [
    'nim' => '2026001',
    'nama' => 'Jevrene Samny Pratama',
    'prodi' => 'Teknik Informatika',
    'semester' => 5,
    'ipk' => 3.72
];
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Biodata</title>
</head>

<body>
    <h1>Biodata Mahasiswa</h1>
    <ul>
        <?php foreach ($mahasiswa as $kunci => $nilai): ?>
            <li><?= ucfirst($kunci) ?>: <?= htmlspecialchars((string)$nilai) ?></li>
        <?php endforeach; ?>
    </ul>
    <p>Predikat: <?= statuskelulusan($mahasiswa['ipk']) ?></p>
</body>

</html>