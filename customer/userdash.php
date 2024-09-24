<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to login page
    header("Location: login.html");
    exit;
}

// Access the session variables
$email = $_SESSION['email'];
$password = $_SESSION['password'];

// Use the session variables as needed
echo "Welcome, $email!";

// You can also perform database queries using the session variables
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



// For example:
// $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
$query = "SELECT ownerform1.shopname FROM ownerform1 JOIN register ON ownerform1.pincode = register.pincode and register.email='$email'";
$result = mysqli_query($conn, $query);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    // Loop through the rows and display the shop information
    while ($row = mysqli_fetch_assoc($result)) {
        $shopName = $row['shopname'];
        // Display the shop name or perform any other desired actions
        echo $shopName;
    }
} else {
    echo "No matching shops found.";
}

// Remember to handle any necessary database connections and query executions
?>


<!DOCTYPE html>
<html>
<head>
  <title>Home - Online Grocery Shopping</title>
  <style>
     body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
       background-color: #e0f4f6;
      font-size: 18px;
      font-weight: bolder;
   
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
    .search-box {
      display: flex;
      align-items: left;
      max-width: 600px;
      margin: 0 auto;
    }
    .search-box input[type="text"] {
      flex-grow: 1;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }
    .search-box button {
      padding: 8px 12px;
      background-color: #2F4F4F;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      margin-left: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    .search-box button:hover {
      background-color: #800000;
    }
    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: flex-start;
      margin-top: 20px;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0s linear 0.3s;
    }
    .card-container.show {
      opacity: 1;
      visibility: visible;
      transition-delay: 0s;
    }
    .card {
      width: 200px;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      margin: 10px;
      text-align: center;
      background-color: transparent;
      flex: 0 0 auto;
       transition: transform 0.3s ease;
  }

   .card:hover {
    transform: scale(1.05);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  }

  .visit-shop-btn {
    padding: 8px 12px;
    background-color: #2F4F4F;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    margin-top: 10px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }

  .visit-shop-btn:hover {
    background-color: #800000;
  }
    
    .card img {
      width: 100%;
      height: 100%;
      border-radius: 80px;
    }
    .card-content {
      margin-top: 10px;
    }
    .card-content h3 {
      font-size: 18px;
      margin-bottom: 5px;
    }
    .card-content p {
      font-size: 14px;
      color: #888;
    }
     .background-overlay {
    background-color: rgba(0, 0, 0, 0.5); /* Adjust the opacity value as desired */
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: -1;
  }

  .card-content button {
    padding: 8px 12px;
    background-color: #2F4F4F;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    margin-top: 10px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }

  .card-content button:hover {
    background-color: #800000;
  }

  .card-content .shop-name {
    color: #000000;
    margin-bottom: 10px;
    font-size: 18px;
    font-weight: bold;
  }

  .card-content .shop-name {
    color: #d91717;
  }

  </style>
  
</head>
<body>
  <div class="navbar">
    <a class="logo" href="#">Kiraana Store</a>
    <div class="search-box">
      <form method="GET" action="search.php">
  <input type="text" name="search" placeholder="Search products...">
  <button type="submit">Search</button>
</form>
</div>
 <div class="right-items">
      <a href="about.html">About us</a>
      <a href="contact.html">Contact</a>
      <a href="view_cart.php">Cart</a>
      <a href="my_orders.php">Orders</a>
     <a href="logout.php">Logout</a>
    </div>
  </div>
</div>

  

 <!-- Display the category cards -->
<h3>  Shops Near You</h3><br>

<!-- Display the shop cards -->
<div class="card-container show">
  <?php
  $email = $_SESSION['email'];
  $query = "SELECT ownerform1.shopname, ownerform1.shopimage FROM ownerform1 JOIN register ON ownerform1.pincode = register.pincode and register.email='$email'";
  $result = mysqli_query($conn, $query);

  // Check if any rows were returned
  if (mysqli_num_rows($result) > 0) {
      // Loop through the rows and display the shop information
      while ($row = mysqli_fetch_assoc($result)) {
          $shopName = $row['shopname'];
          $shopImage = $row['shopimage'];

          // Display the shop card
          echo '
            <div class="card">
              <a href="shop.php?shopName='.urlencode($shopName).'">
                <img src="data:image/jpeg;base64,'.base64_encode($shopImage).'" alt="'.$shopName.'" style="width:150px; height: 150px;">
                <div class="card-content">
                  <h3 class="shop-name">'.$shopName.'</h3>
                   <button type="submit">Visit Shop</button>
                </div>
              </a>
            </div>';
      }
  } else {
      echo '<p>No matching shops found.</p>';
  }
  ?>
</div>






</body>
</html>
