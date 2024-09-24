<style>
table {
  width: 100%;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
}

th, td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
  font-weight: bold;
}

/* Center the product image within its cell */
td div {
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Add some spacing around the product image */
td img {
  max-width: 190px;
  max-height: 250px;
  margin: 5px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
}

/* Add hover effect on table rows */
tr:hover {
  background-color: #f5f5f5;
  cursor: pointer;
}

/* Style the product name */
td:nth-child(2) {
  font-weight: bold;
  color: #333;
}

/* Style the product category */
td:nth-child(3) {
  text-transform: uppercase;
  color: #777;
}

/* Style the product price */
td:nth-child(4) {
  color: #27ae60;
  font-weight: bold;
}

/* Style the product description */
td:nth-child(5) {
  color: #555;
}
.edit-button {
    background-color: #ff4500;
    color: #fff;
    border: none;
    padding: 10px 25px;
    cursor: pointer;
  }

  .edit-button:hover {
    background-color: #e63c00;
  }

</style>

<table>
  <thead>
    <tr>
     
      <th>productImage</th>
      <th>productName</th>
  
      <th>productPrice</th>
      <th>productDescription</th>
      <th>Action</th>
    </tr>
  </thead>
  <?php
  session_start();

  // Check if the user is logged in
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: vendorlogin.html");
    exit;
  }

  // Connect to your MySQL database
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'grocery';

  $connection = mysqli_connect($host, $username, $password, $database);

  if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $shopname = $_SESSION['shopname']; // Assuming the shop name is stored in the session variable

  // Retrieve products based on the logged-in shop name
  $query = "SELECT * FROM products WHERE shopname = '$shopname'";
  $query_run = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_array($query_run)) {
    ?>
    <tr>
      <td>
        <div>
          <img height="100px" src="imageview.php?productID=<?php echo $row['productID']; ?>" alt="imagename" style="width:150px; height: 150px;">
        </div>
      </td>
      <td><?php echo $row['productName']; ?></td>
      <td><?php echo $row['productPrice']; ?></td>
      
      <td><?php echo $row['productDescription']; ?></td>

      <td>
        <!-- Edit button wrapped inside a form -->
      <!-- Edit button wrapped inside a form -->
<form action="edit_product.php" method="GET">
  <input type="hidden" name="productId" value="<?php echo $row['productID']; ?>">
  <button class="edit-button" type="submit">Edit</button>
</form>

      </td>
    </tr>

  <?php
  }
  mysqli_close($connection);
  ?>
</table>
