<?php
$connection = mysqli_connect("localhost", "root", "", "grocery");

if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the form data
  $productId = $_POST['productId'];
  $productName = $_POST['productName'];
  $productCategory = $_POST['productCategory'];
  $productPrice = $_POST['productPrice'];
  $productDescription = $_POST['productDescription'];

  // Update the product information in the database
  $query = "UPDATE products SET 
            productName = '$productName',
            productCategory = '$productCategory',
            productPrice = '$productPrice',
            productDescription = '$productDescription'
            WHERE productID = '$productId'";

 if (mysqli_query($connection, $query)) {
    // Product information updated successfully
    echo "<script>alert('Product updated successfully.');</script>";
    header("Location: vendordashboard.php");
    exit(); // Terminate the script after redirecting
  } else {
    // Error occurred while updating the product information
    echo "<script>alert('Error updating product: " . mysqli_error($connection) . "');</script>";
  }
}

mysqli_close($connection);
?>
