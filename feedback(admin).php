<?php
session_start();
include_once 'donationdata.php';

$hostname = "localhost";
$username = "root";
$password = "";
$database = "charitys_system";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Instantiate Donationdata class
$donationdata = new Donationdata($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Call the getAllDonationData function from Donationdata
    $donationData = $donationdata->getAllDonationData1();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Form</title>
    <link rel="stylesheet" href="fooddonatio.css">
</head>

<body>

<nav>
    <ul>
        <li><a href="home(employee).php">Home</a></li>
        <li><a href="home.php">Sign Out</a></li>
    </ul>
</nav>

<div class="donation-form">
    <h2>View History</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <?php
        // Display donation data if available
        if (isset($donationData)) {
            echo "<h3>Donation Data:</h3>";
            echo "<pre>";
            print_r($donationData);
            echo "</pre>";
        }
        ?>

        <button type="submit">View</button>
    </form>
</div>

</body>
</html>
