<?php
session_start();

if (isset($_POST['btn_logout'])) {
    // Destroy the session and redirect to the login page
    session_destroy();
    echo '<script>alert("Logout berhasil"); window.location = "index.php";</script>';
    exit();
}
?>