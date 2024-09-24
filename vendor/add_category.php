<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: vendorlogin.html");
    exit;
}

$conn = mysqli_connect('localhost', 'root', '', 'grocery');

if (!$conn) {
    echo 'Not Connected to Server';
}

if (!mysqli_select_db($conn, 'grocery')) {
    echo 'Database not selected';
}

$conn = mysqli_connect("localhost","root","","grocery");

// Retrieve form data
$categoryname = $_POST['categoryname'];
$subcategoryname = $_POST['subcategoryname']; // Assuming subcategories is an array of subcategory names

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grocery";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare the SQL statement
$sql = "INSERT INTO category (categoryname, subcategoryname) VALUES ('$categoryname', '" . implode(",", $subcategoryname) . "')";

// Execute the query to insert category with subcategory names as comma-separated string
if (mysqli_query($conn, $sql)) {
    echo '<script type="text/javascript">
            window.onload = function () { alert("Category Added Successfully"); }
          </script>';
    header("refresh:0.25; url=vendordashboard.php");
} else {
    echo "Failed to Add the Category: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
