<?php
include "db.php";

if (isset($_POST["btn_edit"])) {
    $id = intval($_GET["id"]);
    $description = $_POST["description"];

    $stmt = $conn->prepare("UPDATE tasks SET description=? WHERE id=?");
    $stmt->bind_param("si", $description, $id);

    if ($stmt->execute() === TRUE) {
        echo "<script>alert('Tugas berhasil diperbarui'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch current task description
$id = intval($_GET["id"]);
$stmt = $conn->prepare("SELECT description FROM tasks WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($current_description);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include "layout/header.php" ?>

    <main>
        <form action="edit.php?id=<?php echo $id; ?>" method="POST">
            <label>Edit Tugas</label>
            <input type="text" name="description" value="<?php echo htmlspecialchars($current_description); ?>" required>
            <button type="submit" name="btn_edit">Simpan Perubahan</button>
        </form>
        <a href="index.php">Kembali</a>
    </main> 

    <?php include "layout/footer.php" ?>
</body>
</html>