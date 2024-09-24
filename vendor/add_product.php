<?php

session_start();

//require_once 'stock_functions.php';

// Function to reduce stock quantity when a sale is made
function reduceStockOnSale($product_id, $quantity)
{
    global $conn;

    // Retrieve the current stock quantity of the product
    $sql = "SELECT stock_quantity FROM products WHERE product_id = '$product_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_stock = $row['stock_quantity'];

        // Check if there's enough stock to fulfill the sale
        if ($current_stock >= $quantity) {
            // Calculate the new stock quantity after the sale
            $new_stock = $current_stock - $quantity;

            // Update the stock quantity in the database
            $sql = "UPDATE products SET stock_quantity = '$new_stock' WHERE product_id = '$product_id'";
            if (mysqli_query($conn, $sql)) {
                return true; // Stock reduced successfully
            } else {
                // Handle the case where the stock reduction fails (e.g., display an error message to the user)
                return false;
            }
        } else {
            // Not enough stock, handle the error (e.g., display a message)
            return false;
        }
    } else {
        // Product not found, handle the error (e.g., display a message)
        return false;
    }
}

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: vendorlogin.html");
    exit;
}

$owneremail = $_SESSION['owneremail'];

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

if (!mysqli_select_db($conn, 'grocery')) {
    echo 'Database not selected';
    exit;
}

// Fetch shopname from ownerform1 table
$shopnameQuery = "SELECT shopname FROM ownerform1 WHERE owneremail = '$owneremail'";
$result = mysqli_query($conn, $shopnameQuery);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $shopname = $row['shopname'];
} else {
    // Handle the case when shopname is not found for the owneremail
    // You can display an error message or take appropriate action
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productDescription = $_POST['productDescription'];
    $productCategory = $_POST['productCategory'];
    $subproductCategory = $_POST['subproductCategory'];
    $imagePath = $_FILES['productImage']['tmp_name'];

    // Convert image to BLOB
    $productImage = addslashes(file_get_contents($imagePath));

    // Retrieve stock quantity from the form
    $stockQuantity = $_POST['stock_quantity'];

    // Prepare the SQL statement
    $sql = "INSERT INTO products (shopname, productName, productPrice, productDescription, productCategory, subproductCategory, productImage, stock_quantity)
            VALUES ('$shopname', '$productName', '$productPrice', '$productDescription', '$productCategory', '$subproductCategory', '$productImage', '$stockQuantity')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo '<script type="text/javascript">
                window.onload = function () { alert("Product Added Successfully"); }
              </script>';
        header("refresh:0.25; url=vendordashboard.php");
    } else {
        echo "Failed to insert the product: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>