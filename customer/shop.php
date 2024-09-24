
<!DOCTYPE html>
<html>
<head>
  <style>
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
  background-color: #1e1e1e;
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
    /* CSS styles for the product cards */
    .product-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }
    
    .product-card {
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-bottom: 20px;
      padding: 10px;
      width: 300px;
      height: 400px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: center; /* Center align the contents */
      text-align: center; /* Center align the text */
    }
    
    .product-card img {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 5px;
      margin-bottom: 10px;
    }
    
    .product-name {
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 5px;
    }
    
    .product-price {
      font-size: 22px;
      margin-bottom: 5px;
      color: #888;
    }
    
    .product-quantity {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
    }
    
    .product-quantity input[type="number"] {
      width: 70px;
      margin: 0 5px;
    }
    
    .product-quantity button {
      background-color: #f2f2f2;
      border: none;
      cursor: pointer;
      padding: 5px;
    }
    
    .product-quantity button:hover {
      background-color: #e0e0e0;
    }
    
    .product-quantity button:active {
      background-color: #d2d2d2;
    }
    
    .product-actions {
      margin-bottom: 10px;
    }
    
    .product-add-to-cart {
      margin-bottom: 10px;
    }
    
    .product-add-to-cart button {
      padding: 10px 60px;
      background-color: #f6782c;
      border: none;
      color: #fff;
      cursor: pointer;
      font-size: 16px;
      border-radius: 5px;
      transition: background-color 0.3s ease;
      width: 100%; /* Adjust the width as per your preference */
    }
    
    .product-add-to-cart button:hover {
      background-color: #45a049;
    }
    
    .product-add-to-cart button:active {
      background-color: #3f9142;
    }
  </style>
  <script>
    // JavaScript function to handle increment and decrement buttons
    function updateQuantity(productId, operation) {
      var quantityInput = document.getElementById('quantity_' + productId);
      var quantity = parseInt(quantityInput.value);
      
      if (operation === 'increment') {
        quantity += 1;
      } else if (operation === 'decrement') {
        if (quantity > 1) {
          quantity -= 1;
        }
      }
      
      quantityInput.value = quantity;
    }
  </script>
</head>
<body>
    <div class="navbar">
    <a class="logo" href="userdash.php">Kiraana Store</a>
 <div class="right-items">
      
      <a href="view_cart.php">Cart</a>
     <a href="logout.php">Logout</a>
    </div>
  </div>
</div>

  <div class="product-container">
    <?php
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        // User is not logged in, redirect to login page
        header("Location: login.html");
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

    // Retrieve the shop name from the query parameters
    $shopName = $_GET['shopName'];

    // Retrieve products based on the shop name
    $query = "SELECT * FROM products WHERE shopname = '$shopName'";
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <div class="product-card">
        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['productImage']); ?>" alt="productImage">
        <div class="product-name"><?php echo $row['productName']; ?></div>
        <div class="product-description"><?php echo $row['productDescription'];?></div>
        <div class="product-price"><?php echo $row['productPrice']; ?></div>
        <div class="product-quantity">
          <button onclick="updateQuantity(<?php echo $row['productID']; ?>, 'decrement')">-</button>
          <input id="quantity_<?php echo $row['productID']; ?>" type="number" value="1" min="1" readonly>
          <button onclick="updateQuantity(<?php echo $row['productID']; ?>, 'increment')">+</button>
        </div>
        <div class="product-actions">
          <div class="product-add-to-cart">
            <form action="cart.php" method="POST">
              <input type="hidden" name="productID" value="<?php echo $row['productID']; ?>">
              <input type="hidden" name="quantity" value="1" id="cart_quantity_<?php echo $row['productID']; ?>">
              <button type="submit" name="addToCart">Add to Cart</button>
            </form>
          </div>
        </div>
      </div>
    <?php
    }
    mysqli_close($connection);
    ?>
  </div>
  
  <script>
    // JavaScript function to update the cart quantity input before submitting the form
    var addToCartForms = document.querySelectorAll('form[action="cart.php"]');
    addToCartForms.forEach(function(form) {
      form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting
        
        var productId = this.querySelector('input[name="productID"]').value;
        var quantityInput = document.getElementById('quantity_' + productId);
        var cartQuantityInput = document.getElementById('cart_quantity_' + productId);
        cartQuantityInput.value = quantityInput.value;
        
        this.submit(); // Manually submit the form
      });
    });
  </script>
</body>
</html>
