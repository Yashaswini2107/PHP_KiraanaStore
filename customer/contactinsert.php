<?php
 
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  //Database Connection
  $conn = new mysqli('localhost','root','','grocery');
  if($conn->connect_error){
    die('Connection Failed : '.$conn->connect_error);
  }
  else{
    $stmt = $conn->prepare("insert into contactus(name, email, message) values(?,?,?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();

     echo '<script type="text/javascript">

          window.onload = function () { alert("Sent your Request Succesfully"); }

          </script>';
      //header("refresh:0.25; url=home1.php");
    $stmt->close();
    $conn->close();
  }



?>