
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: vendorlogin.html");
    exit;
}

// Retrieve the logged-in user's email from the session
$owneremail = $_SESSION['owneremail'];

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

// Retrieve the dashboard content specific to the logged-in user
$sql = "SELECT * FROM ownerform1 WHERE owneremail = '$owneremail'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error retrieving dashboard content: " . mysqli_error($conn));
}

// Fetch and display the dashboard content
while ($row = mysqli_fetch_assoc($result)) {
    // Display the dashboard content
    // Example: echo $row['content'];
    // Customize this part to display the specific dashboard content for the user
}

// Retrieve the dashboard content specific to the logged-in user
$sql = "SELECT shopname FROM ownerform1 WHERE owneremail = '$owneremail'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error retrieving dashboard content: " . mysqli_error($conn));
}

// Fetch the shop name
$row = mysqli_fetch_assoc($result);
$shopname = $row['shopname'];


// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
  <title>Vendor Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    
    #header {
      background-color: #ff4500;
      color: #fff;
      padding: 10px;
      text-align: center;
    }
    
    #menu {
      background-color: #ff4500;
      padding: 10px;
    }
    
    #menu ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }
    
    #menu ul li {
      display: inline-block;
      margin-right: 10px;
    }
    
    #menu ul li a {
      color: #333;
      text-decoration: none;
      padding: 5px 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    
    #content {
      padding: 20px;
    }
    
    #sidenav {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: #ff4500; /* Updated color */
      overflow-x: hidden;
      padding-top: 60px;
      transition: 0.5s;
    }
    
    #sidenav a {
      padding: 8px 8px 8px 32px;
      text-decoration: none;
      font-size: 20px;
      font-weight: bold;
      color: #fff;
      display: block;
      transition: 0.3s;
      margin-bottom: 10px; /* Added margin-bottom */
    }
    
    #sidenav a:hover {
      background-color: #333;
    }
    
    #sidenav .closebtn {
      position: absolute;
      top: 0;
      right: 25px;
      font-size: 36px;
      margin-left: 50px;
    }
    
    #menu-toggle {
      position: fixed;
      top: 10px;
      left: 10px;
      font-size: 24px;
      cursor: pointer;
    }
    .side-header img{
     border-radius: 140%;
    }
    .card {
  background-color: #add8e6;
  border-radius: 4px;
  padding: 20px;
  text-align: center;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.3s ease;
  display: inline-block;
  width: calc(23% - 20px); /* Adjust the width based on the number of cards */
  margin: 10px;
  box-sizing: border-box; /* Include padding in the width calculation */
  vertical-align: top; /* Align cards to the top */
  height: 200px; /* Adjust the height as needed */
}

.card:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.card i {
  font-size: 40px;
  color: #ff4500;
  margin-bottom: 10px;
}

.card h5 {
  font-size: 21px;
  margin-bottom: 10px;
}
/* Add Category Modal */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

/* Category Form */
#addCategoryForm input[type="text"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
}

#addCategoryForm button {
  background-color: #ff4500;
  color: #fff;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
}

#addCategoryForm button:hover {
  background-color: #e63c00;
}
/* CSS styles for the modal */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 10% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
  .modal-content table {
      width: 100%;
      border-collapse: collapse;
    }

    .modal-content td {
      padding: 10px;
    }

    .modal-content input[type="text"],
    .modal-content textarea,
    .modal-content select {
      width: 100%;
      padding: 8px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    .modal-content button {
      background-color: #ff4500;
      color: #fff;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
    }

    .modal-content button:hover {
      background-color: #e63c00;
    }
  </style>
</head>
<body>
  <div id="header">
    <h1>Vendor Dashboard</h1>
     <h2 style="margin-top:10px;"><?php echo $shopname; ?>
  </div>
  
  <div id="menu">
    <span id="menu-toggle" onclick="toggleNav()">&#9776;</span>
  </div>
  

    <div id="sidenav">
  <div class="side-header">
    <center>
      <img src="ks.png" width="250" height="150" alt="ks">
    </center>
    <center>
    <h2 style="margin-top:10px;"><?php echo $shopname; ?></h2>
    </center> <!-- Display the shop name here -->
  </div>
  <!-- Rest of the navbar code -->

    <a href="javascript:void(0)" class="closebtn" onclick="toggleNav()">&times;</a>

    <a href="#"><i class="fas fa-chart-bar"></i> Dashboard</a>
    <a href="#"><i class="fas fa-users"></i> Customers</a>
    <div class="dropdown">
      <a href="#" id="categoryLink"><i class="fas fa-list"></i> Category</a>
      <div class="dropdown-content" id="categoryDropdownContent">
        <a href="#" onclick="openAddCategoryModal()"><i class="fas fa-plus"></i> Add Category</a>
        <a href="#" onclick="openViewCategoryModal()"><i class="fas fa-eye"></i> View Category</a>
      </div>
    </div>
   <div class="dropdown">
  <a href="#" id="productLink"><i class="fas fa-box-open"></i> Products</a>
  <div class="dropdown-content" id="productDropdownContent">
    <a href="#" onclick="openAddProductModal()"><i class="fas fa-plus"></i> Add Product</a>
    <a href="#" onclick="openViewProductModal()"><i class="fas fa-eye"></i> View Product</a>
  </div>
</div>

    <a href="#"><i class="fas fa-shopping-cart"></i> Orders</a>
  </div>
  </div>


  <div id="content">
    <div id="content">
      <div class="card">
        <i class="fas fa-users" style="font-size: 50px;"></i>
        <h5>Total Users</h5>
      </div>
      <div class="card">
        <i class="fas fa-list" style="font-size: 50px;"></i>
        <h5>Total Categories</h5>
      </div>
      <div class="card">
        <i class="fas fa-box-open" style="font-size: 50px;"></i>
        <h5>Total Products</h5>
      </div>
      <div class="card">
        <i class="fas fa-shopping-cart" style="font-size: 50px;"></i>
        <h5>Total Orders</h5>
      </div>
    </div>
  </div>

  <div id="addCategoryModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeAddCategoryModal()">&times;</span>
    <h2>Add Category</h2>
    <form id="addCategoryForm">
      <label for="categoryName">Category Name:</label>
      <input type="text" id="categoryName" required>
      <label for="subcategoryName">Sub Category Name:</label>
      <input type="text" id="subcategoryName" required>
      <button type="submit">Add</button>
    </form>
  </div>
</div>


  <!-- View Category Modal -->
  <div id="viewCategoryModal" class="modal">
    <!-- ... Modal content for viewing category ... -->
  </div>
 <!-- Add Product Modal -->
<div id="addProductModal" class="modal">

  <div class="modal-content">
     <span class="close" onclick="closeAddProductModal()">&times;</span>
    <table>
      <tr>
        <td><label for="productName">Product Name:</label></td>
        <td><input type="text" id="productName"></td>
      </tr>
      <tr>
        <td><label for="productPrice">Product Price:</label></td>
        <td><input type="text" id="productPrice"></td>
      </tr>
      <tr>
        <td><label for="productDescription">Product Description:</label></td>
        <td><textarea id="productDescription"></textarea></td>
      </tr>
      <tr>
        <td><label for="productCategory">Product Category:</label></td>
        <td>
          <select id="productCategory">
            <option value="category1">Category 1</option>
            <option value="category2">Category 2</option>
            <option value="category3">Category 3</option>
            <!-- Add more options as needed -->
          </select>
        </td>
      </tr>
      <tr>
        <td><label for="productImage">Product Image:</label></td>
        <td><input type="file" id="productImage"></td>
      </tr>
      <tr>
        <td colspan="2"><button onclick="addProduct()">Add Product</button></td>
      </tr>
    </table>
  </div>
</div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
  <script>
    function toggleNav() {
      var sidenav = document.getElementById("sidenav");
      var menuToggle = document.getElementById("menu-toggle");
      if (sidenav.style.width === "250px") {
        sidenav.style.width = "0";
        menuToggle.style.marginLeft = "10px";
      } else {
        sidenav.style.width = "250px";
        menuToggle.style.marginLeft = "260px";
      }
    }

    // JavaScript code for the dropdown functionality
    document.addEventListener("DOMContentLoaded", function() {
      var categoryLink = document.getElementById("categoryLink");
      var dropdownContent = document.getElementById("categoryDropdownContent");

      // Event listener for clicking on the "Category" menu item
      categoryLink.addEventListener("click", function(event) {
        event.preventDefault(); // Prevent the default anchor link behavior

        // Toggle the visibility of the dropdown content
        if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
        } else {
          dropdownContent.style.display = "block";
        }
      });

      // Event listener for clicking outside the dropdown to close it
      document.addEventListener("click", function(event) {
        if (!categoryLink.contains(event.target) && !dropdownContent.contains(event.target)) {
          dropdownContent.style.display = "none";
        }
      });
    });

    // Add Category Modal
function openAddCategoryModal() {
  var modal = document.getElementById("addCategoryModal");
  modal.style.display = "block";
}

function closeAddCategoryModal() {
  var modal = document.getElementById("addCategoryModal");
  modal.style.display = "none";
}

// Handle form submission
document.getElementById("addCategoryForm").addEventListener("submit", function(event) {
  event.preventDefault(); // Prevent the default form submission
  
  // Get the category name from the input field
  var categoryNameInput = document.getElementById("categoryName");
  var categoryName = categoryNameInput.value;
  
  // Perform any validation or data processing as needed
  
  // Reset the input field
  categoryNameInput.value = "";
  
  // Close the modal
  closeAddCategoryModal();
  
  // Perform any further actions, such as updating the UI or sending the category data to the server
});


    // View Category Modal
    function openViewCategoryModal() {
      var modal = document.getElementById("viewCategoryModal");
      modal.style.display = "block";
    }
    // JavaScript code for the dropdown functionality
document.addEventListener("DOMContentLoaded", function() {
  var productLink = document.getElementById("productLink");
  var productDropdownContent = document.getElementById("productDropdownContent");

  // Event listener for clicking on the "Products" menu item
  productLink.addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the default anchor link behavior

    // Toggle the visibility of the dropdown content
    if (productDropdownContent.style.display === "block") {
      productDropdownContent.style.display = "none";
    } else {
      productDropdownContent.style.display = "block";
    }
  });

  // Event listener for clicking outside the dropdown to close it
  document.addEventListener("click", function(event) {
    if (!productLink.contains(event.target) && !productDropdownContent.contains(event.target)) {
      productDropdownContent.style.display = "none";
    }
  });
});

// Add Product Modal
function openAddProductModal() {
  var modal = document.getElementById("addProductModal");
  modal.style.display = "block";
}

// View Product Modal
function openViewProductModal() {
  var modal = document.getElementById("viewProductModal");
  modal.style.display = "block";
}
// Close Add Product Modal
function closeAddProductModal() {
  var modal = document.getElementById("addProductModal");
  modal.style.display = "none";
}


  </script>
</body>
</html>
