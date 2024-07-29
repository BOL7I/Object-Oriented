<?php

class DonationSave
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function saveDonation($defaultEmail, $amount, $paymentMethod)
    {
        // Insert donation information into the database
        $insertQuery = "INSERT INTO money_donation (Mail, amount, Type_pay) VALUES ('$defaultEmail', '$amount', '$paymentMethod')";
        $insertResult = $this->conn->query($insertQuery);

        if (!$insertResult) {
            die("Insert query failed: " . $this->conn->error);
        } else {
            echo "Donation saved successfully!";
        }
    }
    public function saveDonation1($defaultEmail, $amount, $paymentMethod)
    {
        // Insert donation information into the database
        $insertQuery = "INSERT INTO food_donation (Mail, Type_food) VALUES ('$defaultEmail', '$paymentMethod')";
        $insertResult = $this->conn->query($insertQuery);

        if (!$insertResult) {
            die("Insert query failed: " . $this->conn->error);
        } else {
            echo "Donation saved successfully!";
        }
    }
    public function saveDonation2($defaultEmail, $amount, $paymentMethod)
    {
        // Insert donation information into the database
        $insertQuery = "INSERT INTO other_donation (Mail, Type_other,descriptionother) VALUES ('$defaultEmail','$amount', '$paymentMethod')";
        $insertResult = $this->conn->query($insertQuery);

        if (!$insertResult) {
            die("Insert query failed: " . $this->conn->error);
        } else {
            echo "Donation saved successfully!";
        }
    }
    public function saveDonation3($defaultEmail, $amount, $paymentMethod)
    {
        // Insert donation information into the database
        $insertQuery = "INSERT INTO feedbacks (Mail, feedback_desc) VALUES ('$defaultEmail', '$paymentMethod')";
        $insertResult = $this->conn->query($insertQuery);

        if (!$insertResult) {
            die("Insert query failed: " . $this->conn->error);
        } else {
            echo "Donation saved successfully!";
        }
    }
}

?>
