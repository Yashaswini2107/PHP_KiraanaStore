<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grocery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve feedback
$sql = "SELECT * FROM contactus";
$result = $conn->query($sql);

// Display the feedback data in a table
if ($result->num_rows > 0) {
    echo "<h2>Feedback</h2>";
    echo '<div style="display: flex; justify-content: center;">';
    echo '<table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">';
    echo '<thead><tr><th style="border: 1px solid #000; padding: 8px;">Email</th><th style="border: 1px solid #000; padding: 8px;">Message</th></tr></thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td style="border: 1px solid #000; padding: 8px;">' . $row["email"] . '</td>';
        echo '<td style="border: 1px solid #000; padding: 8px;">' . $row["message"] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
} else {
    echo "No feedback found.";
}

// Close the database connection
$conn->close();
?>
