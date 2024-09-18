<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tema = $_POST['tema'];
    $tgl_tema = $_POST['tgl_tema'];
    $isi_tema = $_POST['isi_tema'];

    // Escape string untuk menghindari SQL Injection
    $tema = $conn->real_escape_string($tema);
    $tgl_tema = $conn->real_escape_string($tgl_tema);
    $isi_tema = $conn->real_escape_string($isi_tema);

    $sql = "INSERT INTO jurnal (tema, tgl_tema, isi_tema) VALUES ('$tema', '$tgl_tema', '$isi_tema')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Jurnal berhasil ditambahkan!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Jurnal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h1>Aplikasi Jurnal</h1>

        <!-- Tampilkan Pesan -->
        <?php if (isset($success_message)): ?>
            <div style="color: green; text-align: center; margin-bottom: 20px;">
                <?php echo $success_message; ?>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div style="color: red; text-align: center; margin-bottom: 20px;">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Form Tambah Jurnal -->
        <form method="POST" action="">
            <label for="tema">Tema:</label>
            <input type="text" id="tema" name="tema" maxlength="100" required>

            <label for="tgl_tema">Tanggal Tema:</label>
            <input type="date" id="tgl_tema" name="tgl_tema" required>

            <label for="isi_tema">Isi Tema:</label>
            <textarea id="isi_tema" name="isi_tema" rows="5" maxlength="300" required></textarea>

            <input type="submit" value="Simpan Jurnal">
        </form>

        <!-- Daftar Jurnal -->
        <div class="journal-list">
            <h2>Daftar Jurnal</h2>

            <?php
            $sql = "SELECT * FROM jurnal ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='journal-item'>";
                    echo "<h3>" . htmlspecialchars($row["tema"]) . " (" . $row["tgl_tema"] . ")</h3>";
                    echo "<p>" . htmlspecialchars($row["isi_tema"]) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-data'>Belum ada jurnal yang ditambahkan.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>

</body>
</html>
