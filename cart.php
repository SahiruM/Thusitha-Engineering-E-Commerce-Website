<?php
require "connection.php";
session_start();

if (!isset($_SESSION["user2"]["id"])) {
    header("Location: login.php");
    exit();
}

$userid = (int)$_SESSION["user2"]["id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thusitha Engineering | Cart</title>
  <link href="https://fonts.googleapis.com/css?family=Bayon|Inter&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="footer.css" />
  <link rel="stylesheet" href="cart.css" />
</head>

<body>
<?php include "header.php"; ?>

<main>
  <section class="cart-hero">
    <h1>Your cart is ready for review.</h1>
  </section>

  <section class="cart-shell">
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
          $cartRs = Database::select(
            "SELECT * FROM cart
             INNER JOIN cart_item ON cart.cart_id = cart_item.cart_cart_id
             INNER JOIN product ON product.product_id = cart_item.product_product_id
             WHERE cart.user_id = ?",
            "i",
            $userid
          );

          $finalTot = 0;

          if ($cartRs->num_rows > 0) {
            while ($cartData = $cartRs->fetch_assoc()) {
              $tot = (float)$cartData["price"] * (int)$cartData["quantity"];
              $finalTot += $tot;
          ?>
              <tr>
                <td><?= htmlspecialchars($cartData["product_name"]) ?></td>
                <td>Rs. <?= number_format((float)$cartData["price"], 2) ?></td>
                <td><?= (int)$cartData["quantity"] ?></td>
                <td>Rs. <?= number_format($tot, 2) ?></td>
                <td>
                  <button class="remove-btn" onclick="remove_item(<?= (int)$cartData['cart_item_id'] ?>)">Remove</button>
                </td>
              </tr>
          <?php
            }
          } else {
            echo "<tr><td class='empty-row' colspan='5'>Your cart is empty.</td></tr>";
          }
          ?>
        </tbody>
      </table>

      <?php if ($cartRs->num_rows > 0): ?>
        <div class="cart-total">
          <h3>Total: Rs. <?= number_format($finalTot, 2) ?></h3>
          <a class="checkout-link" href="checkout.php">Proceed to Checkout</a>
        </div>
      <?php endif; ?>
    </div>

    <div class="download-card">
      <form action="downloadcart_report.php" method="post">
        <button type="submit" class="download-btn">Download Cart Report</button>
      </form>
    </div>
  </section>
</main>

<script src="script.js"></script>
<?php include "footer.php"; ?>
</body>
</html>
