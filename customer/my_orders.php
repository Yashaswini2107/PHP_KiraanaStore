<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
    <style>
        <!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
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

    </style>
</head>
<body>
    <div class="navbar">
    <a class="logo" href="#">Kiraana Store</a>
     <div class="right-items">
      <a href="about.html">About us</a>
      <a href="contact.html">Contact</a>
      <a href="view_cart.php">Cart</a>
      <a href="my_orders.php">Orders</a>
     <a href="logout.php">Logout</a>
    </div>
</div>
    <h1>View Orders</h1>

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

    // Retrieve the user's email from the session
    $email = $_SESSION['email'];

    // Fetch orders for the current user from the orders and order_items tables
    $sql = "SELECT orders.orderDate, orders.total_amount, order_items.productName, order_items.productPrice, order_items.quantity
            FROM orders
            INNER JOIN order_items ON orders.order_id = order_items.orderId
            WHERE orders.email = '$email'
            ORDER BY orders.orderDate DESC"; // You can adjust the ORDER BY clause as needed

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <tr>
                <th>Order Date</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Quantity</th>
                <th>Total Amount</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                $orderDate = $row['orderDate'];
                $productName = $row['productName'];
                $productPrice = $row['productPrice'];
                $quantity = $row['quantity'];
                $totalAmount = $row['total_amount'];

                echo "<tr>";
                echo "<td>$orderDate</td>";
                echo "<td>$productName</td>";
                echo "<td>₹" . number_format($productPrice, 2) . "</td>";
                echo "<td>$quantity</td>";
                echo "<td>₹" . number_format($totalAmount, 2) . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <?php
    } else {
        echo "No orders found.";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>

    <!-- Add any other HTML/CSS content as needed -->
</body>
</html>
