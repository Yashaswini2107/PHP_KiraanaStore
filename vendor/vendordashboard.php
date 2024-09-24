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
    <h2 style="margin-top:10px;"><?php echo $shopname; ?></h2>
    <form action="add_category.php" method="post">
  </div>

  <div id="menu">
    <span id="menu-toggle" onclick="toggleNav()">&#9776;</span>
  </div>
  
  <div id="sidenav">
    <div class="side-header">
      <center>
        <img src="images/ks.png" width="250" height="150" alt="ks">
      </center>
      <center>
        <h2 style="margin-top:10px;"><?php echo $shopname; ?></h2>
      </center>
      <h5 style="margin-top:10px;"></h5>
    </div>
    <a href="javascript:void(0)" class="closebtn" onclick="toggleNav()">&times;</a>

    <a href="#"><i class="fas fa-chart-bar"></i> Dashboard</a>
    <a href="#" onclick="openEditProfileModal()"><i class="fas fa-edit"></i> Edit Profile</a>
    <a href="#"><i class="fas fa-users"></i> Customers</a>
    <div class="dropdown">
      <a href="#" id="categoryLink"><i class="fas fa-list"></i> Category</a>
      <div class="dropdown-content" id="categoryDropdownContent" name="category">
        <a href="#" onclick="openAddCategoryModal()"><i class="fas fa-plus"></i> Add Category</a>
        <a href="#" onclick="openViewCategoryModal()"><i class="fas fa-eye"></i> View Category</a>
      </div>
    </div>
    
      
   <div class="dropdown">
  <a href="#" id="productLink" onclick="toggleProductDropdown()"><i class="fas fa-box-open"></i> Products</a>
  <div class="dropdown-content" id="productDropdownContent">
    <a href="#" onclick="openAddProductModal()"><i class="fas fa-plus"></i> Add Product</a>
    <a href="#" onclick="loadProductContent()"><i class="fas fa-box"></i> View Product</a>
  </div>
</div>
    <a href="view_order.php"><i class="fas fa-shopping-cart"></i> Orders</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
      <form id="addCategoryForm" action="add_category.php" method="POST">
        <label for="categoryName">Category Name:</label>
        <input type="text" id="categoryName" name="categoryname" required>

         <label for="subcategoryName">SubCategory Name:</label>
        <input type="text" id="subcategoryName" name="subcategoryname[]" required>

        <button type="submit">Add</button>
      </form>
    </div>
  </div>

  <!-- View Category Modal
  <div id="viewCategoryModal" class="modal">
    <a href="view_category.php">View Category</a>
  </div> -->
  <div id="editProfileModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeEditProfileModal()">&times;</span>
    <h2>Edit Profile</h2>
   <form method="POST" action="update_profile.php">
  <label for="shopName">Shop Name:</label>
  <input type="text" id="shopName" name="shopName" value="<?php echo $shopname; ?> ">
  
  <label for="address">Address:</label>
<input type="text" id="address" name="address" value=""><br><br>

  <label for="pincode">Pincode:</label>
  <input type="number" id="pincode" name="pincode" value=""><br><br>
  
  <label for="contactNumber">Contact Number:</label>
  <input type="tel" id="contactNumber" name="contactNumber" value=""><br><br>
  
  <label for="ownerPhone">Owner Phone:</label>
  <input type="tel" id="ownerPhone" name="ownerPhone" value=""><br><br>
  
  <label for="ownerEmail">Owner Email:</label>
  <input type="email" id="ownerEmail" name="ownerEmail" value="<?php echo $owneremail; ?>"><br><br>
  
  <label for="openingHours">Opening Hours:</label>
  <input type="time" id="openingHours" name="openingHours" value=""><br><br>
  
  <label for="closingHours">Closing Hours:</label>
  <input type="time" id="closingHours" name="closingHours" value=""><br><br>
  
  <button type="submit">Update Profile</button>
</form>

</div>
</div>

  <!-- Add Product Modal -->
  <div id="addProductModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeAddProductModal()">&times;</span>
      <h2>Add Product</h2>
      <form method="POST" action="add_product.php" enctype="multipart/form-data">
        <table>
          <tr>
            <td><label for="productName">Product Name:</label></td>
            <td><input type="text" id="productName" name="productName"></td>
          </tr>
          <tr>
            <td><label for="productPrice">Product Price:</label></td>
            <td><input type="text" id="productPrice" name="productPrice"></td>
          </tr>

           <tr>
          <td><label for="stockQuantity">Stock Quantity:</label></td>
          <td><input type="number" id="stockQuantity" name="stock_quantity" required></td>
        </tr>



          <tr>
            <td><label for="productDescription">Product Description:</label></td>
            <td><textarea id="productDescription" name="productDescription"></textarea></td>
          </tr>
          
<tr>
  <td><label for="productCategory">Product Category:</label></td>
  <td>
    <select id="productCategory" name="productCategory" onchange="fetchSubCategories(this.value)">
      <option value="">Select Your Category</option>
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

      $sql = "SELECT * FROM category";
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        $categoryName = $row['categoryname'];
        ?>
        <option value="<?php echo $categoryName; ?>"><?php echo $categoryName; ?></option>
        <?php
      }

      mysqli_close($conn);
      ?>
    </select>
  </td>
</tr>
<tr>
  <td><label for="subproductCategory">Sub Product Category:</label></td>
  <td>
    <select id="subproductCategory" name="subproductCategory">
      <option value="">Select Sub Category</option>
    </select>
  </td>
</tr>
<script>
  function fetchSubCategories(category) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var subcategories = JSON.parse(this.responseText);
      var selectElement = document.getElementById("subproductCategory");
      selectElement.innerHTML = "<option value=''>Select Sub Category</option>";
      for (var i = 0; i < subcategories.length; i++) {
        var option = document.createElement("option");
        option.value = subcategories[i];
        option.textContent = subcategories[i];
        selectElement.appendChild(option);
      }
    }
  };
  xhttp.open("GET", "getsubcategories.php?category=" + encodeURIComponent(category), true);
  xhttp.send();
}


</script>




          <tr>
            <td><label for="productImage">Product Image:</label></td>
            <td><input type="file" id="productImage" name="productImage"></td>
          </tr>
          <tr>
            <td colspan="2"><button  type="submit" onclick="addProduct()">Add Product</button></td>
          </tr>
        </table>
      </form>
    </div>
  </div>

  <!-- View Product Modal
<div id="viewProductModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeViewProductModal()">&times;</span>
    <h2>View Product</h2>
    <a href="view_product.php" class="view-products-link">View Products</a>
  </div>
</div>

       Add any input fields or filters for viewing products 
      <button type="submit">View Products</button>-->
    </form>
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
    function closeviewCategoryModal() {
    var modal = document.getElementById("viewCategoryModal");
    modal.style.display = "none";
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

// Function to toggle the product dropdown when clicking on the menu item
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
function toggleProductDropdown() {
  var productDropdownContent = document.getElementById("productDropdownContent");
  
  // Toggle the visibility of the dropdown content
  if (productDropdownContent.style.display === "block") {
    productDropdownContent.style.display = "none";
  } else {
    productDropdownContent.style.display = "block";
  }
}



// Close the product dropdown when clicking outside the dropdown menu
window.onclick = function(event) {
  var productDropdownContent = document.getElementById("productDropdownContent");
  
  if (!event.target.matches("#productLink")) {
    if (productDropdownContent.style.display === "block") {
      productDropdownContent.style.display = "none";
    }
  }
};
// Open the edit profile modal
function openEditProfileModal() {
  var modal = document.getElementById("editProfileModal");
  modal.style.display = "block";
}

// Close the edit profile modal
function closeEditProfileModal() {
  var modal = document.getElementById("editProfileModal");
  modal.style.display = "none";
}

function openEditProfileModal() {
  var modal = document.getElementById("editProfileModal");
  modal.style.display = "block";
}

function closeEditProfileModal() {
  var modal = document.getElementById("editProfileModal");
  modal.style.display = "none";
}


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
  
  
// To display the content on the right side of the sidenav
function loadCategoryContent() {
  // Create an AJAX request
  var xhr = new XMLHttpRequest();

  // Define the request URL
  var url = 'view_category.php';

  // Set up the AJAX request
  xhr.open('GET', url, true);

  // Define the callback function
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Update the content div with the received data
        document.getElementById('content').innerHTML = xhr.responseText;
      } else {
        // Handle error if the request fails
        console.log('Error: ' + xhr.status);
      }
    }
  };

  // Send the AJAX request
  xhr.send();
}

function loadProductContent() {
  // Create an AJAX request
  var xhr = new XMLHttpRequest();

  // Define the request URL
  var url = 'view_product.php';

  // Set up the AJAX request
  xhr.open('GET', url, true);

  // Define the callback function
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Update the content div with the received data
        document.getElementById('content').innerHTML = xhr.responseText;
      } else {
        // Handle error if the request fails
        console.log('Error: ' + xhr.status);
      }
    }
  };

  // Send the AJAX request
  xhr.send();
}



  </script>
</body>
</html>
