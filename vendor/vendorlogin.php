<!DOCTYPE html>
<html>
<head>
  <title>Vendor Login | Kiraana Store</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      font-weight: bold;
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
    * {
      box-sizing: border-box;
      font-family: 'Quicksand', sans-serif;
    }
    html,
    body {
      margin: 0;
    }
    .full-screen-container {
      background-image: url('images/green-branches-with-small-brown-cones.jpg');
      height: 100vh;
      width: 100vw;
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-container {
      background-color: hsla(201, 100%, 6%, 0.6);
      padding: 50px 30px;
      min-width: 400px;
      width: 50%;
      max-width: 600px;
    }
    .login-title {
      color: #fff;
      text-align: center;
      margin: 0;
      margin-bottom: 40px;
      font-size: 2.5em;
      font-weight: normal;
    }
    .input-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 20px;
    }
    .input-group label {
      color: #fff;
      font-weight: lighter;
      font-size: 1.5em;
      margin-bottom: 7px;
    }
    .input-group input {
      font-size: 1.5em;
      padding: 0.1em 0.25em;
      background-color: hsla(201, 100%, 91%, 0.3);
      border: 1px solid hsl(201, 100%, 6%);
      outline: none;
      border-radius: 5px;
      color: #fff;
      font-weight: lighter;
    }
    .input-group input:focus {
      border: 1px solid hsl(201, 100%, 50%);
    }
    .login-button {
      padding: 10px 30px;
      width: 100%;
      border-radius: 5px;
      background: hsla(201, 100%, 50%, 0.1);
      border: 1px solid hsl(201, 100%, 50%);
      outline: none;
      font-size: 1.5em;
      color: #fff;
      font-weight: lighter;
      margin-top: 20px;
      cursor: pointer;
    }
    .login-button:hover {
      background-color: hsla(201, 100%, 50%, 0.3);
    }
    .login-button:focus {
      background-color: hsla(201, 100%, 50%, 0.5);
    }
    .toggle-password {
      position: relative;
      cursor: pointer;
    }
    .toggle-password i {
      position: absolute;
      top: 70%;
      right: 10px;
      transform: translateY(-50%);
      color: #000;
    }
    .input-group a{
      color:white;
      text-size:20px;
    }
  </style>
  <script>
     function togglePasswordVisibility() {
      var passwordInput = document.getElementById("password");
      var toggleIcon = document.getElementById("toggleIcon");
      
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
      } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
      }
    }
        function redirectToChangePassword() {
      // Function to redirect to the change password page
      window.location.href = "changepassword.php";
    }
  </script>
</head>
<body>
  <div class="navbar">
    <a class="logo" href="#">Kiraana Store</a>
    <div class="right-items">
    </div>
  </div>
  <div class="full-screen-container">
    <div class="login-container">
      <form class="form_main" action="vendorvalidate.php" method="post">
      <h3 class="login-title">Welcome</h3>
      <form>
        <div class="input-group">
          <label>Email</label>
          <input placeholder="E-mail" id="owneremail" name="owneremail" class="inputField" type="email" />
        </div>
        <div class="input-group toggle-password">
          <label>Password</label>
          <input placeholder="Password" id="password" name="ownerpassword" class="inputField" type="password" required/>
          <i id="toggleIcon" class="fas fa-eye" onclick="togglePasswordVisibility()"></i>
        </div>
        <button type="submit" class="login-button">Login</button>
        <button type="button" class="login-button" onclick="redirectToChangePassword()">Change Password</button>
      </form>
    </div>
  </div>
</body>
</html>
