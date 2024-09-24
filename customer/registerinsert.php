<?php

   $conn = mysqli_connect('localhost','root','');

   if(!$conn)
   {
       echo 'Not Connected to Server';
   }

   if(!mysqli_select_db($conn,'grocery'))
   {
       echo 'Database not selected';
   }

   
   
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $mobileNumber = $_POST['mobileNumber'];
    $housenumber = $_POST['housenumber'];
    $buildingname = $_POST['buildingname'];
    $crossroad = $_POST['crossroad'];
    $street = $_POST['street'];
    $landmark = $_POST['landmark'];
    $pincode = $_POST['pincode'];

  $sql = "INSERT INTO register (email, username, password, mobileNumber, housenumber, buildingname, crossroad, street, landmark, pincode) VALUES ( '$email', '$username', '$password', '$mobileNumber', '$housenumber', '$buildingname', '$crossroad', '$street', '$landmark', '$pincode')";



    if(!mysqli_query($conn,$sql))
      {
        echo '<script type="text/javascript">
                 window.onload = function () { alert("USER ALREADY  EXISTS"); }
              </script>';
        header("refresh:0.25; url=userregister.php");
      }   
   else
   {
    echo '<script type="text/javascript">
             window.onload = function () { alert("REGISTERED SUCCESSFULL"); }
          </script>';
   header("refresh:0.25; url=login.html");

   }
?>