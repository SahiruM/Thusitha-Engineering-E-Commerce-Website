<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - INGCO</title>
    <link href='https://fonts.googleapis.com/css?family=Bayon' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="order-success.css">
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
            <a href="cart.php"><img src="assets/cart.png" alt="Cart"></a>
            <a href="profile.php"><img src="assets/user.png" alt="User"></a>
        </div>
    </header>
    <div style="text-align: center; margin-bottom: 20px;">
  <form action="generateRecentSignupReport.php" method="post" target="_blank">
    <button class="action-btn" type="submit">🕒 Recent Signups Report</button>
  </form>
</div>

    <section class="hero">
        <div class="overlay">
            
            <div class="checkout-box">
                <div class="checkout-content">
                    <div class="success-container">
                        <div class="success-box">
                            <h1>Order Placed Successfully!</h1>
                            <p>Thank you for your purchase. Your order has been confirmed, and we will process it shortly.</p>
                            <a href="index.php" class="home-btn">Return to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
