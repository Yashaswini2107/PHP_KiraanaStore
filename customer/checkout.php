<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
         
  body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      font-weight: bold;
      background-position-y:right;
      background-image: url('images/co.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size:cover;
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

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
        }

        .left-section {
            width: 50%;
            padding-right: 20px;
        }

        .right-section {
            width: 50%;
            padding-left: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        h2 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #555;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            color: #555;
        }

        button.checkout-btn {
            display: block;
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #3bad13;
            color: #fff;
            font-weight: bold;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button.checkout-btn:hover {
            background-color: #45a049;
        }
        hr.checkout-form{
  border-top: 1px dotted red;
}
    </style>
    <!-- Include the Razorpay JavaScript library -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
     <div class="navbar">
    <a class="logo" href="userdash.php">Kiraana Store</a>
    <div class="right-items">
      <a href="view_cart.php">My Cart</a>
     <a href="logout.php">Logout</a>
    </div>
</div>

    <div class="container">
        <div class="left-section">
            <h1>Checkout</h1>

            <?php
            $totalAmount = $_GET['totalAmount'];

            echo "<h2>Total Amount: ₹" . number_format($totalAmount, 2) . "</h2>";
            ?>

            <?php
            session_start();

            $email = $_SESSION['email'];

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

            $query = "SELECT * FROM register WHERE email = '$email'";
            $result = mysqli_query($conn, $query);
            if ($row = mysqli_fetch_assoc($result)) {
                $name = $row['username'];
                $email = $row['email'];
                $mobileNumber = $row['mobileNumber'];
                $houseNumber = $row['housenumber'];
                $buildingName = $row['buildingname'];
                $crossroad = $row['crossroad'];
                $street = $row['street'];
                $landmark = $row['landmark'];
                $pincode = $row['pincode'];
            }
            ?>

                 <form id="checkout-form" method="post" action="store_order.php">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="username" name="username" value="<?php echo $name; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>



                <!-- Add a hidden field to store the payment ID -->
                <input type="hidden" id="paymentId" name="paymentId" value="">
         


                <div class="form-group">
                    <label for="mobileNumber">Mobile Number:</label>
                    <input type="text" id="mobileNumber" name="mobileNumber" value="<?php echo $mobileNumber; ?>" required>
                </div>

                <div class="form-group">
                    <label for="house_number">House Number:</label>
                    <input type="text" id="housenumber" name="housenumber" value="<?php echo $houseNumber; ?>" required>
                </div>

                <div class="form-group">
                    <label for="building_name">Building Name:</label>
                    <input type="text" id="buildingname" name="buildingname" value="<?php echo $buildingName; ?>" required>
                </div>

            
        </div>

        <div class="right-section">
            <div class="form-group">
                <label for="crossroad">Crossroad:</label>
                <input type="text" id="crossroad" name="crossroad" value="<?php echo $crossroad; ?>" required>
            </div>

            <div class="form-group">
                <label for="street">Street:</label>
                <input type="text" id="street" name="street" value="<?php echo $street; ?>" required>
            </div>

            <div class="form-group">
                <label for="landmark">Landmark:</label>
                <input type="text" id="landmark" name="landmark" value="<?php echo $landmark; ?>" required>
            </div>

            <div class="form-group">
                <label for="pincode">Pincode:</label>
                <input type="text" id="pincode" name="pincode" value="<?php echo $pincode; ?>" required>
            </div>

            <input type="hidden" name="shopname" value="<?php echo $_SESSION['shopname']; ?>">


            <button type="button" class="checkout-btn" onclick="initiateRazorpayPayment()">Place Order</button>
        </div>
    </div>

</form>

<?php
//session_start();

require_once 'stock_functions.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: login.html");
    exit;
}

// Check if the total amount is provided
if (!isset($_GET['totalAmount'])) {
    // Total amount is not provided, redirect to the cart page
    header("Location: view_cart.php");
    exit;
}

$totalAmount = $_GET['totalAmount'];

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
$shopname = $_SESSION['shopname'];

// Fetch products from the cart table for the current user
$sql = "SELECT productName, productPrice, quantity, productImage, productID FROM cart WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    // Insert the order details into the orders table
    $orderDate = date("Y-m-d"); // Get the current date

    $insertOrderSql = "INSERT INTO orders (email, orderDate, total_amount, shopname) VALUES ('$email', '$orderDate', '$totalAmount', '$shopname')";

    $insertOrderResult = mysqli_query($conn, $insertOrderSql);

    if ($insertOrderResult) {
        $orderId = mysqli_insert_id($conn); // Get the ID of the inserted order

        // Store the orderId in the session
        $_SESSION['orderId'] = $orderId;

        while ($row = mysqli_fetch_assoc($result)) {
            $productName = $row['productName'];
            $productPrice = $row['productPrice'];
            $quantity = $row['quantity'];
            $product_id = $row['productID'];

            // Insert the product details into the order_items table
            $insertOrderItemSql = "INSERT INTO order_items (orderId, productID, productName, productPrice, quantity, shopname) VALUES ('$orderId', '$product_id', '$productName', '$productPrice', '$quantity', '$shopname')";

            mysqli_query($conn, $insertOrderItemSql);

            // Reduce the stock quantity for each product in the order
            $reduceStockSuccess = reduceStockOnSale($product_id, $quantity);

            if (!$reduceStockSuccess) {
                // Handle the case where stock reduction fails
                echo "Failed to reduce stock for product: $productName";
                // You may want to consider rolling back the order and displaying an error message to the customer
            }
        }

        // Clear the cart for the current user
        $clearCartSql = "DELETE FROM cart WHERE email = '$email'";
        mysqli_query($conn, $clearCartSql);

        // Redirect to a success page or display a success message
        // header("Location: order_success.php");
        exit;
    } else {
        // Error occurred while inserting the order details
        echo "Failed to place the order. Please try again.";
    }
} else {
    echo "Your cart is empty.";
}

// Close the database connection
mysqli_close($conn);
?>


    <!-- Include any necessary JavaScript files or libraries -->
    <script>
        // Function to initiate Razorpay payment
        function initiateRazorpayPayment() {
    // Retrieve the total amount from the PHP variable
    var totalAmount = <?php echo $totalAmount; ?>;

    // Create a new instance of Razorpay
    var razorpay = new Razorpay({
        key: 'rzp_test_z0HaQ2uDKhd6EO', // Replace with your Razorpay API key
        amount: totalAmount * 100, // Amount in paise (multiply by 100 as Razorpay expects the amount in the smallest currency unit)
        currency: 'INR', // Replace with your preferred currency
        name: 'Kiraana Store',
        description: 'Payment for Order',
        image: 'https://example.com/logo.png', // Replace with your store logo URL
        handler: function (response) {
            // Payment successful, get the payment ID
            var paymentId = response.razorpay_payment_id;

            // Add the payment ID to the form data
            document.getElementById('paymentId').value = paymentId;

            // Submit the form
            document.getElementById('checkout-form').submit();
        },
        prefill: {
            name: document.getElementById('username').value,
            email: document.getElementById('email').value,
            mobile: document.getElementById('mobileNumber').value,
        },
        notes: {
            house_number: document.getElementById('housenumber').value,
            building_name: document.getElementById('buildingname').value,
            crossroad: document.getElementById('crossroad').value,
            street: document.getElementById('street').value,
            landmark: document.getElementById('landmark').value,
            pincode: document.getElementById('pincode').value,
        },
        theme: {
            color: '#ef4b0e' // Replace with your preferred color theme
        }
    });
      razorpay.on('payment.success', function (response) {
            var paymentId = response.razorpay_payment_id;
            document.getElementById('paymentId').value = paymentId;
            document.getElementById('checkout-form').submit();
        });

    // Open the Razorpay payment dialog
    razorpay.open();
}

    </script>
</body>
</html>