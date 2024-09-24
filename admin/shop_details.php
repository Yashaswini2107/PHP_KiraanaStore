<style>
  .container {
  max-width: 500px;
  margin: 20px auto;
  padding: 20px;
  background-color: #f2f2f2;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

h2 {
  color: #333;
  margin-bottom: 10px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 10px;
}

td {
  padding: 8px;
  border: 1px solid #ccc;
}

.btn-container {
  text-align: left;
  margin-top: 20px;
}

.btn-container button {
  background-color: #4CAF50;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  margin-right: 10px;
}

.btn-container button:last-child {
  background-color: #f44336;
}

.btn-container button:hover {
  background-color: #45a049;
}

.btn-container button:last-child:hover {
  background-color: #d32f2f;
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

// Check if the shop ID is provided in the URL
if (isset($_GET['shop_id'])) {
    $shopId = $_GET['shop_id'];

    // Query to retrieve the shop details
    $sql = "SELECT * FROM ownerform1 WHERE shop_id = $shopId";
    $result = $conn->query($sql);

    // Display the shop details
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo '<h2>Shop Details</h2>';

        // Display shop details
         echo '<table style="width: 50%; border: 5px solid black; border-collapse: collapse; margin-bottom: 10px;">';
        echo '<tr><td>Shop Name:</td><td>' . $row['shopname'] . '</td></tr>';
        echo '<tr><td>Address:</td><td>' . $row['address'] . '</td></tr>';
        echo '<tr><td>Contact Number:</td><td>' . $row['contactnumber'] . '</td></tr>';
        echo '<tr><td>FSSAI License:</td><td>' . $row['FSSAIlicense'] . '</td></tr>';
        echo '<tr><td>GST Number:</td><td>' . $row['GSTNO'] . '</td></tr>';
        echo '<tr><td>Trade License:</td><td>' . $row['tradelicense'] . '</td></tr>';
        echo '<tr><td>Vendor Name:</td><td>' . $row['ownername'] . '</td></tr>';
        echo '<tr><td>Mobile Number:</td><td>' . $row['ownerphone'] . '</td></tr>';
        echo '<tr><td>Email:</td><td>' . $row['owneremail'] . '</td></tr>';
        echo '<tr><td>Grocery Type:</td><td>' . $row['grocerytype'] . '</td></tr>';
        echo '<tr><td>Opening Hours:</td><td>' . $row['openinghours'] . '</td></tr>';
        echo '<tr><td>Closing Hours:</td><td>' . $row['closinghours'] . '</td></tr>';
        echo '<tr><td>Opening Days:</td><td>' . $row['openingdays'] . '</td></tr>';
        echo '</table>';

        // Add accept/reject buttons
        echo '<form method="post" action="process_approval.php">';
        echo '<input type="hidden" name="shop_id" value="' . $shopId . '">';
         echo '<div class="btn-container">';
        echo '<button type="submit" name="approve">Accept</button>';
        echo '<button type="submit" name="reject">Reject</button>';
        echo '</div>';
} else {
  echo "Shop not found.";
}
} else {
    echo "Invalid shop ID.";
}

// Close the database connection
$conn->close();
?>
