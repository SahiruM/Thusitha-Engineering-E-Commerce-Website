<?php
        session_start();
        $userid=$_SESSION["user2"]["id"];
        require "connection.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Thusitha Engineering | Wishlist</title>
  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Bayon&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet">
  <style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #1C2526;
    color: white;
  }

  .navbar {
    background-color: orange;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px 30px;
    flex-wrap: wrap;
  }

  .navbar .logo {
    display: none;
  }

  .navbar .nav-links {
    display: flex;
    gap: 30px;
  }

  .navbar .nav-links a {
    color: black;
    text-decoration: none;
    font-weight: bold;
  }

  .navbar .nav-links a:hover {
    text-decoration: underline;
  }

  h1 {
    text-align: center;
    margin-top: 30px;
    font-size: 2rem;
  }

  .wishlist-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    padding: 30px;
    justify-items: center;
  }

  .product {
    background-color: white;
    color: black;
    border-radius: 12px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
    transition: transform 0.3s;
    width: 250px;
    height: 370px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .product:hover {
    transform: scale(1.03);
  }

  .product img {
    width: 100%;
    height: auto;
    max-height: 150px;
    object-fit: contain;
    border-radius: 10px;
  }

  .product-name {
    font-weight: bold;
    margin: 15px 0 10px;
  }

  .product-price {
    color: red;
    font-weight: bold;
    margin-bottom: 10px;
  }

  .action-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: auto;
  }

  .btn {
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
  }

  .btn-cart {
    background-color: #ffa500;
  }

  .btn-cart:hover {
    background-color: #ff8c00;
  }

  .btn-remove {
    background-color: #dc143c;
    color: white;
  }

  .btn-remove:hover {
    background-color: #b22222;
  }

  /* ❤️ Rating Hearts */
  .rating {
    display: flex;
    justify-content: center;
    margin-top: 10px;
  }

  .rating i {
    font-style: normal;
    font-size: 22px;
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s ease;
    margin: 0 2px;
  }

  .rating i.filled {
    color: #ff4d4d;
  }

  .rating2 {
    display: flex;
    justify-content: center;
    margin-top: 10px;
  }

  .rating2 i {
    font-style: normal;
    font-size: 22px;
    color: #ccc;
    cursor: pointer;
    transition: color 0.2s ease;
    margin: 0 2px;
  }

  .rating2 i.filled {
    color: #ff4d4d;
  }
  </style>

</head>
<body>
<?php include "header.php"; ?>



  <h1>🧡 My Wishlist</h1>

  <div class="wishlist-container" id="wishlistContainer">

    <!-- ✅ PHP and DB Logic -->
    <?php
      

      $products = Database::search("SELECT * FROM `wishlist`
        INNER JOIN `product` ON `wishlist`.`product_product_id` = `product`.`product_id` 
        WHERE `wishlist`.`user_id`='$userid'");

      while($product = $products->fetch_assoc()) {
    ?>
      <div class="product">
        <img src="<?php echo($product["img"]) ?>" alt="Product">
        <p class="product-name"><?php echo($product["product_name"]) ?></p>
        <p class="product-price">Rs. <?php echo number_format($product["price"], 2) ?></p>
        <div class="action-buttons">
          <button class="btn btn-cart">Add to Cart</button>
          <button class="btn btn-remove" onclick="removeItem(<?php echo($product['wish_id']) ?>)">Remove from Wishlist</button>
        </div>
        <!-- ⭐ Rating Hearts -->

        

        <div class="rating">
        <?php
    


          $review_rs = Database::search("SELECT FLOOR(AVG(`review_value`)) AS average_review
            FROM `reviews`
            WHERE `product_product_id` = '".$product["product_id"]."' AND `user_id` = '$userid'
            ");

          $rew = $review_rs->fetch_assoc();

          $red_count = $rew["average_review"];
          $gray_count = 5 - $rew["average_review"];

          for ($i=1; $i <= $red_count; $i++) { 
          ?>
          <i class="filled" onclick="rateHeart(this, <?php echo($i) ?>,<?php echo($product['product_id']) ?>)" >&#10084;</i>
          <?php
          }

          for ($j=$red_count+1; $j <= $red_count+$gray_count; $j++) { 
            ?>
          <i onclick="rateHeart(this, <?php echo($j) ?>,<?php echo($product['product_id']) ?>)"  >&#10084;</i>
          <?php
          }
         ?>

        </div>
      </div>
    <?php
      }
    ?>

  </div>
  <?php include "footer.php"; ?>

  <script>
    function goToCategory(selectElement) {
      const value = selectElement.value;
      if (value) {
        window.location.href = value;
      }
    }

  

    
  </script>

  <script src="script.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>
</html>
