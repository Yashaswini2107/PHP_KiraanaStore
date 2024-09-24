<?php

// Function to reduce stock quantity when a sale is made
function reduceStockOnSale($product_id, $quantity_sold)
{
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

    // Fetch the current stock quantity from the database for the product
    $query = "SELECT stock_quantity FROM products WHERE productID = '$product_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_stock_quantity = $row['stock_quantity'];

        // Calculate the updated stock quantity after the sale
        $updated_stock_quantity = $current_stock_quantity - $quantity_sold;

        // Update the stock quantity in the database
        $update_query = "UPDATE products SET stock_quantity = '$updated_stock_quantity' WHERE productID = '$product_id'";
        $update_result = mysqli_query($conn, $update_query);

        // Check if the update was successful
        if ($update_result) {
            // Stock update successful
            return true;
        } else {
            // Stock update failed
            return false;
        }
    } else {
        // Product not found in the database
        return false;
    }

    // Close the database connection
    mysqli_close($conn);
}

?>
