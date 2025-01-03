<?php
include 'db.php';

// Ambil ID dari parameter URL
$file_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($file_id > 0) {
    // Query untuk mendapatkan informasi file berdasarkan ID
    $sql = "SELECT filename, file_path FROM files WHERE id = $file_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Ambil data file
        $row = $result->fetch_assoc();
        $filename = $row['filename'];
        $file_path = $row['file_path'];

        // Periksa apakah file ada
        if (file_exists($file_path)) {
            // Atur header untuk mengunduh file
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            flush(); // Flush sistem output buffer
            readfile($file_path);
            exit;
        } else {
            echo "File tidak ditemukan.";
        }
    } else {
        echo "File tidak ditemukan.";
    }
} else {
    echo "ID file tidak valid.";
}

$conn->close();