<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: login.html");
    exit;
}

// Retrieve the form data
$username = $_POST['username'];
$email = $_POST['email'];
$mobileNumber = $_POST['mobileNumber'];
$houseNumber = $_POST['housenumber'];
$buildingName = $_POST['buildingname'];
$crossroad = $_POST['crossroad'];
$street = $_POST['street'];
$landmark = $_POST['landmark'];
$pincode = $_POST['pincode'];
$paymentId = $_POST['paymentId'];
$totalAmount = $_SESSION['totalAmount'];
$shopname = $_POST['shopname'];
$orderId = $_SESSION['orderId'];


// Connect to your MySQL database
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$database = 'grocery';

$conn = mysqli_connect($host, $dbUsername, $dbPassword, $database);

// Check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

//Insert the order details into the orders table
$orderDate = date("Y-m-d"); // Get the current date

$insertOrderSql = "INSERT INTO orders (email, orderDate, total_amount, shopname) VALUES ('$email', '$orderDate', '$totalAmount', '$shopname')";


// Insert the data into the database
$query = "INSERT INTO payment (name, email, mobile_number, house_number, building_name, crossroad, street, landmark, pincode, payment_id,total_amount,shopname,order_id) VALUES ('$username', '$email', '$mobileNumber', '$houseNumber', '$buildingName', '$crossroad', '$street', '$landmark', '$pincode', '$paymentId','$totalAmount','$shopname','$orderId')";
$result = mysqli_query($conn, $query);

if ($result) {
    // Data stored successfully
     echo '<script type="text/javascript">
        window.onload = function () { alert("Order Placed Successfully"); }
    </script>';
    header("refresh:0.25; url=userdash.php");
} else {
    // Error occurred while storing the data
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
