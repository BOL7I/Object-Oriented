<?php
session_start();
include_once 'sendmailform.php';
include_once 'savedonation.php';

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
$donationSave = new DonationSave($conn);

$defaultEmail = $sendMail->getDefaultEmail();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
    $paymentMethod = mysqli_real_escape_string($conn, $_POST["paymentMethod"]);

    // Call the saveDonation function from DonationSave
    $donationSave->saveDonation1($defaultEmail, $amount, $paymentMethod);
    header("Location: home(donor).php");
    exit();
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
    <h2>Make a Donation</h2>
    <form id="donationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Email (not editable):</label>
        <input type="email" id="email" name="email" readonly value="<?php echo $defaultEmail; ?>">

        <label for="paymentMethod">Food Type</label>
        <select id="paymentMethod" name="paymentMethod" required>
            <option value="frozenfood">Frozen Food</option>
            <option value="freshfood">Fresh Food</option>
        </select>

        <button type="button" onclick="submitForm()">Donate</button>
    </form>

    <script>
        function submitForm() {
            // Show a message box after donation is submitted
            var email = document.getElementById('email').value;
            var foodType = document.getElementById('paymentMethod').value;
            var currentDate = new Date().toLocaleDateString();

            var message = "Receipt:\nEmail: " + email + "\nFood Type: " + foodType + "\nDate: " + currentDate + "\nDelivery will arrive in 30min";

            alert(message);

            // Submit the form
            document.getElementById('donationForm').submit();
        }
    </script>
</div>

</body>
</html>