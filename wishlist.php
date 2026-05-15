<?php
session_start();

if (!isset($_SESSION["user2"]["id"])) {
    header("Location: login.php");
    exit();
}

$userid = (int)$_SESSION["user2"]["id"];
require "connection.php";
require "product_image_helper.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Thusitha Engineering | Wishlist</title>
  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="footer.css">
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css?family=Bayon&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet">
</head>
<body>
<?php include "header.php"; ?>

<main>
  <section class="shop-hero">
    <div>
      <span class="eyebrow">Saved tools</span>
      <h1>Your wishlist.</h1>
      <p>Keep track of tools you want to compare, review, or purchase later.</p>
    </div>
  </section>

  <section class="products">
    <div class="shop-toolbar">
      <div>
        <span class="eyebrow">Saved products</span>
        <h2>Wishlist</h2>
      </div>
    </div>

    <div class="product-grid" id="wishlistContainer">
      <?php
      $products = Database::select(
        "SELECT * FROM `wishlist`
         INNER JOIN `product` ON `wishlist`.`product_product_id` = `product`.`product_id`
         WHERE `wishlist`.`user_id` = ?",
        "i",
        $userid
      );

      if ($products->num_rows === 0) {
        echo "<p>Your wishlist is empty.</p>";
      }

      while ($product = $products->fetch_assoc()) {
        $productId = (int)$product['product_id'];
        $review_rs = Database::select(
          "SELECT FLOOR(AVG(`review_value`)) AS average_review FROM `reviews` WHERE `product_product_id` = ? AND `user_id` = ?",
          "ii",
          $productId,
          $userid
        );
        $rew = $review_rs->fetch_assoc();
        $rating = (int)($rew["average_review"] ?? 0);
      ?>
        <article class="product">
          <div class="product-image">
            <img src="<?php echo htmlspecialchars(productImageFor($product)); ?>" alt="<?php echo htmlspecialchars($product["product_name"]); ?>" loading="lazy">
          </div>
          <div class="product-info">
            <h3><?php echo htmlspecialchars($product["product_name"]); ?></h3>
            <p class="price">Rs. <?php echo number_format((float)$product["price"], 2); ?></p>
            <div class="rating" aria-label="<?php echo $rating; ?> out of 5 rating">
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="<?php echo $i <= $rating ? 'filled' : ''; ?>" onclick="rateHeart(this, <?php echo $i; ?>, <?php echo $productId; ?>)">&hearts;</span>
              <?php endfor; ?>
            </div>
            <div class="product-actions">
              <button class="add-to-cart" onclick="addToCart(<?php echo $productId; ?>)">Add to Cart</button>
              <button class="add-to-wishlist" onclick="removeItem(<?php echo (int)$product['wish_id']; ?>)">Remove</button>
            </div>
          </div>
        </article>
      <?php
      }
      ?>
    </div>
  </section>
</main>

<?php include "footer.php"; ?>
<script src="script.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
