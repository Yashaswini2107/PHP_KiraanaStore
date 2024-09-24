<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: vendorlogin.html");
    exit;
}

// Retrieve the logged-in user's email from the session
$owneremail = $_SESSION['owneremail'];

// Connect to your MySQL database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'grocery';

$conn = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


// Retrieve the existing shop details from the database
$sql = "SELECT * FROM ownerform1 WHERE owneremail = '$owneremail'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error retrieving shop details: " . mysqli_error($conn));
}

// Fetch the shop details
$row = mysqli_fetch_assoc($result);
$shopname = $row['shopname'];
$address = $row['address'];
$pincode = $row['pincode'];
$ownerphone = $row['ownerphone'];
$contactnumber = $row['contactnumber'];

// Update the profile details in the database
$sql = "UPDATE ownerform1 SET shopname = '$shopName', address = '$address', pincode = '$pincode', contactnumber = '$contactNumber', ownerphone = '$ownerPhone', owneremail = '$ownerEmail', openinghours = '$openingHours', closinghours = '$closingHours' WHERE owneremail = '$owneremail'";

if (mysqli_query($conn, $sql)) {
    // Profile details updated successfully
    // You can redirect the user to a success page or perform any other actions
    header("Location: profile_updated.php");
    exit;
} else {
    // Error updating profile details
    die("Error updating profile: " . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);

?>
