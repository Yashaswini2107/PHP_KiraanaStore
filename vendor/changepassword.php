<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: vendorlogin.html");
    exit;
}


// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted form data
    $oldPassword = $_POST["oldPassword"];
    $newPassword = $_POST["newPassword"];

    // Validate the form data (you can add more validation if needed)
    $errors = [];
    if (empty($oldPassword)) {
        $errors[] = "Please enter your old password.";
    }
    if (empty($newPassword)) {
        $errors[] = "Please enter your new password.";
    }

    // If there are no validation errors, proceed with password change
    if (empty($errors)) {
        // Database connection parameters
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "grocery";

    // Create a database connection
        $conn = mysqli_connect($host, $username, $password, $database);

        // Check if the connection was successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

    // Prepare and execute the password update query
        $sql = "UPDATE ownerform1 SET ownerpassword = '$newPassword' WHERE ownerpassword = '$oldPassword'";
        if (mysqli_query($conn, $sql)) {
            // Display a success message
           echo '<script type="text/javascript">
            window.onload = function () { alert("Password Changed Successfully"); }
          </script>';
           header("refresh:0.25; url=vendorlogin.php");
        } else {
            // Display an error message
           echo '<script type="text/javascript">
            window.onload = function () { alert("Error Upadating Password"); }
          </script>';
           header("refresh:0.25; url=changepassword.php");
        }

    // Close the database connection
        mysqli_close($conn);
    } else {
        // Display the validation errors
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Change Password | Kiraana Store</title>
</head>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      font-weight: bold;
      background-position-x: right;
      background-image: url('images/cp.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: 40%;
    }

    .password-container {
      background-color: hsla(201, 100%, 6%, 0.6);
      padding: 50px 30px;
      border-radius: 50px;
      min-width: 400px;
      width: 50%;
      max-width: 600px;
      margin: 100px auto;
      float: left;
    }

    .password-title {
      color: #fff;
      text-align: center;
      margin: 0;
      margin-bottom: 40px;
      font-size: 2.5em;
      font-weight: normal;
    }

    .password-group {
      position: relative;
    }

    .password-label {
      color: #fff;
      font-weight: lighter;
      font-size: 1.5em;
      margin-bottom: 7px;
    }

    .password-value {
      font-size: 1.5em;
      padding: 0.1em 0.25em;
      background-color: hsla(201, 100%, 91%, 0.3);
      border: 1px solid hsl(201, 100%, 6%);
      outline: none;
      border-radius: 5px;
      color: #fff;
      font-weight: lighter;
      width: 90%;
      margin-bottom: 20px;
      padding-right: 30px;
    }

     .toggle-password {
  position: absolute;
  top: 50%;
  right: 30px;
  transform: translateY(-50%);
  cursor: pointer;
  font-size: 1.5em;
  color: #000;
}


    .submit {
      font-size: 20px;
    }
  </style>
</head>
<body>
  <div class="password-container">
    <h3 class="password-title">Change Password</h3>
    <div class="password-group">
      <label class="password-label">Old Password</label>
      <div>
        <input type="password" id="old-password" class="password-value" />
        <span class="toggle-password" id="toggle-old-password" onclick="togglePasswordVisibility('old-password', 'toggle-old-password')"><i class="fas fa-eye"></i></span>
      </div>
    </div>
    <div class="password-group">
      <label class="password-label">New Password</label>
      <div>
        <input type="password" id="new-password" class="password-value" />
        <span class="toggle-password" id="toggle-new-password" onclick="togglePasswordVisibility('new-password', 'toggle-new-password')"><i class="fas fa-eye"></i></span>
      </div>
    </div>
    <div>
    <button type="submit" class="submit">Change Password</button>
  </div>
  </div>

  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script>
  function togglePasswordVisibility(passwordFieldId, toggleIconId) {
    var passwordField = document.getElementById(passwordFieldId);
    var toggleIcon = document.getElementById(toggleIconId);

    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      toggleIcon.querySelector('svg').classList.remove('fa-eye-slash');
      toggleIcon.querySelector('svg').classList.add('fa-eye');
    } else {
      passwordField.type = 'password';
      toggleIcon.querySelector('svg').classList.remove('fa-eye');
      toggleIcon.querySelector('svg').classList.add('fa-eye-slash');
    }
  }
</script>

</body>
</html>