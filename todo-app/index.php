<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <?php include "layout/header.php" ?>

    <main>
        <h2>Daftar Tugas</h2>
        <a href="add.php">Tambahkan Tugas</a>
        <table border="1">
            <?php
            include "db.php";

            $sql = "SELECT id, description FROM tasks";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<tr>
                        <th>No</th>
                        <th>Description</th>
                        <th>Action</th>
                      </tr>";

                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>
                            <a href='edit.php?id=" . $row["id"] . "'><button>Edit</button></a>
                            <a href='delete.php?id=" . $row["id"] . "'><button>Delete</button></a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No data found</td></tr>";
            }
            ?>
        </table>
    </main>

    <?php include "layout/footer.php" ?>
</body>

</html>