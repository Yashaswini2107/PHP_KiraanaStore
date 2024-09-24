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

   
   
    $shopname = $_POST['shopname'];
    $address = $_POST['address'];
    $contactnumber = $_POST['contactnumber'];
    $FSSAIlicense = $_POST['FSSAIlicense'];
    $GSTNO = $_POST['GSTNO'];
    $tradelicense = $_POST['tradelicense'];
   // $location = $_POST['location'];
    $ownername = $_POST['ownername'];
    $ownerphone = $_POST['ownerphone'];
    $owneremail = $_POST['owneremail'];
    $grocerytype = $_POST['grocerytype'];
    $openinghours = $_POST['openinghours'];
    $closinghours = $_POST['closinghours'];
    $openingdays = $_POST['openingdays'];
    $pincode = $_POST['pincode'];
    $imagePath = $_FILES['shopimage']['tmp_name'];

    // Convert image to BLOB
$shopimage = addslashes(file_get_contents($imagePath));

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grocery";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

  $sql = "INSERT INTO ownerform1 (shopname, address, contactnumber, FSSAIlicense, GSTNO, tradelicense,  ownername, ownerphone, owneremail, grocerytype, openinghours, closinghours, openingdays,shopimage,pincode) VALUES ( '$shopname', '$address', '$contactnumber', '$FSSAIlicense', '$GSTNO', '$tradelicense',  '$ownername', '$ownerphone', '$owneremail', '$grocerytype', '$openinghours', '$closinghours', '$openingdays','$shopimage','$pincode')";



    if(!mysqli_query($conn,$sql))
      {
        //echo '<script type="text/javascript">
          //       window.onload = function () { alert("USER ALREADY  EXISTS"); }
            //  </script>';
        //header("refresh:0.25; url=userregister.php");
      }   
   else
   {
    echo '<script type="text/javascript">
             window.onload = function () { alert("FORM SUBMITTED SUCCESSFULL"); }
          </script>';
   header("refresh:0.25; url=index.html");

   }
?>