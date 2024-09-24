<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '');

if (!$conn) {
    echo 'Not Connected to Server';
}

if (!mysqli_select_db($conn, 'grocery')) {
    echo 'Database not selected';
}

$email = $_POST['email'];
$password = $_POST['password'];


// ...

$query = mysqli_query($conn, "SELECT * FROM register WHERE email = '$email' AND password = '$password'");

if (mysqli_num_rows($query) == 0) {
    // ...
} else {
    $user = mysqli_fetch_assoc($query);
    $_SESSION['loggedin'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    
    // Retrieve shop name from products table
    $shopQuery = mysqli_query($conn, "SELECT * FROM products");
    if ($row = mysqli_fetch_assoc($shopQuery)) {
        $_SESSION['shopname'] = $row['shopname'];
    }

  

    echo '<script type="text/javascript">
        window.onload = function () { alert("LOGIN SUCCESSFUL"); }
    </script>';
    header("refresh:0.25; url=userdash.php");
}
?>
