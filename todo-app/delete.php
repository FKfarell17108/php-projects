<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM tasks WHERE id = $id";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "<script>alert('Tugas berhasil dihapus'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>