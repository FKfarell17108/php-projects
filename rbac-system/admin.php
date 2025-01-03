<?php

include 'db.php';

// Handle form submission for adding and editing users
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $username = $_POST['username'];

    if ($id) {
        // Update user
        $sql = "UPDATE users SET username='$username' WHERE id=$id";
    } else {
        // Add new user
        $sql = "INSERT INTO users (username) VALUES ('$username')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle delete user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle search user
$search = $_GET['search'] ?? '';
$sql = "SELECT id, username FROM users WHERE username LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <h1>Hello, Admin</h1>

    <form method="GET" action="">
        <label for="search">Search by Username:</label>
        <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <h2>User List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['username']}</td>
                    <td>
                        <a href='javascript:void(0)' onclick='editUser({$row['id']}, \"{$row['username']}\")'>Edit</a>
                        <a href='?delete={$row['id']}'>Delete</a>
                    </td>
                  </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No users found</td></tr>";
        }
        ?>
    </table>

    <h2>Edit User</h2>
    <form method="POST" action="">
        <input type="hidden" name="id" id="user_id">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
        <button type="submit">Save</button>
    </form>

    <script>
        function editUser(id, username) {
            document.getElementById('user_id').value = id;
            document.getElementById('username').value = username;
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>