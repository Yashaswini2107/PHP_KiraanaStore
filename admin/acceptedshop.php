<style>
table {
  width: 100%;
  margin-bottom: 20px;
}

table th,
table td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #000;
}

table th {
  background-color: #f2f2f2;
}

h2 {
  margin-top: 20px;
}

.card {
  background-color: #fff;
  border-radius: 10px;
  padding: 10px;
  margin-bottom: 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card h3,
.card h6 {
  margin-bottom: 10px;
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

// Query to retrieve accepted shops
$sql = "SELECT * FROM ownerform1 WHERE status = 'done'";
$result = $conn->query($sql);

// Display the accepted shops
if ($result->num_rows > 0) {
    echo "<h2>Accepted Shops</h2><br>";

    echo "<table>";
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>Shop Name</th>";
    echo "<th>Contact Number</th>";
    echo "<th>Owner Email</th>";
    echo "<th>Pincode</th>";
    echo "</tr>";

    $count = 1;

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $count . "</td>";
        echo "<td>" . $row['shopname'] . "</td>";
        echo "<td>" . $row['contactnumber'] . "</td>";
        echo "<td>" . $row['owneremail'] . "</td>";
        echo "<td>" . $row['pincode'] . "</td>";
        echo "</tr>";
        
        $count++;
    }

    echo "</table>";
} else {
    echo "No accepted shops found.";
}

// Close the database connection
$conn->close();
?>
