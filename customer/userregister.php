
<!DOCTYPE html>

<html>
<head>
  <title>Registration Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0 auto;
      padding: 0;
        background-image: url('images/environment-friendly-objects-with-copy-space.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: 100%
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
      font-weight: bold;
    }
    .navbar a:hover {
      background-color:#1e1e1e;
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

    .container1{
      width: 600px;
      margin: 0 auto;
    
    }

    .column {
      float: left;
      width: 50%;
      padding: 20px;
      box-sizing: border-box;
    }

    .clearfix::after {
      content: "";
      display: table;
      clear: both;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="password"] {
      width: 100%;
      padding: 8px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-action {
      text-align: center;
      margin-top: 20px;
    }

    .form-action input[type="submit"] {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #ff4500;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>

   <header class="header-area header-sticky">
        <div class="container">
  <div class="navbar">
    <a class="logo" href="index.html"> Kiraana <span>store</span></a>
  </div>
</div>
</header>

 
    
       <div class="container1">
        <h2>Registration Form</h2>
     
        <div class="column">
            <form action="registerinsert.php" method="post">
                <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" placeholder="Enter your name" maxlength="50" name="username" pattern="[A-Z a-z]+" title="Letters only" required>
                </div>

        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" placeholder="Enter Your mail" required pattern="^[a-z][a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$" required>
        </div>

        <div class="form-group">
          <label for="phone">Mobile Number:</label>
          <input type="text" placeholder="Enter your Mobile number" name="mobileNumber" maxlength="10" pattern="[6-9]{1}[0-9]{9}" title="Invalid Mobile Number" required>
        </div>

        <div class="form-group">
          <label for="password">Password:</label>

          <input type="password" id="password" name="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$" placeholder="Enter Password" title="Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number." required>
        </div>

        <div class="form-group">
          <label for="confirm_password">Confirm Password:</label>
          <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm the Password" required>
        </div>
      </div>

        <div class="column">
          <div class="form-group">
            <label for="house_number">House Number:</label>
            <input type="text" id="housenumber" name="housenumber" placeholder="Enter Your HouseNumber" required>
          </div>

        <div class="form-group">
          <label for="building_name">Building Name:</label>
          <input type="text" id="buildingname" name="buildingname" placeholder="Enter Your Building Name" >
        </div>

        <div class="form-group">
          <label for="crossroad">Crossroad:</label>
          <input type="text" id="crossroad" name="crossroad" placeholder="Enter the Cross Road" required>
        </div>

        <div class="form-group">
          <label for="street">Street:</label>
          <input type="text" id="street" name="street" placeholder="Enter Street Name" required>
        </div>

        <div class="form-group">
          <label for="landmark">Landmark:</label>
          <input type="text" id="landmark" name="landmark" placeholder="Enter any Landmark" >
        </div>

        <div class="form-group">
          <label for="pincode">Pincode:</label>
          <input type="text" id="pincode" name="pincode" placeholder="Enter the Pincode" required>
        </div>
      </div>
    

      <div class="clearfix"></div>

      <div class="form-action">
        <input type="submit" class="button" value="Register">
      </div>
</body>
</html>
