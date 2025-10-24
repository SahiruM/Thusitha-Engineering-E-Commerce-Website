<?php
require "connection.php";
session_start();

$userid = $_SESSION["user2"]["id"];

// Fetch user's cart
$cartResult = Database::search("SELECT * FROM `cart` WHERE `user_id` = '$userid'");
$cartData = $cartResult->fetch_assoc();

// Fetch cart items
$cartItemResults = Database::search(
    "SELECT * FROM `cart_item`
     INNER JOIN `product` ON `product`.`product_id` = `cart_item`.`product_product_id`
     WHERE `cart_cart_id` = " . $cartData['cart_id']
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thusitha Engineering | Checkout</title>
    <link href='https://fonts.googleapis.com/css?family=Bayon' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Bayon' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
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
                        mysqli_data_seek($cartItemResults, 0); // Reset pointer
                        while ($cartTable = $cartItemResults->fetch_assoc()) {
                            $productName = $cartTable["product_name"];
                            $price = $cartTable["price"];
                            $qty = $cartTable["quantity"];
                            $total = $price * $qty;

                            echo "<tr>
                                    <td>$productName</td>
                                    <td>Rs. $price</td>
                                    <td>$qty</td>
                                    <td>Rs. $total</td>
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
