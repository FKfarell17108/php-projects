<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $maxFileSize = 2 * 1024 * 1024; // 2 MB

    // Check if file is not empty
    if ($_FILES["file"]["size"] == 0) {
        echo "file kosong";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > $maxFileSize) {
        echo "max file size 2MB";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedTypes = ['jpg', 'png', 'pdf'];
    if (!in_array($fileType, $allowedTypes)) {
        echo "maaf, hanya file JPG, PNG, dan PDF yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "maaf, file tidak diupload.";
    } else {
        // Sanitize file name
        $filename = preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES["file"]["name"]));
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "file " . htmlspecialchars($filename) . " berhasil diupload.";

            // Save file info to database
            $filepath = $target_file;

            $stmt = $conn->prepare("INSERT INTO files (filename, file_path) VALUES (?, ?)");
            $stmt->bind_param("ss", $filename, $filepath);

            if ($stmt->execute()) {
                echo "file info berhasil disimpan ke database.";
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "maaf, terjadi kesalahan saat mengupload file.";
        }
    }
}

$conn->close();
?>