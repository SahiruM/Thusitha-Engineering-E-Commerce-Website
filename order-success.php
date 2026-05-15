<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thusitha Engineering | Order Success</title>
    <link href="https://fonts.googleapis.com/css?family=Bayon" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="header.css" />
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="order-success.css">
</head>
<body>
<?php
session_start();
require "connection.php";
include "header.php";
?>

<main class="success-page">
    <section class="success-box">
        <span>Order received</span>
        <h1>Order placed successfully.</h1>
        <p>Thank you for your purchase. Your order has been confirmed and will be processed shortly.</p>
        <a href="index.php" class="home-btn">Return to Home</a>
    </section>
</main>

<?php include "footer.php"; ?>
</body>
</html>
