<?php
// biodata.php
$nama = "";
$prodi = "";
$email = "";
$bio = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama'] ?? '');
    $prodi = htmlspecialchars($_POST['prodi'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $bio = htmlspecialchars($_POST['bio'] ?? '');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Biodata Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f4f9; }
        .container { max-width: 500px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
        button:hover { background-color: #45a049; }
        .result { margin-top: 20px; padding: 15px; background: #e7f3fe; border-left: 6px solid #2196F3; }
    </style>
</head>
<body>

<div class="container">
    <h2>Form Biodata Mahasiswa</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label>Nama Lengkap:</label>
            <input type="text" name="nama" required value="<?= $nama; ?>">
        </div>
        <div class="form-group">
            <label>Program Studi:</label>
            <input type="text" name="prodi" required value="<?= $prodi; ?>">
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required value="<?= $email; ?>">
        </div>
        <div class="form-group">
            <label>Bio Singkat:</label>
            <textarea name="bio" rows="3"><?= $bio; ?></textarea>
        </div>
        <button type="submit">Simpan Biodata</button>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <div class="result">
            <h3>Hasil Input Biodata:</h3>
            <p><strong>Nama:</strong> <?= $nama; ?></p>
            <p><strong>Program Studi:</strong> <?= $prodi; ?></p>
            <p><strong>Email:</strong> <?= $email; ?></p>
            <p><strong>Bio:</strong> <?= nl2br($bio); ?></p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>