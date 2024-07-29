<?php

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function signIn($mail, $password, $role)
    {
        $query = "SELECT * FROM user WHERE mail='$mail' AND type='$role'";
        $result = $this->conn->query($query);

        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_email'] = $mail;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
