
  <style>
  form {
    width: 400px;
    margin: 0 auto;
  }

  label {
    display: block;
    margin-bottom: 10px;
  }

  input[type="text"],
  textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }

  button[type="submit"] {
    background-color: #ff4500;
    color: #fff;
  </style>

<?php
$connection = mysqli_connect("localhost", "root", "", "grocery");

if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the product ID is provided in the URL
if (isset($_GET['productId'])) {
  $productId = $_GET['productId'];

  // Retrieve the product details from the database
  $query = "SELECT * FROM products WHERE productID = '$productId'";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) > 0) {
    // Fetch the product details
    $row = mysqli_fetch_assoc($result);

    // Pre-fill the form fields with the existing information
    $productName = $row['productName'];
    $productCategory = $row['productCategory'];
    $productPrice = $row['productPrice'];
    $productDescription = $row['productDescription'];
  } else {
    // Handle the case if the product with the given ID is not found
    echo "Product not found.";
    exit;
  }
} else {
  // Handle the case if the product ID is not provided
  echo "Invalid product ID.";
  exit;
}

mysqli_close($connection);
?>

<!-- The HTML form with pre-filled values -->
<form action="update_product.php" method="POST">
  <input type="hidden" name="productId" value="<?php echo $productId; ?>">
  <label for="productName">Product Name:</label>
  <input type="text" id="productName" name="productName" value="<?php echo $productName; ?>" required>
  <label for="productCategory">Product Category:</label>
  <input type="text" id="productCategory" name="productCategory" value="<?php echo $productCategory; ?>" required>
  <label for="productPrice">Product Price:</label>
  <input type="text" id="productPrice" name="productPrice" value="<?php echo $productPrice; ?>" required>
  <label for="productDescription">Product Description:</label>
  <textarea id="productDescription" name="productDescription" required><?php echo $productDescription; ?></textarea>
  <button type="submit">Update Product</button>
</form>
