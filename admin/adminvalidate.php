<?php
session_start();
  $email = "";
  $password = "";
  $con = mysqli_connect('localhost','root',"");

  if(!$con)
  {
      echo 'Not Connected to Server';
  }

  if(!mysqli_select_db($con,'grocery'))
  {
      echo 'Database not selected';
  }
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = mysqli_query($con,"select * from admin where email = '$email' and password = '$password'");

  if(mysqli_num_rows($query) == 0){
    echo '<script type="text/javascript">

    window.onload = function () { alert("Invalid Credentials"); }

</script>';


   header("refresh:0.25; url=adminlogin.html");
  }
  else
  {
      $_SESSION['email']=$email;
      $_SESSION['password']=$password;
      echo '<script type="text/javascript">

          window.onload = function () { alert("LOGIN SUCCESSFULL"); }

</script>';
      header("refresh:0.25; url=dash2.html"); 
  }

?>