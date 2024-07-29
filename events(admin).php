<?php
include 'db.php';

// Add Event
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
    $eventName = $_POST['event_name'];
    $eventDescription = $_POST['event_description'];
    $eventDate = $_POST['event_date'];
    $eventTime = $_POST['event_time'];
    $venue = $_POST['venue'];
    $organizer = $_POST['organizer'];
    $contactInformation = $_POST['contact_information'];
    $capacity = $_POST['capacity'];

    $sql = "INSERT INTO events (event_name, event_description, event_date, event_time, venue, organizer, contact_information, capacity) 
            VALUES ('$eventName', '$eventDescription', '$eventDate', '$eventTime', '$venue', '$organizer', '$contactInformation', $capacity)";

    if ($conn->query($sql) === TRUE) {
        echo "Event added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Update Event
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_event'])) {
    $eventId = $_POST['event_id'];
    $eventName = $_POST['event_name'];
    $eventDescription = $_POST['event_description'];
    $eventDate = $_POST['event_date'];
    $eventTime = $_POST['event_time'];
    $venue = $_POST['venue'];
    $organizer = $_POST['organizer'];
    $contactInformation = $_POST['contact_information'];
    $capacity = $_POST['capacity'];

    $sql = "UPDATE events 
            SET event_name='$eventName', event_description='$eventDescription', event_date='$eventDate', event_time='$eventTime', 
                venue='$venue', organizer='$organizer', contact_information='$contactInformation', capacity=$capacity 
            WHERE event_id=$eventId";

    if ($conn->query($sql) === TRUE) {
        echo "Event updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete Event
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_event'])) {
    $eventId = $_POST['event_id'];

    $sql = "DELETE FROM events WHERE event_id=$eventId";

    if ($conn->query($sql) === TRUE) {
        echo "Event deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Display Events
$sql = "SELECT * FROM events";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="events(admin).css">
</head>
<body>
    <div class="container">
        <h2>Event Management</h2>

        <!-- Add Event Form -->
        <form action="" method="post">
            <label for="event_name">Event Name:</label>
            <input type="text" name="event_name" id="event_name" required>
            <label for="event_description">Event Description:</label>
            <textarea name="event_description" id="event_description" rows="3"></textarea>
            <label for="event_date">Event Date:</label>
            <input type="date" name="event_date" id="event_date" required>
            <label for="event_time">Event Time:</label>
            <input type="time" name="event_time" id="event_time" required>
            <label for="venue">Venue:</label>
            <input type="text" name="venue" id="venue" required>
            <label for="organizer">Organizer:</label>
            <input type="text" name="organizer" id="organizer" required>
            <label for="contact_information">Contact Information:</label>
            <input type="text" name="contact_information" id="contact_information" required>
            <label for="capacity">Capacity:</label>
            <input type="number" name="capacity" id="capacity" required>
            <button type="submit" name="add_event">Add Event</button>
        </form>

        <!-- Display Events -->
        <?php
        if ($result->num_rows > 0) {
            echo "<h3>Events:</h3>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                $eventId = isset($row['event_id']) ? $row['event_id'] : '';
                $eventName = isset($row['event_name']) ? $row['event_name'] : '';
                $eventDescription = isset($row['event_description']) ? $row['event_description'] : '';
                $eventDate = isset($row['event_date']) ? $row['event_date'] : '';
                $eventTime = isset($row['event_time']) ? $row['event_time'] : '';
                $venue = isset($row['venue']) ? $row['venue'] : '';
                $organizer = isset($row['organizer']) ? $row['organizer'] : '';
                $contactInformation = isset($row['contact_information']) ? $row['contact_information'] : '';
                $capacity = isset($row['capacity']) ? $row['capacity'] : '';

                echo "<li>{$eventName} (Date: {$eventDate}, Time: {$eventTime}, Venue: {$venue}, Capacity: {$capacity}) (
                    <form style='display:inline;' action='' method='post'>
                        <input type='hidden' name='event_id' value='{$eventId}'>
                        <input type='hidden' name='event_name' value='{$eventName}'>
                        <input type='hidden' name='event_description' value='{$eventDescription}'>
                        <input type='hidden' name='event_date' value='{$eventDate}'>
                        <input type='hidden' name='event_time' value='{$eventTime}'>
                        <input type='hidden' name='venue' value='{$venue}'>
                        <input type='hidden' name='organizer' value='{$organizer}'>
                        <input type='hidden' name='contact_information' value='{$contactInformation}'>
                        <input type='hidden' name='capacity' value='{$capacity}'>
                        <button type='submit' name='update_event'>Update</button>
                    </form> |
                    <form style='display:inline;' action='' method='post'>
                        <input type='hidden' name='event_id' value='{$eventId}'>
                        <button type='submit' name='delete_event'>Delete</button>
                    </form>)
                </li>";
            }
            echo "</ul>";
        } else {
            echo "No events found";
        }
        ?>
    </div>

    <!-- Update Event Form -->
    <h3>Update Event</h3>
    <form id="updateForm" style="display:none;" action="" method="post">
        <input type="hidden" name="event_id" value="">
        <label for="event_name_update">Event Name:</label>
        <input type="text" id="event_name_update" name="event_name" required>
        <label for="event_description_update">Event Description:</label>
        <textarea id="event_description_update" name="event_description" rows="3"></textarea>
        <label for="event_date_update">Event Date:</label>
        <input type="date" id="event_date_update" name="event_date" required>
        <label for="event_time_update">Event Time:</label>
        <input type="time" id="event_time_update" name="event_time" required>
        <label for="venue_update">Venue:</label>
        <input type="text" id="venue_update" name="venue" required>
        <label for="organizer_update">Organizer:</label>
        <input type="text" id="organizer_update" name="organizer" required>
        <label for="contact_information_update">Contact Information:</label>
        <input type="text" id="contact_information_update" name="contact_information" required>
        <label for="capacity_update">Capacity:</label>
        <input type="number" id="capacity_update" name="capacity" required>
        <button type="submit" name="update_event">Update Event</button>
    </form>

    <script>
        function updateEvent(eventId, eventName, eventDescription, eventDate, eventTime, venue, organizer, contactInformation, capacity) {
            document.getElementById("event_id_update").value = eventId;
            document.getElementById("event_name_update").value = eventName;
            document.getElementById("event_description_update").value = eventDescription;
            document.getElementById("event_date_update").value = eventDate;
            document.getElementById("event_time_update").value = eventTime;
            document.getElementById("venue_update").value = venue;
            document.getElementById("organizer_update").value = organizer;
            document.getElementById("contact_information_update").value = contactInformation;
            document.getElementById("capacity_update").value = capacity;

            // Show the update form
            document.getElementById("updateForm").style.display = "block";
        }
    </script>

</body>
</html>

<?php
$conn->close();
?>
