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

// Get the product name from the AJAX request
$productName = $_POST['productName'];

// Delete the product from the cart table for the current user
$sql = "DELETE FROM cart WHERE email = '$email' AND productName = '$productName'";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Product removed successfully.";
} else {
    echo "Failed to remove product.";
}

// Close the database connection
mysqli_close($conn);
?>
