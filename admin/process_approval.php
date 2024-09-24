<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grocery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include PHPMailer
//require 'vendor/PHPMailer/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/PHPMailer.php';




// Check if the form was submitted and a button was clicked
if (isset($_POST['shop_id'])) {
    $shopId = $_POST['shop_id'];
    if (isset($_POST['approve'])) {
        // Perform the accept action
        // Update the status column to 'accepted' for the specified shop ID
        $updateQuery = "UPDATE ownerform1 SET status = 'approve' WHERE shop_id = $shopId";
        $conn->query($updateQuery);

        // Generate a random password
        $ownerPassword = generateRandomPassword();
                // $ownerPassword = 1234567;

                // $ownerPassword = password_hash($ownerPassword,PASSWORD_DEFAULT);
               // echo "ownerPassword==process_approval $ownerPassword";

        

        // Hash the password
        // $hashedPassword = password_hash($ownerPassword, PASSWORD_DEFAULT);
        // echo "hashedPassword==process_approval $hashedPassword";
        

        // Store the hashed password in the database
        $passwordQuery = "UPDATE ownerform1 SET ownerpassword = '$ownerPassword' WHERE shop_id = $shopId";
        $conn->query($passwordQuery);

        

        // Retrieve the email of the accepted shop owner
        $emailQuery = "SELECT owneremail FROM ownerform1 WHERE shop_id = $shopId";
        $emailResult = $conn->query($emailQuery);
        $row = $emailResult->fetch_assoc();
        $ownerEmail = $row['owneremail'];

        // Send email to the accepted shop owner
        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = 'kiraanastore99@gmail.com';
            $mail->Password = 'yxmkonnlhgwveblr';
            $mail->setFrom('kiraanastore99@gmail.com');

            // Recipient email
            $mail->addAddress($ownerEmail);


            // Email content
            $mail->isHTML(true);
$mail->Subject = 'Shop Approval';
$mail->Body = "Congratulations! Your shop request has been accepted.<br><br>"
    . "Login using your Registered E-mail ID with the Password given below.<br><br>"
    . "Your Password: $ownerPassword<br><br>"
    . "Please keep this information secure and use it to access your shop account. "
    . "You can log in by clicking the link below:<br><br>"
    . "<a href='index.php'>Login Here</a>";


              
            // Send the email
            $mail->send();
            
            echo '<script type="text/javascript">
        window.onload = function () { alert("Shop has been accepted. An email has been sent to the shop owner."); }
    </script>';
    header("refresh:0.25; url=dash2.html");

        } catch (Exception $e) {
            echo "Failed to send email. Error: " . $mail->ErrorInfo;
        }
    } elseif (isset($_POST['reject'])) {
        // Perform the reject action
        // Update the status column to 'rejected' for the specified shop ID
        $updateQuery = "UPDATE ownerform1 SET status = 'reject' WHERE shop_id = $shopId";
        $conn->query($updateQuery);

        echo "Shop with ID $shopId has been rejected.";
    }
}

// Close the database connection
$conn->close();

// Function to generate a random password
function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}
?>
