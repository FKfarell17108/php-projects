<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <header>
        <h2>Upload File</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">Choose file:</label>
            <input type="file" name="file" id="file" required>
            <br><br>
            <input type="submit" value="Upload">
        </form>
    </header>

    <main>
        <?php
        include 'db.php';

        $sql = "SELECT id, filename, uploaded_at FROM files";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo "<h2>Uploaded Files</h2>";
            echo "<table border='1'>
                <tr>
                    <th>Nomor</th>
                    <th>Nama File</th>
                    <th>Waktu Upload</th>
                    <th>Preview</th>
                    <th>Aksi</th>
                </tr>";
            $nomor = 1;
            while ($row = $result->fetch_assoc()) {
                $filePath = 'uploads/' . $row["filename"];
                $isImage = @getimagesize($filePath) ? true : false;
                echo "<tr>
                    <td>" . $nomor++ . "</td>
                    <td>" . $row["filename"] . "</td>
                    <td>" . $row["uploaded_at"] . "</td>
                    <td>";
                if ($isImage) {
                    echo "<img src='$filePath' alt='" . $row["filename"] . "' style='width:100px;'>";
                } else {
                    echo "Not an image";
                }
                echo "</td>
                    <td>
                        <a href='download.php?id=" . $row["id"] . "'>Download</a> | 
                        <a href='delete.php?id=" . $row["id"] . "'>Delete</a>
                    </td>
                  </tr>";
            }
            echo "</table>";
        } else {
            echo "No files uploaded yet.";
        }

        $conn->close();
        ?>
    </main>

    <footer>
        <hr>
        <p>&copy; 2025 - Farell Kurniawan</p>
    </footer>

</body>

</html>