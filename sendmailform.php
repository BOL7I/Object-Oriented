<?php

class SendMail
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getDefaultEmail()
    {
        $defaultEmail = '';

        if (isset($_SESSION['user_email'])) {
            // If the email is set in the session, use it as the default
            $defaultEmail = $_SESSION['user_email'];
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            // If the form is submitted, retrieve the email from the form data
            $mail = isset($_POST['email']) ? mysqli_real_escape_string($this->conn, $_POST['email']) : '';
            $password = isset($_POST['password']) ? mysqli_real_escape_string($this->conn, $_POST['password']) : '';
            $role = isset($_POST['role']) ? $_POST['role'] : '';

            $query = "SELECT * FROM user WHERE mail='$mail' AND type='$role'";
            $result = $this->conn->query($query);

            if (!$result) {
                die("Query failed: " . $this->conn->error);
            }

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['password'];

                if (password_verify($password, $hashedPassword)) {
                    // If the password is correct, set the default email
                    $defaultEmail = $mail;
                } else {
                    echo "Login failed. Invalid email, password, or role type.";
                }
            } else {
                echo "Login failed. Invalid email, role, or password.";
            }
        }

        return $defaultEmail;
    }
}

?>
