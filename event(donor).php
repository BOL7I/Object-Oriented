<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
    <link rel="stylesheet" href="event(donor).css">
    <style>
        
    </style>
</head>
<body>
    
    <nav>
        <ul>
            <li><a href="home(donor).php">Home</a></li>
            <li><a href="home.php">Sign Out</a></li>
           
        </ul>
    </nav>

    <div class="events-container">
        <?php
        include 'db.php'; 

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if (isset($_POST['decrement_capacity'])) {
                $event_id = $_POST['event_id'];
               
                $sql_check_capacity = "SELECT capacity FROM events WHERE event_id = $event_id";
                $result_check_capacity = $conn->query($sql_check_capacity);

                if ($result_check_capacity->num_rows > 0) {
                    $row_check_capacity = $result_check_capacity->fetch_assoc();
                    $current_capacity = $row_check_capacity["capacity"];

                    if ($current_capacity > 0) {
                       
                        $sql_update_capacity = "UPDATE events SET capacity = capacity - 1 WHERE event_id = $event_id";
                        if ($conn->query($sql_update_capacity) === TRUE) {
                            echo '<script>alert("Capacity updated successfully");</script>';
                        } else {
                            echo '<script>alert("Error updating capacity: ' . $conn->error . '");</script>';
                        }
                    } else {
                        echo '<script>alert("Capacity is already zero. Cannot decrement further.");</script>';
                    }
                }
            }
        }

        $sql = "SELECT * FROM events";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="event-card">';
                echo '<h2>' . $row["event_name"] . '</h2>';
                echo '<p><strong>Description:</strong> ' . $row["event_description"] . '</p>';
                echo '<p><strong>Date:</strong> ' . $row["event_date"] . '</p>';
                echo '<p><strong>Time:</strong> ' . $row["event_time"] . '</p>';
                echo '<p><strong>Venue:</strong> ' . $row["venue"] . '</p>';
                echo '<p><strong>Organizer:</strong> ' . $row["organizer"] . '</p>';
                echo '<p><strong>Contact Information:</strong> ' . $row["contact_information"] . '</p>';
                echo '<p><strong>Capacity:</strong> ' . $row["capacity"] . '</p>';
                echo '<form method="post">';
                echo '<input type="hidden" name="event_id" value="' . $row["event_id"] . '">';
                echo '<button type="submit" name="decrement_capacity" ' . ($row["capacity"] > 0 ? '' : 'disabled') . '>Join Event</button>';
                echo '</form>';
                echo '<hr>';
                echo '</div>';
            }
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </div>

</body>
</html>
