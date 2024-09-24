<?php

// Retrieve the cart from the session
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
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

// Retrieve selected product details from the database
$productID = $_POST['productID']; // Assuming you have a productID as an input from the form
$quantity = $_POST['quantity']; // Retrieve the quantity from the form

// Fetch the product details from the products table
$sql = "SELECT productName, productPrice, productImage FROM products WHERE productID = '$productID'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $productName = $row['productName'];
    $productPrice = $row['productPrice'];
    $productImage = mysqli_real_escape_string($conn, $row['productImage']);

    // Retrieve the user's email from the session
    $email = $_SESSION['email'];

    // Fetch the user's email from the register table
    $sql = "SELECT * FROM register WHERE email = '$email'";
    $userResult = mysqli_query($conn, $sql);

    if ($userResult && mysqli_num_rows($userResult) > 0) {
        $userRow = mysqli_fetch_assoc($userResult);
        $email = $userRow['email'];

        // Create an array to store the product details
        $productDetails = [
            'productName' => $productName,
            'productPrice' => $productPrice,
            'productImage' => $productImage,
            'quantity' => $quantity,
            'email' => $email
        ];

        // Add the product details to the cart session variable
        $_SESSION['cart'][] = $productDetails;

        // Insert product and user details into the cart table
        $sql = "INSERT INTO cart (productID,productName, productPrice, productImage, quantity, email) VALUES ('$productID','$productName', '$productPrice', '$productImage', '$quantity', '$email')";
        if (mysqli_query($conn, $sql)) {


            header("Location: view_cart.php?success=1");
        exit;


     
}
}
}
?>
