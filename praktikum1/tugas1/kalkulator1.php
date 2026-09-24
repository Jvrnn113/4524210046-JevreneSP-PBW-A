<?php
// kalkulator.php
$angka1 = '';
$angka2 = '';
$operasi = '';
$hasil = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $angka1 = $_POST['angka1'] ?? '';
    $angka2 = $_POST['angka2'] ?? '';
    $operasi = $_POST['operasi'] ?? '';

    if (is_numeric($angka1) && is_numeric($angka2)) {
        switch ($operasi) {
            case 'tambah':
                $hasil = $angka1 + $angka2;
                break;
            case 'kurang':
                $hasil = $angka1 - $angka2;
                break;
            case 'kali':
                $hasil = $angka1 * $angka2;
                break;
            case 'bagi':
                if ($angka2 == 0) {
                    $error = "Error: Tidak dapat melakukan pembagian dengan angka nol (0)!";
                } else {
                    $hasil = $angka1 / $angka2;
                }
                break;
            case 'modulus':
                if ($angka2 == 0) {
                    $error = "Error: Modulus dengan angka nol tidak terdefinisi!";
                } else {
                    $hasil = $angka1 % $angka2;
                }
                break;
            case 'pangkat':
                $hasil = pow($angka1, $angka2);
                break;
            default:
                $error = "Pilih operasi matematika yang valid!";
        }
    } else {
        $error = "Masukkan angka yang valid pada kedua input!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Sederhana</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f4f9; }
        .calculator { max-width: 400px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="number"], select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { background-color: #008CBA; color: white; padding: 10px; border: none; border-radius: 4px; width: 100%; cursor: pointer; }
        .result { margin-top: 15px; padding: 10px; background: #dff0d8; color: #3c763d; border-radius: 4px; font-weight: bold; }
        .error-msg { margin-top: 15px; padding: 10px; background: #f2dede; color: #a94442; border-radius: 4px; }
    </style>
</head>
<body>

<div class="calculator">
    <h2>Kalkulator Lanjutan</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label>Angka Pertama:</label>
            <input type="number" step="any" name="angka1" value="<?= htmlspecialchars($angka1); ?>" required>
        </div>
        <div class="form-group">
            <label>Angka Kedua:</label>
            <input type="number" step="any" name="angka2" value="<?= htmlspecialchars($angka2); ?>" required>
        </div>
        <div class="form-group">
            <label>Operasi:</label>
            <select name="operasi" required>
                <option value="tambah" <?= $operasi == 'tambah' ? 'selected' : ''; ?>>Pertambahan (+)</option>
                <option value="kurang" <?= $operasi == 'kurang' ? 'selected' : ''; ?>>Pengurangan (-)</option>
                <option value="kali" <?= $operasi == 'kali' ? 'selected' : ''; ?>>Perkalian (×)</option>
                <option value="bagi" <?= $operasi == 'bagi' ? 'selected' : ''; ?>>Pembagian (÷)</option>
                <option value="modulus" <?= $operasi == 'modulus' ? 'selected' : ''; ?>>Modulus (%)</option>
                <option value="pangkat" <?= $operasi == 'pangkat' ? 'selected' : ''; ?>>Pangkat (^)</option>
            </select>
        </div>
        <button type="submit">Hitung</button>
    </form>

    <?php if ($hasil !== ''): ?>
        <div class="result">Hasil: <?= $hasil; ?></div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="error-msg"><?= $error; ?></div>
    <?php endif; ?>
</div>

</body>
</html>