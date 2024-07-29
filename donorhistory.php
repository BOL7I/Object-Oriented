<?php
session_start();
include_once 'sendmailform.php';
include_once 'donationdata.php';

$hostname = "localhost";
$username = "root";
$password = "";
$database = "charitys_system";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Instantiate SendMail and DonationSave classes
$sendMail = new SendMail($conn);
$donationdata = new Donationdata($conn);

$defaultEmail = $sendMail->getDefaultEmail();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the index is set before using it
    $Type_food = isset($_POST["Type_food"]) ? mysqli_real_escape_string($conn, $_POST["Type_food"]) : '';

    // Call the getDonationData function from DonationSave
    $donationData = $donationdata->getDonationData($defaultEmail, $Type_food);
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
        <li><a href="home(donor).php">Home</a></li>
        <li><a href="home.php">Sign Out</a></li>
    </ul>
</nav>

<div class="donation-form">
    <h2>View History</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Email (not editable):</label>
        <input type="email" id="email" name="email" readonly value="<?php echo $defaultEmail; ?>">

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
