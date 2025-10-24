<?php 
  require "connection.php";
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Thusitha Engineering | About Us</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="footer.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
      background-color: #131c1d;
      color: #ffffff;
    }

    .header-box {
      text-align: center;
      padding: 40px 20px;
      border: 2px solid #ffa726;
      margin: 30px auto 20px auto;
      width: 90%;
      max-width: 900px;
      border-radius: 12px;
      background-color: #252e2f;
      box-shadow: 0 0 10px #ffa726;
    }

    .header-box h1 {
      color: #ffa726;
      font-size: 36px;
      margin: 0;
    }

    .about-section {
      max-width: 1000px;
      margin: auto;
      padding: 20px 40px;
      line-height: 1.8;
      background-color: #1a2223;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(255, 167, 38, 0.3);
    }

    .about-section h2 {
      color: #ffa726;
      margin-top: 0;
    }

    .about-section p {
      color: #ddd;
      font-size: 16px;
    }

    .highlight {
      color: #ffa726;
      font-weight: 600;
    }

    @media (max-width: 600px) {
      .about-section {
        padding: 20px;
      }

      .header-box h1 {
        font-size: 28px;
      }
    }
  </style>
</head>
<body>

  <?php include "header.php"; ?>

  <div class="header-box">
    <h1>About Us</h1>
  </div>

  <div class="about-section">
    <h2>Welcome to Our Store</h2>
    <p>
      Welcome to Thusitha Engineering, your go-to store for genuine INGCO tools at the best prices! We offer high-quality power tools, hand tools, and accessories to help you tackle any project with ease. With fast shipping, secure payments, and excellent customer service, we ensure a hassle-free shopping experience.
      Power up your work with INGCO – Shop with us today!
    </p>

    <h2>What We Stand For</h2>
    <p>
      We believe in <span class="highlight">honesty</span>, <span class="highlight">customer-first service</span>, and <span class="highlight">affordable pricing</span>. Our team is dedicated to sourcing only the best items and delivering them to you with care. Whether you're shopping for daily needs or special gifts, we ensure that each item meets your expectations.
    </p>

    <h2>Our Commitment</h2>
    <p>
      ✔ Fast Delivery<br>
      ✔ Reliable Support<br>
      ✔ Easy Returns<br>
      ✔ Secure Payments
    </p>

    <h2>Connect With Us</h2>
    <p>
      Want to know more? Visit our <a href="contact.php" style="color: #ffa726;">Contact Page</a> or drop by our physical location in Batapola, Galle Road. We're here to help you 24/7.
    </p>
  </div>
  <br>
  <?php include "footer.php"; ?>

</body>
</html>