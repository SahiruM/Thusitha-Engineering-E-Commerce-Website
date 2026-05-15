<?php
require "connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Thusitha Engineering | Shop</title>
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="footer.css">
  <link href="https://fonts.googleapis.com/css?family=Bayon" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
</head>

<body>
<?php include "header.php"; ?>

<main>
  <section class="shop-hero">
    <div>
      <span class="eyebrow">Tool catalog</span>
      <h1>Shop reliable tools for every job.</h1>
      <p>Browse current stock, compare prices, and add products to your cart or wishlist.</p>
    </div>
  </section>

  <section class="products">
    <div class="shop-toolbar">
      <div>
        <span class="eyebrow">All products</span>
        <h2>Our Products</h2>
      </div>
      <form action="download_report.php" method="post">
        <button type="submit" class="report-btn">Download Ratings Report</button>
      </form>
    </div>

    <div class="product-grid">
      <?php
      $products = Database::search("SELECT * FROM product");
      while ($product = $products->fetch_assoc()) {
        $productId = (int)$product['product_id'];
        $stock = (int)$product["stock"];
        $review_rs = Database::select(
          "SELECT FLOOR(AVG(review_value)) AS average_review FROM reviews WHERE product_product_id = ?",
          "i",
          $productId
        );
        $rew = $review_rs->fetch_assoc();
        $rating = (int)($rew["average_review"] ?? 0);
      ?>
        <article class="product">
          <div class="product-image">
            <img src="<?php echo htmlspecialchars($product["img"]); ?>" alt="<?php echo htmlspecialchars($product["product_name"]); ?>" loading="lazy" />
          </div>
          <div class="product-info">
            <div class="product-topline">
              <?php if ($stock === 0): ?>
                <span class="status-badge out-stock">Out of Stock</span>
              <?php else: ?>
                <span class="status-badge in-stock">In Stock</span>
              <?php endif; ?>
            </div>

            <h3><?php echo htmlspecialchars($product["product_name"]); ?></h3>
            <p class="price">Rs. <?php echo number_format((float)$product["price"], 2); ?></p>

            <div class="rating" aria-label="<?php echo $rating; ?> out of 5 rating">
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="<?php echo $i <= $rating ? 'filled' : ''; ?>">&hearts;</span>
              <?php endfor; ?>
            </div>

            <div class="product-actions">
              <button class="add-to-cart" <?php echo $stock > 0 ? 'onclick="addToCart(' . $productId . ')"' : 'disabled'; ?>>Add to Cart</button>
              <button class="add-to-wishlist" onclick="addToWishList(<?php echo $productId; ?>)">Wishlist</button>
            </div>
          </div>
        </article>
      <?php
      }
      ?>
    </div>
  </section>
</main>

<script>
  document.querySelectorAll(".add-to-wishlist").forEach(button => {
    button.addEventListener("click", () => {
      if (!<?php echo isset($_SESSION["user"]) ? 'true' : 'false'; ?>) {
        alert("You need to log in first!");
        window.location.href = "login.php";
      } else {
        alert("Added to wishlist!");
      }
    });
  });

  document.querySelectorAll(".add-to-cart").forEach(button => {
    button.addEventListener("click", () => {
      if (!<?php echo isset($_SESSION["user"]) ? 'true' : 'false'; ?>) {
        alert("You need to log in first!");
        window.location.href = "login.php";
      } else {
        alert("Added to cart!");
      }
    });
  });
</script>

<script src="script.js"></script>
<?php include "footer.php"; ?>
</body>
</html>
