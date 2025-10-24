<?php
require "connection.php";
session_start(); // Start session to track user status
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
  <link href='https://fonts.googleapis.com/css?family=Bayon' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
  


</head>

<body style="overflow-x:hidden">

<?php 
  include "header.php";
?>

  <section class="banner">
    <h1>THE WORLD IN YOUR HANDS</h1>
  </section>

  <section class="products">
  <h2>OUR PRODUCTS</h2>
  <div class="product-grid">
    <?php
    $products = Database::search("SELECT * FROM product");
    while ($product = $products->fetch_assoc()) {
    ?>
      <div class="product">
        <img src="<?php echo ($product["img"]) ?>" alt="Product" />
        <p><strong><?php echo ($product["product_name"]) ?></strong></p> <br>
        <?php
          if($product["stock"]==0){
        ?>
          <td><span class="status-badge out-stock">Out of Stock</span></td>
        <?php
          } else {
        ?>
          <td><span class="status-badge in-stock">In Stock</span></td>
        <?php
          }
        ?>
        <p class="price">Rs. <?php echo ($product["price"]) ?>.00</p>
        <button class="add-to-cart"
          <?php
          if($product['stock']>0){
          ?>
            onclick="addToCart(<?php echo ($product['product_id']) ?>)"
          <?php 
          }
          ?>>Add to Cart</button>
        <button class="add-to-wishlist" onclick="addToWishList(<?php echo ($product['product_id']) ?>)">Add to Wishlist</button>
        <!-- ⭐ Rating hearts -->
        <div class="rating">
          <?php
          $review_rs = Database::search("SELECT FLOOR(AVG(review_value)) AS average_review
              FROM reviews
              WHERE product_product_id = '".$product["product_id"]."'
              ");
          $rew = $review_rs->fetch_assoc();
          $red_count = $rew["average_review"];
          $gray_count = 5 - $rew["average_review"];
          for ($i=1; $i <= $red_count; $i++) { 
          ?>
            <i class="filled">❤</i>
          <?php
          }
          for ($j=$red_count+1; $j <= $red_count+$gray_count; $j++) { 
          ?>
            <i>❤</i>
          <?php
          }
          ?>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
</section>
  
  <div style="text-align: center; margin: 20px;">
    <form action="download_report.php" method="post">
        <button type="submit" style="background: linear-gradient(to right, #00c853, #00e676); color: white; padding: 12px 24px; font-size: 18px; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; box-shadow: 0 4px 10px rgba(0, 230, 118, 0.4); transition: background 0.3s ease;">Download Ratings Report</button>
    </form>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


  <script>
    function goToCategory(selectElement) {
      const value = selectElement.value;
      if (value) {
        window.location.href = value;
      }
    }

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

  <?php 
        include "footer.php";
    ?>

</body>
</html>
