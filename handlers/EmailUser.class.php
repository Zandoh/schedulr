<?php
class EmailUser {

  function __construct() {
    if(!class_exists('PHPMailer')) {
      require(__DIR__ . '/../assets/php/PHPMailer/PHPMailer.php');
      require(__DIR__ . '/../assets/php/PHPMailer/SMTP.php');
      require(__DIR__ . '/../assets/php/PHPMailer/Exception.php');
    }
  }

  /*
  * Email a user an email with a link to reset password
  */
  function emailUser($email) {
    $home = getenv('HTTP_HOST');

    //create a salt value to be used in the email
    $salt = "i7S1xo9pvXG%u1Krd8Fhi3oE2JEZzQ4csCUqeKc07OsiHj96j7*sp3pXcO9C1H9jiM0jqCKfMbb8phzu";

    //create a unique user key
    $key = hash("sha256", $salt . $email);

    $url = $home . "/schedulr-master/reset-password.php?key=" . $key;
    

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $emailBody = "<h2>Password Reset</h2>
    <div>Recovery Email: " . $email . ",<br><br>
    <p>Click to reset your password:<br>
    <a href='" . $url . "'>" . $url . "</a>
    <br><br>
    </p>Thank you,<br> RAIHN.</div>";
    $mail->IsSMTP();
    $mail->SMTPDebug  = 0;
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;  
    $mail->IsHTML(true);
    $mail->Username   = 'raihnhelp@gmail.com';
    $mail->Password   = '3bK74kKMAd';
    $mail->Host       = 'smtp.gmail.com';
    $mail->SetFrom("raihnhelp@gmail.com");
    $mail->Subject    = "RAIHN Password Reset";
    $mail->Body       = $emailBody;
    $mail->AddAddress($email);

    if(!$mail->Send()) {
      return false;
    } else {
      return true;
    }


  }//end of emailUser
  
}