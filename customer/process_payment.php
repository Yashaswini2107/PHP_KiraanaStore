<?php
// process_payment.php

// Retrieve the payment ID from the form submission
$paymentId = $_POST['paymentId'];

// Retrieve the necessary form data
$name = $_POST['username'];
$email = $_POST['email'];
$mobileNumber = $_POST['mobileNumber'];
$houseNumber = $_POST['housenumber'];
$buildingName = $_POST['buildingname'];
$crossroad = $_POST['crossroad'];
$street = $_POST['street'];
$landmark = $_POST['landmark'];
$pincode = $_POST['pincode'];

// Store the payment details in the database
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

// Prepare the query to insert payment details into the database
$query = "INSERT INTO payment (payment_id, name, email, mobile_number, house_number, building_name, crossroad, street, landmark, pincode) 
          VALUES ('$paymentId', '$name', '$email', '$mobileNumber', '$houseNumber', '$buildingName', '$crossroad', '$street', '$landmark', '$pincode')";

// Execute the query
if (mysqli_query($conn, $query)) {
    echo "Payment details stored successfully.";

    // Retrieve the products from the cart
    session_start();
    $cartProducts = $_SESSION['cart'];

    // Calculate the total amount paid by the user
    $totalAmount = 0;

    // Insert the cart products into the database
    foreach ($cartProducts as $product) {
        $productName = $product['productName'];
        $productPrice = $product['productPrice'];
        $quantity = $product['quantity'];
        $email = $product['email'];

        $productQuery = "INSERT INTO orders (payment_id, product_name, product_price, quantity, email) 
                         VALUES ('$paymentId', '$productName', '$productPrice', '$quantity', '$email')";

        mysqli_query($conn, $productQuery);

        // Calculate the total amount
        $totalAmount += ($productPrice * $quantity);
    }

    // Store the total amount in the payment table
    $updateTotalAmountQuery = "UPDATE payment SET total_amount = $totalAmount WHERE payment_id = '$paymentId'";
    mysqli_query($conn, $updateTotalAmountQuery);

    // Clear the cart after successful payment
    unset($_SESSION['cart']);
} else {
    echo "Error storing payment details: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
