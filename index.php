<?php
session_start();
require "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Thusitha Engineering | Tools & Hardware Store</title>
  <link rel="stylesheet" href="indexstyles.css" />
  <link href="https://fonts.googleapis.com/css?family=Bayon" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="footer.css">
</head>
<body>
<?php include "header.php"; ?>

<main>
  <section class="hero">
    <div class="hero-content">
      <span class="eyebrow">Batapola hardware and engineering supply</span>
      <h1>Professional tools for serious work.</h1>
      <p>Shop reliable power tools, hand tools, compressors, and water pumps for workshops, job sites, and home projects.</p>
      <div class="hero-actions">
        <a href="shop.php" class="btn primary-btn">Shop Products</a>
        <a href="contact.php" class="btn secondary-btn">Ask for Support</a>
      </div>
    </div>

    <div class="hero-panel" aria-label="Store highlights">
      <div>
        <strong>25+</strong>
        <span>Tool lines</span>
      </div>
      <div>
        <strong>Local</strong>
        <span>Galle support</span>
      </div>
      <div>
        <strong>Fast</strong>
        <span>Order handling</span>
      </div>
    </div>
  </section>

  <section class="category-strip" aria-label="Popular categories">
    <a href="shop.php">Power Tools</a>
    <a href="shop.php">Hand Tools</a>
    <a href="shop.php">Compressors</a>
    <a href="shop.php">Water Pumps</a>
  </section>

  <section class="featured-products" id="products">
    <div class="section-heading">
      <span class="eyebrow">Available now</span>
      <h2>Featured Products</h2>
      <a href="shop.php">View all products</a>
    </div>

    <div class="product-grid">
      <?php
      $products = Database::search("SELECT * FROM product LIMIT 5");
      while ($product = $products->fetch_assoc()) {
      ?>
        <article class="product-card">
          <img src="<?php echo htmlspecialchars($product["img"]); ?>" alt="<?php echo htmlspecialchars($product["product_name"]); ?>" loading="lazy" />
          <div class="product-card-body">
            <h3><?php echo htmlspecialchars($product["product_name"]); ?></h3>
            <span>Rs. <?php echo number_format((float)$product["price"], 2); ?></span>
          </div>
        </article>
      <?php
      }
      ?>
    </div>
  </section>

  <section class="trust-section">
    <div>
      <span class="eyebrow">Why customers come back</span>
      <h2>Built around practical tool buying.</h2>
    </div>
    <div class="trust-grid">
      <article>
        <i class="fas fa-screwdriver-wrench" aria-hidden="true"></i>
        <h3>Workshop-ready range</h3>
        <p>Browse tools by real job needs, from drilling and polishing to pumping and air compression.</p>
      </article>
      <article>
        <i class="fas fa-boxes-stacked" aria-hidden="true"></i>
        <h3>Stock visibility</h3>
        <p>Product cards show availability clearly so customers know what can be ordered.</p>
      </article>
      <article>
        <i class="fas fa-headset" aria-hidden="true"></i>
        <h3>Direct local contact</h3>
        <p>Customers can reach the store quickly for product questions before checkout.</p>
      </article>
    </div>
  </section>

  <section class="testimonials">
    <div class="section-heading">
      <span class="eyebrow">Customer voice</span>
      <h2>Recent Feedback</h2>
    </div>
    <div class="testimonial-grid">
      <?php
      $comment_rs = Database::search("
        SELECT comments.msg, user.name
        FROM comments
        INNER JOIN user ON comments.user_id = user.id
        ORDER BY comments_id DESC
        LIMIT 5
      ");

      if ($comment_rs->num_rows > 0) {
        while ($comment = $comment_rs->fetch_assoc()) {
      ?>
          <article class="testimonial">
            <p>&ldquo;<?php echo htmlspecialchars($comment['msg']); ?>&rdquo;</p>
            <span><?php echo htmlspecialchars($comment['name']); ?></span>
          </article>
      <?php
        }
      } else {
        echo "<p class='empty-state'>No feedback available yet.</p>";
      }
      ?>
    </div>
  </section>
</main>

<?php include "footer.php"; ?>
<script src="script.js"></script>
</body>
</html>
