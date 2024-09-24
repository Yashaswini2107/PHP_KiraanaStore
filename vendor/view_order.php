<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: vendorlogin.html");
    exit;
}

// Retrieve the vendor's shop name from the session
$vendorShopName = $_SESSION['shopname'];

// Connect to the database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'grocery';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die('Not Connected to Server');
}

// Check if the "Delivered" button is clicked
if (isset($_POST['delivered'])) {
    $orderId = $_POST['order_id'];

    // Update the status of the order to "Delivered" in the database
    $updateQuery = "UPDATE orders SET status = 'Delivered' WHERE order_id = ?";
    $updateStatement = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateStatement, 'i', $orderId);
    mysqli_stmt_execute($updateStatement);
}

// Fetch the orders, order items, and payment details from the vendor's shop
$query = "SELECT orders.*, order_items.*, payment.*
          FROM orders
          INNER JOIN order_items ON orders.order_id = order_items.orderId
          INNER JOIN payment ON orders.order_id = payment.order_id
          WHERE orders.shopname = ? AND orders.status != 'Delivered'";

$statement = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($statement, 's', $vendorShopName);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders - Vendor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .delivered-button {
            background-color: green;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 4px;
        }

        .delivered-button:hover {
            background-color: #0a8e16;
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
      font-weight: bold;
    }
    .navbar a:hover {
      background-color:#1e1e1e;
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
    </style>
    </style>
</head>
<body>
     <div class="navbar">
    
    <a class="logo" href="vendordashboard.php"> <?php echo $vendorShopName; ?></a>
  
    
  </div>
  
    <h1>Orders </h1>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Order Date</th>
               
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Quantity</th>
                <!-- Add other relevant order details column headers -->
            </tr>
            <tr>
                <td><?php echo $row['orderId']; ?></td>
                <td>₹<?php echo number_format($row['total_amount'], 2); ?></td>
                <td><?php echo $row['orderDate']; ?></td>
                 <td><?php echo $row['productName']; ?></td>
                <td>₹<?php echo $row['productPrice']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <!-- Add other relevant order details here -->
            </tr>
            <tr>
                
                <!-- Add other relevant order item column headers -->
            </tr>
            <tr>
                <td></td>
               
                <!-- Add other relevant order item details here -->
            </tr>
            <!-- Add the "Delivered" button -->
            <tr>
                <td colspan="4" style="text-align: center;">
                    <form method="post">
                        <input type="hidden" name="order_id" value="<?php echo $row['orderId']; ?>">
                        <button class="delivered-button" type="submit" name="delivered">Delivered</button>
                    </form>
                </td>
            </tr>
        </table>
        <hr>
    <?php } ?>
</body>
</html>

