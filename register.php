<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
</head>
<body>
      <div class="container">
        <div class="box form-box">

        <?php 
         
         include("php/config.php");
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;


         if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $phone= $_POST['phone'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            
            //mailer
            function sendMail($email,$token)
            {
                require("php mailer/PHPMailer.php");
                require("php mailer/SMTP.php");
                require("php mailer/Exception.php");

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = '201001504@rajalakshmi.edu.in';                     //SMTP username
                    $mail->Password   = 'Rohithit@504';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
                    //Recipients
                    $mail->setFrom('201001504@rajalakshmi.edu.in', 'Rohithkumar');
                    $mail->addAddress($email);     //Add a recipient
                   
                
                  
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Email Verification';
                    $mail->Body    = "Thanks for registeration!
                    click the link below to verify the email address 
                    <a href='http://localhost/simple php system/verify.php?email=$email&token=$token'> verify </a>";
                  
                
                    $mail->send();
                   return true;
                } catch (Exception $e) {
                    return false;
                }
            }
         
            //verifying the unique email

         $verify_query = mysqli_query($con,"SELECT Email FROM users WHERE Email='$email'");

         if(mysqli_num_rows($verify_query) !=0 ){
            echo "<div class='message'>
                      <p>This email is used, Try another One Please!</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
         }
         else{
            $token=bin2hex(random_bytes(16));
           $verify= "INSERT INTO users(username,Email,phone,Password,confirm_password,token,status) VALUES('$username','$email','$phone','$password','$confirm_password','$token','0')";
            if(mysqli_query($con,"$verify")&& sendMail($_POST['email'],$token)) {
                echo "<div class='message'>
                          <p>Registration successfully!</p>
                      </div> <br>";
                echo "<a href='index.php'><button class='btn'>Login Now</button>";
                }
                else{
                    echo "<div class='message'>
                          <p>Server Down!</p>
                      </div> <br>";
                echo "<a href='index.php'><button class='btn'>Login Now</button>";
                }

         }

         }else{
         
        ?>

            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="phone">Phone number</label>
                    <input type="text" name="phone" id="phone" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="Confirm_password">confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    Already a member? <a href="index.php">Sign In</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>
