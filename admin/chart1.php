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

// Query to get the sales amount from each shop
$sqlShopSales = "SELECT shopname, SUM(total_amount) AS sales_amount FROM orders GROUP BY shopname";
$resultShopSales = mysqli_query($conn, $sqlShopSales);

// Initialize arrays to store shop names and sales amounts
$shopNames = array();
$salesAmounts = array();

if ($resultShopSales) {
    while ($rowShopSales = mysqli_fetch_assoc($resultShopSales)) {
        $shopNames[] = $rowShopSales['shopname'];
        $salesAmounts[] = (float) $rowShopSales['sales_amount'];
    }
} else {
    // Error handling, if the query fails
    $shopNames = array();
    $salesAmounts = array();
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shop Sales Comparison - Admin Panel</title>
    <!-- Load the Google Visualization API -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Shop Name');
            data.addColumn('number', 'Sales Amount');

            // Add the shop names and sales amounts to the DataTable
            data.addRows([
                <?php
                for ($i = 0; $i < count($shopNames); $i++) {
                    echo "['" . $shopNames[$i] . "', " . $salesAmounts[$i] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Shop Sales Comparison',
                width: 800,
                height: 400,
                legend: { position: 'top' },
                bar: { groupWidth: '75%' },
                hAxis: { title: 'Shop Name' },
                vAxis: { title: 'Sales Amount' }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('shop_sales_chart'));
            chart.draw(data, options);
        }
    </script>
</head>
<body>
    

    <h2>Shop Sales Comparison</h2>
    <div id="shop_sales_chart"></div>
</body>
</html>
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

// Query to get the sales amount for each product
$sqlProductSales = "SELECT productName, SUM(quantity * productPrice) AS sales_amount FROM order_items GROUP BY productName";
$resultProductSales = mysqli_query($conn, $sqlProductSales);

// Initialize arrays to store product names and sales amounts
$productNames = array();
$salesAmounts = array();

if ($resultProductSales) {
    while ($rowProductSales = mysqli_fetch_assoc($resultProductSales)) {
        $productNames[] = $rowProductSales['productName'];
        $salesAmounts[] = (float) $rowProductSales['sales_amount'];
    }
} else {
    // Error handling, if the query fails
    $productNames = array();
    $salesAmounts = array();
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Sales Comparison - Admin Panel</title>
    <!-- Load the Google Visualization API -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Product Name');
            data.addColumn('number', 'Sales Amount');

            // Add the product names and sales amounts to the DataTable
            data.addRows([
                <?php
                for ($i = 0; $i < count($productNames); $i++) {
                    echo "['" . $productNames[$i] . "', " . $salesAmounts[$i] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Product Sales Comparison',
                width: 800,
                height: 400,
                legend: { position: 'top' },
                bar: { groupWidth: '75%' },
                hAxis: { title: 'Product Name' },
                vAxis: { title: 'Sales Amount' }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('product_sales_chart'));
            chart.draw(data, options);
        }
    </script>
</head>
<body>
    
    <h2>Product Sales Comparison</h2>
    <div id="product_sales_chart"></div>
</body>
</html>
