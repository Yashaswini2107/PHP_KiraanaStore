<style>
 .view-details-box {
    display: inline-block;
    background-color: green;
    padding: 3px 6px;
    border-radius: 5px;
    transition: background-color 0.3s;
    font-size: 12px;
}


.view-details-box a {
    color:#ffffff
    text-decoration: none;
}


</style>
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

// Query to retrieve shop requests
$sql = "SELECT * FROM ownerform1 WHERE status = 'pending'";
$result = $conn->query($sql);


// Display the list of shop requests
// ...

// Display the list of shop requests
if ($result->num_rows > 0) {
    $data = $result->fetch_all(MYSQLI_ASSOC);

    echo '<h2> New Shop Requests</h2><br>';

    foreach ($data as $row) {
        $shopId = $row['shop_id'];

        // Display shop details with link to view details
        echo '<div class="card">';
        echo '<div class="shop-details">';
        echo '<h3 style="font-size: 22px; font-weight: normal;">' . $row['shopname'] . '</h3>';
        echo '<div class="view-details-box">';
        echo '<a href="shop_details.php?shop_id=' . $shopId . '">View Details</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No shop requests found.";
}

// ...

// ...

// ...

// ...


// ...

// ...


// Close the database connection
$conn->close();
?>
