<style>
.card-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.card {
    width: 300px;
    background-color: #f5f5f5;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-image {
    width: 100%;
    height: auto;
    margin-bottom: 10px;
    border-radius: 4px;
}

.card-details {
    text-align: center;
}

.card-title {
    font-size: 20px;
    margin-bottom: 5px;
}

.card-price {
    font-weight: bold;
    margin-bottom: 5px;
}

.card-description {
    margin-bottom: 10px;
}
</style>
<?php
// Establish a database connection (assuming MySQL here)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'grocery';

$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the search query from the GET parameter
$search = $_GET['search'];

// Perform a database query using the search query
$sql = "SELECT * FROM products WHERE productName LIKE '%$search%'";
$result = $conn->query($sql);

// Display the search results
if ($result->num_rows > 0) {
    echo "<div class='card-container'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card'>";
        echo "<img src='imageview.php?productID=" . $row['productID'] . "' alt='Product Image' class='card-image'>";
        echo "<div class='card-details'>";
        echo "<h3 class='card-title'>" . $row["productName"] . "</h3>";
        echo "<p class='card-price'>Price: " . $row["productPrice"] . "</p>";
        echo "<p class='card-description'>" . $row["productDescription"] . "</p>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "No products found.";
}

// Close the database connection
$conn->close();
?>
