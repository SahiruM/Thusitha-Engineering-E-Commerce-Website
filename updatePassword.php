<?php
require "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the token and new password from the form
    $token = $_POST["token"] ?? "";
    $newPassword = $_POST["new_password"] ?? "";

    if ($token === "" || strlen($newPassword) < 8) {
        echo "Invalid token or password is too short.";
        exit();
    }

    // Get user data based on the token
    $result = Database::select("SELECT * FROM `customer_table` WHERE `reset_token` = ?", "s", $token);

    if ($result->num_rows == 1) {
        // Token is valid, proceed with updating password
        $user = $result->fetch_assoc();
        
        // Check if the token has expired
        $currentTime = date("Y-m-d H:i:s");
        if ($currentTime > $user["token_expiry"]) {
            echo "❌ Invalid or expired token.";
        } else {
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            Database::execute(
                "UPDATE `customer_table` SET `customer_password` = ?, `reset_token` = NULL, `token_expiry` = NULL WHERE `reset_token` = ?",
                "ss",
                $passwordHash,
                $token
            );
            Database::execute("UPDATE `user` SET `password` = ? WHERE `email` = ?", "ss", $passwordHash, $user["customer_email"]);

            echo "✅ Password updated successfully.";
        }
    } else {
        echo "❌ Invalid or expired token.";
    }
} else {
    // Show reset password form (for the sake of example)
    $token = $_GET["token"];
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password</title>
        <link href="https://fonts.googleapis.com/css?family=Bayon" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
        <link rel="stylesheet" href="resetPasswordStyles.css">
    </head>
    <body>
        <!-- Header -->
        <header>
            <div class="logo">
                <img src="assets/Logo.jpg" alt="Logo">
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="shop.php">SHOP</a></li>
                    <li><a href="contact.php">CONTACT</a></li>
                    <li><a href="about.php">ABOUT</a></li>
                </ul>
            </nav>
            <div class="user-cart">
                <a href="cart.php"><img src="assets/cart.png" alt="Cart" required></a>
                <a href="profile.php"><img src="assets/user.png" alt="User" required></a>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero">
            <div class="overlay">
                <div class="reset-box">
                    <h2>Enter your new password</h2>
                    <form method="POST" action="updatePassword.php">
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <input type="password" name="new_password" placeholder="New Password" required>
                        <button type="submit">Update Password</button>
                    </form>
                </div>
            </div>
        </section>
    </body>
    </html>
<?php
}
?>
