<?php
// Start a session
session_start();

// Retrieve the submitted form data
$owneremail = $_POST['owneremail'];
$ownerPassword = $_POST['ownerpassword'];

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

// Retrieve the hashed password from the database for the given email
$sql = "SELECT * FROM ownerform1 WHERE owneremail = '$owneremail'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error retrieving password: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
$hashedPassword = $row['ownerpassword'];

// Hash the user-entered password using md5
$inputPasswordHashed = ($ownerPassword);

// Validate the password
if ($hashedPassword === $inputPasswordHashed) {
    // Passwords match
    // Set session variables
    $_SESSION['loggedin'] = true;
    $_SESSION['owneremail'] = $owneremail;
    $_SESSION['shopname'] = $row['shopname'];

    

    // Perform further actions or redirect to the vendor's dashboard
    echo '<script type="text/javascript">
            window.onload = function () { alert("LOGIN SUCCESSFULL"); }
          </script>';
   header("refresh:0.25; url=vendordashboard.php");
} else {
    // Passwords don't match
    // Display an error message or redirect back to the login page
    echo '<script type="text/javascript">
            window.onload = function () { alert("Invalid Credentials"); }
          </script>';
    header("refresh:0.25; url=vendorlogin.php");
}

// Close the database connection
mysqli_close($conn);
?>
