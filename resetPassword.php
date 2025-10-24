<?php
require "connection.php";
session_start();

if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];

    $result = Database::search("SELECT * FROM `customer_table` WHERE `reset_token` = '$token'");

    if ($result->num_rows == 0) {
        echo "<div class='error-message'>❌ No user found with this token.</div>";
        exit;
    }

    $user = $result->fetch_assoc();
    $expiry = $user["token_expiry"];

    if (strtotime($expiry) > time()) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Reset Password</title>
                <link href='https://fonts.googleapis.com/css?family=Bayon' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    padding-top: 90px;
                    background-color: #f5f5f5;
                }

                .login-box {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: rgba(0, 0, 0, 0.8);
                    padding: 60px;
                    width: 320px;
                    text-align: center;
                    border-radius: 10px;
                }

                .login-box h2 {
                    color: white;
                    font-size: 28px;
                    font-family: 'Bayon';
                    margin-bottom: 30px;
                }

                .login-box label {
                    color: #fff;
                    font-size: 20px;
                    font-family: 'Bayon';
                    text-align: left;
                    display: block;
                    margin-bottom: 10px;
                }

                .login-box input[type="password"] {
                    width: 100%;
                    height: 45px;
                    background: #C4C4C4;
                    font-size: 18px;
                    font-family: 'Bayon';
                    margin-bottom: 25px;
                    border: none;
                    padding: 0 10px;
                }

                .login-btn {
                    font-family: 'Bayon';
                    background: transparent;
                    color: #fff;
                    border: 2px solid #ffffff;
                    padding: 10px;
                    width: 100%;
                    height: 50px;
                    cursor: pointer;
                    font-size: 24px;
                    position: relative;
                    overflow: hidden;
                    transition: color 0.3s ease;
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
                    color: black;
                }

                .error-message {
                    text-align: center;
                    padding: 20px;
                    color: white;
                    background-color: #ff4d4d;
                    font-family: 'Bayon';
                    font-size: 20px;
                    margin: 30px auto;
                    width: fit-content;
                    border-radius: 8px;
                }
            </style>
        </head>
        <body>
            <div class="login-box">
                <h2>Reset Password</h2>
                <form action="updatePassword.php" method="POST">
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <label>New Password:</label>
                    <input type="password" name="new_password" required>
                    <button class="login-btn" type="submit">Update Password</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<div class='error-message'>❌ Token has expired.</div>";
    }

} else {
    echo "<div class='error-message'>❌ Token missing from the URL.</div>";
}
?>
