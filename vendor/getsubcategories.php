<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grocery";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$categoryname = $_GET['categoryname'];

$sql = "SELECT subcategoryname FROM category WHERE categoryname = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $category);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$subcategories = array();
while ($row = mysqli_fetch_assoc($result)) {
    $subcategoriesString = $row['subcategoryname'];
    $subcategoriesArray = explode(',', $subcategoriesString);
    $subcategories = array_merge($subcategories, $subcategoriesArray);
}

mysqli_close($conn);

$options = '';
foreach ($subcategories as $subcategory) {
    $options .= '<option value="' . $subcategory . '">' . $subcategory . '</option>';
}

echo $options;
?>
