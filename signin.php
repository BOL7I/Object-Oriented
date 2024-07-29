<?php
session_start();
include 'user.php';

$hostname = "localhost";
$username = "root";
$password = "";
$database = "charitys_system";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = new User($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = mysqli_real_escape_string($conn, $_POST['mail']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = $_POST['role'];

    if ($user->signIn($mail, $password, $role)) {
        $_SESSION['user_email'] = $mail;
        echo "Login successful for a $role!";

        // Redirect based on the user's role
        switch ($role) {
            case 'donor':
                header("Location: home(donor).php");
                break;
            case 'admin':
                header("Location: home(admin).php");
                break;
            case 'employee':
                header("Location: home(employee).php");
                break;
            default:
                echo "Invalid role type.";
                break;
        }

        exit();
    } else {
        echo "Login failed. Invalid email, password, or role type.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="userstyle.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="signin.php">Sign In</a></li>
            <li><a href="signup.php">Sign Up</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Sign In</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="mail">Email:</label>
            <input type="email" name="mail" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <label for="role">Select Role:</label>
            <select name="role" required>
                <option value="donor">Donor</option>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
            </select><br>

            <button type="submit">Sign In</button>
        </form>
        <p>Don't have an account? <a class="signlink" href="signup.php"> Sign Up</a></p>
    </div>
</body>
</html>
