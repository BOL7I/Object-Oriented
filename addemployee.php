<?php
include 'db.php';

// Add User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $Mail = $_POST['Mail'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $type = 'employee'; // Set the default type
    $Phone = isset($_POST['Phone']) ? $_POST['Phone'] : null;
    $Name = isset($_POST['Name']) ? $_POST['Name'] : null;

    $sql = "INSERT INTO user (Mail, password, Type, Phone, Name) VALUES ('$Mail', '$password', '$type', '$Phone', '$Name')";

    if ($conn->query($sql) === TRUE) {
        echo "User added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update User Password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $Mail = isset($_POST['Mail']) ? $_POST['Mail'] : null;
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null; // Hash the new password if provided

    if ($Mail !== null) {
        if ($password !== null) {
            $sql = "UPDATE user SET password='$password' WHERE Mail='$Mail'";
            
            if ($conn->query($sql) === TRUE) {
                echo "Password updated successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error: Password not provided for update";
        }
    } else {
        echo "Error: Mail not provided for update";
    }
}

// Delete User
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $Mail = isset($_POST['Mail']) ? $_POST['Mail'] : null;

    if ($Mail !== null) {
        $sql = "DELETE FROM user WHERE Mail='$Mail'";

        if ($conn->query($sql) === TRUE) {
            echo "User deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: Mail not provided for delete";
    }
}

// Display Users
$sql = "SELECT * FROM user";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="addemployee.css">
</head>
<body>
<div class="navbar">
    <a href="home(admin).php">Home</a>
    <a href="home.php">Sign Out</a>
</div>
    <div class="container">
        <h2>User Management</h2>

        <!-- Add User Form -->
        <form action="" method="post">
            <label for="Name">Name:</label>
            <input type="text" name="Name" id="Name">
            <label for="Mail">Mail:</label>
            <input type="email" name="Mail" id="Mail" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <label for="Phone">Phone:</label>
            <input type="text" name="Phone" id="Phone">
            <button type="submit" name="add_user">Add User</button>
        </form>

        <!-- Display Users -->
        <?php
        if ($result->num_rows > 0) {
            echo "<h3>Users:</h3>";
            echo "<ul>";
            while($row = $result->fetch_assoc()) {
                $Mail = isset($row['Mail']) ? $row['Mail'] : '';
                $password = isset($row['password']) ? $row['password'] : '';
                $type = isset($row['Type']) ? $row['Type'] : '';
                $Phone = isset($row['Phone']) ? $row['Phone'] : '';
                $Name = isset($row['Name']) ? $row['Name'] : '';

                echo "<li>{$Name} (Mail: {$Mail}, Password: {$password}, Type: {$type}, Phone: {$Phone}) (
                    <form style='display:inline;' action='' method='post'>
                        <input type='hidden' name='Mail' value='{$Mail}'>
                        <input type='hidden' name='password' value='{$password}'>
                        <button type='submit' name='update_user'>Update Password</button>
                    </form> |
                    <form style='display:inline;' action='' method='post'>
                        <input type='hidden' name='Mail' value='{$Mail}'>
                        <button type='submit' name='delete_user'>Delete</button>
                    </form>)
                </li>";
            }
            echo "</ul>";
        } else {
            echo "No users found";
        }
        ?>

    </div>

    <!-- Update User Form -->
    <h3>Update User</h3>
    <form id="updateForm" style="display:none;" action="" method="post">
        <input type="hidden" name="Mail" value="">
        <label for="password_update">New Password:</label>
        <input type="password" id="password_update" name="password">
        <button type="submit" name="update_user">Update Password</button>
    </form>

    <script>
        function updateUser(Mail, password, Phone) {
            document.getElementById("Mail_update").value = Mail;
            document.getElementById("password_update").value = password;

            // Show the update form
            document.getElementById("updateForm").style.display = "block";
        }
    </script>

</body>
</html>

<?php
$conn->close();
?>
