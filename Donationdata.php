<?php

class DonationData
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getDonationData($email)
    {
        // Select donation information from money_donation table based on email
        $moneyQuery = "SELECT * FROM money_donation WHERE Mail = '$email'";
        $moneyResult = $this->conn->query($moneyQuery);

        if (!$moneyResult) {
            die("Money query failed: " . $this->conn->error);
        }

        // Select donation information from food_donation table based on email
        $foodQuery = "SELECT * FROM food_donation WHERE Mail = '$email'";
        $foodResult = $this->conn->query($foodQuery);

        if (!$foodResult) {
            die("Food query failed: " . $this->conn->error);
        }

        // Select donation information from other_donation table based on email
        $otherQuery = "SELECT * FROM other_donation WHERE Mail = '$email'";
        $otherResult = $this->conn->query($otherQuery);

        if (!$otherResult) {
            die("Other query failed: " . $this->conn->error);
        }

        // Combine the results from all tables into an array
        $donationData = array();

        while ($row = $moneyResult->fetch_assoc()) {
            $donationData['money'][] = $row;
        }

        while ($row = $foodResult->fetch_assoc()) {
            $donationData['food'][] = $row;
        }

        while ($row = $otherResult->fetch_assoc()) {
            $donationData['other'][] = $row;
        }

        return $donationData;
    }
    public function getAllDonationData()
    {
        // Define table names
        $tables = ['money_donation', 'food_donation', 'other_donation'];

        // Initialize the array to hold all donation data
        $donationData = array();

        // Loop through each table and fetch donation data
        foreach ($tables as $table) {
            $query = "SELECT * FROM $table";
            $result = $this->conn->query($query);

            if (!$result) {
                die("$table query failed: " . $this->conn->error);
            }

            // Combine the results into the donationData array
            while ($row = $result->fetch_assoc()) {
                $donationData[$table][] = $row;
            }
        }

        return $donationData;
    }
    public function getAllDonationData1()
    {
        // Define table names
        $tables = ['feedbacks'];

        // Initialize the array to hold all donation data
        $donationData = array();

        // Loop through each table and fetch donation data
        foreach ($tables as $table) {
            $query = "SELECT * FROM $table";
            $result = $this->conn->query($query);

            if (!$result) {
                die("$table query failed: " . $this->conn->error);
            }

            // Combine the results into the donationData array
            while ($row = $result->fetch_assoc()) {
                $donationData[$table][] = $row;
            }
        }

        return $donationData;
    }

}

?>
