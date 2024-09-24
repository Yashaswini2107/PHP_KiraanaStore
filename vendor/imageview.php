<?php
$conn = new mysqli('localhost', 'root', '', 'grocery');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} else {
    if (isset($_GET['productID'])) {
        $id = $_GET['productID'];
        $sql = "SELECT productImage FROM products WHERE productID = '$id'";
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $imageData = $row['productImage'];
                
                // Set appropriate headers for image display
                header('Content-type: image/jpeg');
                header('Content-length: ' . strlen($imageData));
                
                // Output the image to the browser
                echo $imageData;
                exit; // Stop further execution
            } else {
                echo 'Image not found.';
            }
        } else {
            echo 'Query error: ' . mysqli_error($conn);
        }
    } else {
        echo 'Product ID not specified.';
    }
}

mysqli_close($conn);
?>
