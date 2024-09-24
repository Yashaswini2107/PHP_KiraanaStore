<?php
// Replace these variables with your actual database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "grocery";

// Establish a database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to get the count of users
$sqlUserCount = "SELECT COUNT(*) AS user_count FROM register";
$resultUserCount = mysqli_query($conn, $sqlUserCount);

if ($resultUserCount) {
    $rowUserCount = mysqli_fetch_assoc($resultUserCount);
    $userCount = $rowUserCount['user_count'];
} else {
    // Error handling, if the query fails
    $userCount = "Error: Unable to fetch user count";
}

// Query to get the count of vendors from the ownerform1 table
$sqlVendorCount = "SELECT COUNT(*) AS vendor_count FROM ownerform1";
$resultVendorCount = mysqli_query($conn, $sqlVendorCount);

if ($resultVendorCount) {
    $rowVendorCount = mysqli_fetch_assoc($resultVendorCount);
    $vendorCount = $rowVendorCount['vendor_count'];
} else {
    // Error handling, if the query fails
    $vendorCount = "Error: Unable to fetch vendor count";
}

// Query to get the total amount of all orders
$sqlTotalAmount = "SELECT SUM(total_amount) AS total_amount_sum FROM orders";
$resultTotalAmount = mysqli_query($conn, $sqlTotalAmount);

if ($resultTotalAmount) {
    $rowTotalAmount = mysqli_fetch_assoc($resultTotalAmount);
    $totalAmountSum = $rowTotalAmount['total_amount_sum'];
} else {
    // Error handling, if the query fails
    $totalAmountSum = "Error: Unable to fetch total amount";
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User, Vendor Count, and Total Order Amount - Admin Panel</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Admin Panel</h1>
    
    <h2>User and Vendor Counts</h2>
    <table>
        <tr>
            <th>Category</th>
            <th>Count</th>
        </tr>
        <tr>
            <td>Total number of users:</td>
            <td><?php echo $userCount; ?></td>
        </tr>
        <tr>
            <td>Total number of vendors:</td>
            <td><?php echo $vendorCount; ?></td>
        </tr>
    </table>

    <h2>Total Order Amount</h2>
    <table>
        <tr>
            <th>Total amount of all orders:</th>
            <td>₹<?php echo number_format($totalAmountSum, 2); ?></td>
        </tr>
    </table>
</body>
</html>
