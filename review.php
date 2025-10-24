<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reviews - Tool Store</title>
  <link rel="stylesheet" href="styles.css" />

  <style>
    body {
      background: black;
      color: white;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .review-section {
      padding: 40px 20px;
      text-align: center;
    }

    .review-section h2 {
      font-size: 32px;
      margin-bottom: 30px;
    }

    .review-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 25px;
      padding: 0 30px;
    }

    .review-card {
      background: white;
      color: black;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 8px 16px rgba(255, 255, 255, 0.1);
      text-align: left;
    }

    .review-card h3 {
      margin-top: 0;
      color: #ff5722;
    }

    .review-card p {
      font-size: 16px;
      line-height: 1.5;
    }

    nav {
      background: #ffa500;
      padding: 20px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 25px;
    }

    .nav-links li a {
      text-decoration: none;
      color: black;
      font-weight: bold;
      padding: 8px 12px;
      border-radius: 5px;
    }

    .nav-links li a:hover {
      background: rgba(0, 0, 0, 0.1);
    }

    .logo img {
      height: 40px;
    }
  </style>
</head>

<body>
  <nav>
    <div class="logo"><img src="logo.png" alt="Logo" /></div>
    <ul class="nav-links">
      <li><a href="index.html">HOME</a></li>
      <li><a href="#">SHOP</a></li>
      <li><a href="#">CONTACT</a></li>
      <li><a href="#">ABOUT</a></li>
      <li><a href="wishlist.php">WISHLIST</a></li>
    </ul>
  </nav>

  <section class="review-section">
    <h2>Customer Reviews</h2>
    <div class="review-grid">

      <?php
        require "connection.php";
        $result = Database::search("SELECT * FROM `comments` INNER JOIN `user` ON `comments`.`user_id` = `user`.`id`");
        while($row = $result->fetch_assoc()) {
      ?>
        <div class="review-card">
          <h3 ><?php echo htmlspecialchars($row['name']); ?></h3>
          <p><?php echo htmlspecialchars($row['msg']); ?></p>
        </div>
      <?php } ?>

    </div>
  </section>
</body>
</html>
