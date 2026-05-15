<?php
require "connection.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thusitha Engineering | About Us</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Bayon" rel="stylesheet">
  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="footer.css">
  <link rel="stylesheet" href="styles1.css">
</head>
<body>
<?php include "header.php"; ?>

<main>
  <section class="page-hero about-hero">
    <div>
      <span class="eyebrow">About Thusitha Engineering</span>
      <h1>Local tool support for practical work.</h1>
      <p>We supply reliable tools and engineering essentials for workshops, job sites, and home builders around Batapola and beyond.</p>
    </div>
  </section>

  <section class="content-section">
    <article class="content-panel">
      <h2>Welcome to Our Store</h2>
      <p>Thusitha Engineering is your local source for quality tools, accessories, and practical product support. We help customers choose the right tool for the job, not just the most expensive one.</p>
    </article>

    <article class="content-panel">
      <h2>What We Stand For</h2>
      <p>We believe in honesty, customer-first service, affordable pricing, and clear communication from product selection to after-sales support.</p>
    </article>

    <div class="value-grid">
      <article><strong>Fast</strong><span>Order handling</span></article>
      <article><strong>Reliable</strong><span>Product support</span></article>
      <article><strong>Clear</strong><span>Local guidance</span></article>
      <article><strong>Secure</strong><span>Checkout flow</span></article>
    </div>

    <article class="content-panel">
      <h2>Connect With Us</h2>
      <p>Visit our <a href="contact.php">Contact Page</a> or drop by our physical location in Batapola, Galle Road. We are here to help you find the right tool.</p>
    </article>
  </section>
</main>

<?php include "footer.php"; ?>
</body>
</html>
