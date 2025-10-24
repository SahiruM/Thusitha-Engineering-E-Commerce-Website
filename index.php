<?php
    session_start();
    require "connection.php";
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ProTools Hardware Store</title>
  <link rel="stylesheet" href="indexstyles.css" />
  <link href='https://fonts.googleapis.com/css?family=Bayon' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="header.css" />
    <link rel="stylesheet" href="footer.css">
</head>
<body>
<?php include "header.php"; ?>

  <!-- Hero Section with Background Slideshow -->
<section class="hero">
  <div class="slideshow-background">
    <div class="bg-slide" style="background-image: url('https://www.ingco.com/website-center/upload/images/4236ffd447054522b3690d3417691967.webp');"></div>
    <div class="bg-slide" style="background-image: url('https://res-sg.rdmcenter.com/stc/website-center/upload/ingco/Philippines-INGCO-Website/images/HOME%20PAGE%20-%20TOOLS%20DESIGNATION%20SLIDE%20BANNER-12.jpg');"></div>
    <div class="bg-slide" style="background-image: url('https://res-sg.togroup.com/stc/website-center/files/upload/Philippines-INGCO-Website/MEASURING%20TOOLS.jpg');"></div>
    <div class="bg-slide" style="background-image: url('https://res-sg.togroup.com/stc/website-center/files/upload/Philippines-INGCO-Website/GENERATOR.jpg');"></div>
    <div class="bg-slide" style="background-image: url('https://res-sg.togroup.com/stc/website-center/files/upload/Philippines-INGCO-Website/66d29fa3d6a14d6b825bd99d73a335db/Welding%20Machine.jpg');"></div>
  </div>
  <div class="hero-content">
    <h1>Professional Tools Made Affordable</h1>
    <p>Discover a wide range of high-quality tools for every project.</p>
    <a href="shop.php" class="btn">Shop Now</a>
  </div>
</section>



  <!-- Featured Products -->
  <section class="featured-products" id="products">
    <h2>Featured Products</h2>
    <div class="product-grid">
    <?php
    $products = Database::search("SELECT * FROM product LIMIT 5");
    while ($product = $products->fetch_assoc()) {
    ?>
      <div class="product-card">
      <img src="<?php echo ($product["img"]) ?>" alt="Product" />        
        <h3><?php echo ($product["product_name"]) ?></h3>
        <span>Rs. <?php echo ($product["price"]) ?></span>
      </div>
      <?php
    }
    ?> 
    </div>
  </section>

  <!-- Customer Feedback -->
<section class="testimonials">
  <h2>Customer Feedback</h2>
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
        <div class="testimonial">
          <p>"<?php echo htmlspecialchars($comment['msg']); ?>"</p>
          <span>- <?php echo htmlspecialchars($comment['name']); ?></span>
        </div>
        <?php
      }
    } else {
      echo "<p style='color: #aaa;'>No feedback available yet.</p>";
    }
    ?>
  </div>
</section>

<?php include "footer.php"; ?>
<script src="script.js"></script>
<script>
let slides = document.querySelectorAll('.bg-slide');
let current = 0;

function cycleSlides() {
  slides.forEach((slide, index) => {
    slide.classList.remove('active');
  });

  slides[current].classList.add('active');
  current = (current + 1) % slides.length;

  setTimeout(cycleSlides, 5000);
}

cycleSlides();
</script>




</body>
</html>
