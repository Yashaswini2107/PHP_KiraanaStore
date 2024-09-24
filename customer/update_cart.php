<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: login.html");
    exit;
}

// Connect to your MySQL database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'grocery';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    echo 'Not Connected to Server';
    exit;
}

// Retrieve the user's ID from the session or any other identifier that uniquely identifies the user
$email = $_SESSION['email']; // Assuming you have a userID stored in the session

// Get the updated quantity from the AJAX request
$productName = $_POST['productName'];
$newQuantity = $_POST['newQuantity'];

// Update the quantity in the database
$sql = "UPDATE cart SET quantity = '$newQuantity' WHERE email = '$email' AND productName = '$productName'";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo 'Quantity updated successfully';
} else {
    echo 'Failed to update quantity';
}

// Close the database connection
mysqli_close($conn);
?>
