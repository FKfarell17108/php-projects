<?php
include 'db.php';

// Ambil ID dari parameter URL
$id = $_GET['id'];

// Ambil nama file dari database berdasarkan ID
$sql = "SELECT filename FROM files WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($filename);
    $stmt->fetch();
    $stmt->close();

    // Hapus file dari folder /uploads
    $file_path = __DIR__ . "/uploads/" . $filename;
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    // Hapus data dari database
    $sql = "DELETE FROM files WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();

// Redirect ke halaman sebelumnya atau halaman lain
header("Location: index.php");
exit();