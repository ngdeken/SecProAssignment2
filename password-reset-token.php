<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['password-reset-token']) && $_POST['user_email'])
{
   require ("./db_connection.php");
   
    $emailId = $_POST['user_email'];

    $stmt = $db_connection->prepare("SELECT * FROM users WHERE user_email= ?");
    $stmt->bind_param("s", $emailId);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_array(MYSQLI_ASSOC);
 
  if($row)
  {
     
     $token = md5($emailId).rand(10,9999);
 
     $expFormat = mktime(
     date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
     );
 
    $expDate = date("Y-m-d H:i:s",$expFormat);
 
    $stmt = $db_connection->prepare("UPDATE users set reset_link_token=?, exp_date=? WHERE user_email=?");
    $stmt->bind_param("sss", $token, $expDate, $emailId);
    $stmt->execute();
 
    $link = "
    <a href='http://localhost/spasg1/reset-password.php?key=".$emailId."&token=".$token."'>
    Click to reset password</a>";
    
   require 'vendor/autoload.php';

   require 'vendor/phpmailer/phpmailer/src/Exception.php';
   require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
   require 'vendor/phpmailer/phpmailer/src/SMTP.php';
 
    $mail = new PHPMailer();

    $mail->SMTPOptions = array(
      'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
      )
      );
 
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    // enable SMTP authentication
    $mail->SMTPAuth = true;                  
    // GMAIL username
    $mail->Username = "deken0923@gmail.com"; //set gmail here
    // GMAIL password
    $mail->Password = "yazrruxruedcnaft "; //set generated passwoord (16characters)
    $mail->SMTPSecure = "ssl";  
    // sets GMAIL as the SMTP server
    $mail->Host = "smtp.gmail.com";
    // set the SMTP port for the GMAIL server
    $mail->Port = "465";
    $mail->From = "deken0923@gmail.com"; //same email here
    $mail->FromName = 'Ng De Ken';
    $mail->SMTPDebug = 0;
    $mail->AddAddress($emailId, $row['username']);
    $mail->Subject  =  'SECR4973-01 Password Recovery';
    $mail->IsHTML(true);
    $mail->Body    = 'Click the link to reset password '.$link.'';
    if($mail->Send())
    {
      echo "<p style='text-align:center;' >Check your email and click on the link sent to your email.</p>";
    }
    else
    {
      echo "Mail Error - >".$mail->ErrorInfo;
    }
  }else{
    echo "<p style='text-align:center;'>Invalid Email Address</p>";
    
  }
}