<?php
include "db.php";

if (isset($_POST["btn_add"])) {
    $description = $_POST["description"];

    $sql = "INSERT INTO tasks (description) VALUES ('$description')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Tugas berhasil ditambahkan'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambahkan Tugas</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include "layout/header.php" ?>

    <main>
        <form action="add.php" method="POST">
            <label>Deskripsi Tugas</label>
            <input type="text" name="description" required>
            <button type="submit" name="btn_add">Tambahkan</button>
        </form>
        <a href="index.php">Kembali</a>
    </main> 

    <?php include "layout/footer.php" ?>
</body>
</html>