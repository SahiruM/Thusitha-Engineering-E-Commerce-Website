<?php 
require "connection.php";
session_start();

if (!isset($_SESSION["user2"]["id"])) {
    header("Location: login.php");
    exit();
}

$userid = $_SESSION["user2"]["id"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thusitha Engineering | Cart</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css?family=Bayon|Inter&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <!-- Custom Styles -->
  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="footer.css" />
  
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #1C2526;
      font-family: 'Inter', sans-serif;
      color: #333;
    }

    h1 {
      text-align: center;
      margin-top: 30px;
      color: #fff;
    }

    .cart-container {
      margin: 30px auto;
      width: 90%;
      max-width: 1200px;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    thead {
      background-color: #ff9800;
      color: white;
    }

    th, td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    button {
      background-color: transparent;
      color: #ff9800;
      border: none;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      color: red;
      text-decoration: underline;
    }

    .cart-total {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 20px;
      font-size: 18px;
      margin-top: 20px;
    }

    .cart-total h3 {
      margin: 0;
    }

    .cart-total a {
      padding: 10px 25px;
      background-color: #ff9800;
      color: #fff;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .cart-total a:hover {
      background-color: #ffd000;
      color: #000;
    }

    .download-btn-container {
      text-align: center;
      margin: 20px;
    }

    .download-btn {
      background: linear-gradient(to right, #ff9800, #ffc107);
      color: white;
      padding: 12px 24px;
      font-size: 18px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
      box-shadow: 0 4px 10px rgba(255, 152, 0, 0.4);
      transition: background 0.3s ease;
    }

    .download-btn:hover {
      background: #ffb300;
    }
    .hero {
    text-align: center;
    padding: 4rem;
    background: url('./assets/background_pic.jpg') no-repeat center center/cover;
    color: white;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    border: 5px solid #000;
}
  </style>
</head>

<body>


  <?php include "header.php"; ?>
    <section class="hero"></section>


  <h1>Your Cart</h1>

  <div class="cart-container">
    <table>
      <thead>
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $cartRs = Database::search("
          SELECT * FROM cart 
          INNER JOIN cart_item ON cart.cart_id = cart_item.cart_cart_id 
          INNER JOIN product ON product.product_id = cart_item.product_product_id
          WHERE cart.user_id = '$userid'
        ");

        if ($cartRs->num_rows > 0) {
          $finalTot = 0;
          while ($cartData = $cartRs->fetch_assoc()) {
            $tot = $cartData["price"] * $cartData["quantity"];
            $finalTot += $tot;
        ?>
            <tr>
              <td><?= htmlspecialchars($cartData["product_name"]) ?></td>
              <td>Rs.<?= number_format($cartData["price"], 2) ?></td>
              <td><?= (int)$cartData["quantity"] ?></td>
              <td>Rs.<?= number_format($tot, 2) ?></td>
              <td>
                <button onclick="remove_item(<?= (int)$cartData['cart_item_id'] ?>)">Remove</button>
              </td>
            </tr>
        <?php
          }
        } else {
          echo "<tr><td colspan='5'>Your cart is empty.</td></tr>";
        }
        ?>
      </tbody>
    </table>

    <?php if ($cartRs->num_rows > 0): ?>
      <div class="cart-total">
        <h3>Total: Rs.<?= number_format($finalTot, 2) ?></h3>
        <a href="checkout.php">Proceed to Checkout</a>
      </div>
    <?php endif; ?>
  </div>
  
  <div class="download-btn-container">
    <form action="downloadcart_report.php" method="post">
      <button type="submit" class="download-btn">Download Cart Report</button>
    </form>
  </div>

  <script src="script.js"></script>
  <br><br><br><br><br><br><br><br>
  <?php include "footer.php"; ?>
</body>

</html>
