<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
   <style>
   body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      font-weight: bold;
      background-position-y:right;
      background-image: url('images/cart1.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size:cover;
    }
 h1, table {
    margin: 0;
    padding: 0;
}


.card {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    background-color: #fff;
}

h1 {
    font-size: 24px;
    margin-bottom: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    padding: 12px 8px;
    text-align: left;
    border-bottom: 1px solid #ccc;
}

th {
    background-color: #f2f2f2;
    font-weight: bold;
}

tr:last-child td {
    border-bottom: none;
}

input[type="number"] {
    width: 50px;
    text-align: center;
    padding: 6px;
}

button {
    padding: 8px 12px;
    border: none;
    background-color: #ddd;
    color: #333;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #bbb;
}

.decrement-btn,
.increment-btn {
    font-weight: bold;
}

.remove-btn {
    color: red;
}

.checkout-btn {
    display: block;
    margin-top: 20px;
    padding: 10px 20px;
    border: none;
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

.checkout-btn:hover {
    background-color: #45a049;
}

.buy-now-btn {
    margin-top: 20px;
    padding: 10px 20px;
    border: none;
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

.buy-now-btn:hover {
    background-color: #45a049;
}

.navbar {
      background-color: #ff4500;
      overflow: hidden;
    }
    .navbar a {
      float: left;
      display: block;
      color: #fff;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 20px;
    }
    .navbar a:hover {
      background-color: #800000;
    }
    .navbar .logo {
      float: left;
      font-weight: bold;
      font-size: 32px;
      margin-right: 20px;
      padding: 14px 16px;
      color: #fff;
      text-decoration: none;
    }
    .navbar .right-items {
      float: right;
    }

</style>
</head>
<body>
    <div class="navbar">

    <a class="logo" href="userdash.php">Kiraana Store</a>
    <div class="right-items">
     
      <a href="about.html">About us</a>
      <a href="contact.html">Contact</a>
      <a href="view_cart.php">My Cart</a>
      <a href="logout.php">Logout</a>
     
    </div>
</div>
     <div class="card">
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

// Fetch products from the cart table for the current user
$sql = "SELECT productName, productPrice, quantity, productImage FROM cart WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h1>Shopping Cart</h1>";
    echo "<table>";
    echo "<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th></tr>";

    $totalAmount = 0; // Initialize the total amount

    while ($row = mysqli_fetch_assoc($result)) {
        $productName = $row['productName'];
        $productPrice = $row['productPrice'];
        $quantity = $row['quantity'];
        $subTotal = $productPrice * $quantity;
        $totalAmount += $subTotal; // Add the subtotal to the total amount

        echo "<tr>";
        echo "<td>";
       if (isset($row['productImage'])) {
        $imageData = $row['productImage'];
        $base64Image = base64_encode($imageData);
        $imageSrc = "data:image/jpeg;base64,{$base64Image}";
        echo "<img src='{$imageSrc}' alt='{$row['productName']}' height='100' width='100'>";
    } else {
        echo "<img src='path_to_default_image' alt='{$row['productName']}' height='100'>";
    }
        echo "<p>{$row['productName']}</p>";
        echo "</td>";
        echo "<td>$productPrice</td>";
        echo "<td>";
        echo "<button class='decrement-btn' onclick='decrementQuantity(\"$productName\")'>-</button>";
        echo "<input type='number' name='quantity[]' value='$quantity' min='1' data-product='$productName' onchange='updateQuantity(this)' readonly >";
        echo "<button class='increment-btn' onclick='incrementQuantity(\"$productName\")'>+</button>";
        echo "</td>";
        echo "<td>$subTotal</td>";
        echo "<td><button class='remove-btn' data-product='$productName'>Remove</button></td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<h2>Total Amount: ₹" . number_format($totalAmount, 2) . "</h2>"; // Display the total amount
    $_SESSION['totalAmount'] = $totalAmount;

    

    echo "<form action='checkout.php' method='GET'>";
    echo "<input type='hidden' name='totalAmount' value='" . urlencode($totalAmount) . "'>";
    echo "<button type='submit' class='checkout-btn'>Checkout</button>";
    echo "</form>";


} else {
    echo "Your cart is empty.";
}

// Close the database connection
mysqli_close($conn);

?>

<!-- Include the jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Add the following JavaScript code -->
<script>
$(document).ready(function() {
    function updateQuantity(input) {
        var productName = $(input).data('product');
        var newQuantity = $(input).val();

        $.ajax({
            url: 'update_cart.php',
            method: 'POST',
            data: {
                productName: productName,
                newQuantity: newQuantity
            },
            success: function(response) {
                location.reload(); // Reload the page to update the cart
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function incrementQuantity(productName) {
        var input = $('input[data-product="' + productName + '"]');
        var quantity = parseInt(input.val());
        input.val(quantity + 1);
        updateQuantity(input);
    }

    function decrementQuantity(productName) {
        var input = $('input[data-product="' + productName + '"]');
        var quantity = parseInt(input.val());
        if (quantity > 1) {
            input.val(quantity - 1);
            updateQuantity(input);
        }
    }


    function buyNow() {
        window.location.href = 'checkout.php';
    }

    function removeProduct(productName) {
        $.ajax({
            url: 'remove_product.php',
            method: 'POST',
            data: {
                productName: productName
            },
            success: function(response) {
                location.reload(); // Reload the page to update the cart
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    // Attach event listener to quantity inputs
    $('input[name="quantity[]"]').change(function() {
        updateQuantity(this);
    });

    // Attach event listener to increment buttons
    $('.increment-btn').click(function() {
        var productName = $(this).closest('td').find('input').data('product');
        incrementQuantity(productName);
    });

    // Attach event listener to decrement buttons
    $('.decrement-btn').click(function() {
        var productName = $(this).closest('td').find('input').data('product');
        decrementQuantity(productName);
    });

    // Attach event listener to remove buttons
    $('.remove-btn').click(function() {
        var productName = $(this).data('product');
        removeProduct(productName);
    });


    // Attach event listener to "Buy Now" button
    $('.buy-now-btn').click(function() {
        buyNow();
    });
});
</script>