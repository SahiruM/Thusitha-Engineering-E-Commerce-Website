<?php
require "connection.php";
session_start();

if (!isset($_SESSION["user2"]["id"])) {
    header("Location: login.php");
    exit();
}

$userid = (int)$_SESSION["user2"]["id"];

// Fetch user's cart
$cartResult = Database::select("SELECT * FROM `cart` WHERE `user_id` = ?", "i", $userid);
$cartData = $cartResult->fetch_assoc();

if (!$cartData) {
    header("Location: cart.php");
    exit();
}

// Fetch cart items
$cartItemResults = Database::select(
    "SELECT * FROM `cart_item`
     INNER JOIN `product` ON `product`.`product_id` = `cart_item`.`product_product_id`
     WHERE `cart_cart_id` = ?",
    "i",
    $cartData['cart_id']
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thusitha Engineering | Checkout</title>
    <link href="https://fonts.googleapis.com/css?family=Bayon" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="checkout.css">
    <link rel="stylesheet" href="header.css" />
    <link rel="stylesheet" href="footer.css">
</head>
<body>

<?php include "header.php"; ?>
<section class="hero">
    <div class="overlay">
        <div class="checkout-wrapper">
            <!-- Cart Table -->
            <div class="cart-box">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($cartTable = $cartItemResults->fetch_assoc()) {
                            $productName = $cartTable["product_name"];
                            $price = $cartTable["price"];
                            $qty = $cartTable["quantity"];
                            $total = $price * $qty;

                            echo "<tr>
                                    <td>" . htmlspecialchars($productName) . "</td>
                                    <td>Rs. " . number_format((float)$price, 2) . "</td>
                                    <td>" . (int)$qty . "</td>
                                    <td>Rs. " . number_format((float)$total, 2) . "</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Billing Form -->
            <div class="billing-details">
                <h2>Billing Details</h2>
                <form action="process-checkout.php" method="POST">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>

                    <label for="shipping_address">Shipping Address</label>
                    <input type="text" id="shipping_address" name="shipping_address" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>

                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" required>

                    <label for="payment">Payment Method</label>
                    <select id="payment" name="payment">
                        <option value="Cash_on_Delivery">Cash on Delivery</option>
                        <option value="Bank_Payment">Bank Payment</option>
                    </select>

                    <button class="checkout-btn">Place Order</button>
                </form>
            </div>
        </div>
    </div>
</section>


<?php include "footer.php"; ?>

<script src="script.js"></script>
</body>
</html>
