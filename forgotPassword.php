<?php
require "connection.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $result = Database::search("SELECT * FROM `customer_table` WHERE `customer_email` = '$email'");

    if ($result->num_rows == 1) {
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

        Database::iud("UPDATE `customer_table` SET `reset_token` = '$token', `token_expiry` = '$expiry' WHERE `customer_email` = '$email'");

        $resetLink = "http://localhost/san/resetPassword.php?token=$token";

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'sahirumejitha123@gmail.com';
            $mail->Password   = 'mwks ymdk awxr glsp';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('sahirumejitha123@gmail.com', 'Thusitha Engineering');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Click the link to reset your password:<br><a href='$resetLink'>$resetLink</a><br>This link will expire in 1 hour.";

            $mail->send();
            echo '<div class="success-message">Check your email for the password reset link.</div>';
        } catch (Exception $e) {
            echo "Failed to send email. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found in our records.";
    }
} else {
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
       <link href='https://fonts.googleapis.com/css?family=Bayon' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            padding-top: 90px;
        }

        header {
            background-color: #FF9400;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            height: 50px;
        }

        nav ul {
            list-style: none;
            display: flex;
            padding: 0;
        }

        nav ul li {
            margin: 0 40px;
            position: relative;
        }

        nav ul li a {
            text-decoration: none;
            color: black;
            position: relative;
            padding-bottom: 5px;
            font-size: 25px;
            font-family: 'Inter';
        }

        nav ul li a::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 2px;
            background-color: #000000;
            transition: all 0.3s ease-out;
            transform: translateX(-50%);
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        .user-cart img {
            width: 50px;
            margin-left: 10px;
        }

        .hero {
            background: url('assets/homePageCoverPhoto.webp') no-repeat center center/cover;
            height: 100vh;
            position: relative;
        }

        .login-box {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.8);
            padding: 60px;
            width: 300px;
            text-align: center;
            align-items: center;
        }

        .fpw{
            color: white;
            margin-bottom: 8px;
            text-align: justify;
            font-size: 36px;
            margin-left: -15px;
            font-family: 'Bayon';
        }

        .login-box input {
            width: 250px;
            height: 50px;
            background: #C4C4C4;
            font-size: 25px;
            margin-left: -75px;
            font-family: 'Bayon';
            margin-bottom: -20px;
        }

        .login-btn {
            margin-top: 80px;
            font-family: 'Bayon';
            background: transparent;
            color: rgb(255, 255, 255);
            border: 2px solid #ffffff;
            padding: 10px;
            width: 80%;
            height: 50px;
            cursor: pointer;
            font-size: 35px;
            text-align: left;
            display: block;
            margin-left: -20px;
            position: relative;
            overflow: hidden;
            transition: color 0.3s ease;
            line-height: 35px;
            outline: none;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background-color: #FF9400;
            transition: left 0.3s ease;
            z-index: -1;
        }

        .login-btn:hover::before {
            left: 0;
        }

        .login-btn:hover {
            color: rgb(0, 0, 0);
        }

        .login-box p {
            color: white;
            margin-top: 5px;
            text-align: left;
            font-size: 24px;
            margin-left: -15px;
            font-family: 'Bayon';
        }

        .login-box a {
            color: #F39200;
            text-decoration: none;

        }
        .success-message {
    background-color: #dff0d8;
    color: #3c763d;
    font-size: 20px;
    font-family: 'Bayon';
    padding: 15px;
    margin-top: 20px;
    margin-bottom: -10px;
    border: 1px solid #d6e9c6;
    border-radius: 8px;
    text-align: center;
    width: 100%;
}

        
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="assets/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">About</a></li>
            </ul>
        </nav>
        <div class="user-cart">
            <img src="assets/user-icon.png" alt="User">
            <img src="assets/cart-icon.png" alt="Cart">
        </div>
    </header>

    <div class="hero">
        <div class="login-box">
            <div class="fpw">Forgot Password</div>
            <form method="POST" action="">
                <input type="email" name="email" placeholder="Enter your email" required>
                <button class="login-btn" type="submit">Send Reset Link</button>
            </form>
            <p><a href="login.php">Back to Login</a></p>
        </div>
    </div>
</body>
</html>

<?php } ?>
