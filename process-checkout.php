<?php

require "connection.php";
session_start();

use PHPMailer\PHPMailer\Exception;

require "mailer.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_SESSION["user2"])) {
    echo "Invalid request or user not logged in.";
    exit();
}

$userid = (int)$_SESSION["user2"]["id"];
$user_email = $_SESSION["user2"]["email"];

$name = trim($_POST['name'] ?? '');
$shipping_address = trim($_POST['shipping_address'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$payment = trim($_POST['payment'] ?? '');
$allowedPayments = ['Cash_on_Delivery', 'Bank_Payment'];

if ($name === '' || $shipping_address === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $phone === '' || !in_array($payment, $allowedPayments, true)) {
    echo "Please enter valid checkout details.";
    exit();
}

$connection = Database::connection();

try {
    $connection->begin_transaction();

    $cartResult = Database::select("SELECT * FROM `cart` WHERE `user_id` = ?", "i", $userid);
    if ($cartResult->num_rows !== 1) {
        throw new RuntimeException("No cart found for this user.");
    }

    $cartData = $cartResult->fetch_assoc();
    $cartID = (int)$cartData['cart_id'];

    $cartItems = Database::select(
        "SELECT * FROM `cart_item`
         INNER JOIN `product` ON `product`.`product_id` = `cart_item`.`product_product_id`
         WHERE `cart_cart_id` = ?",
        "i",
        $cartID
    );

    if ($cartItems->num_rows === 0) {
        throw new RuntimeException("Your cart is empty.");
    }

    Database::execute(
        "INSERT INTO `checkout` (`name`, `shipping_address`, `email`, `phone`, `payment_method`) VALUES (?, ?, ?, ?, ?)",
        "sssss",
        $name,
        $shipping_address,
        $email,
        $phone,
        $payment
    );

    $tableBody = '';
    $totalOrder = 0;

    while ($item = $cartItems->fetch_assoc()) {
        $quantity = (int)$item['quantity'];
        $stock = (int)$item['stock'];
        $productId = (int)$item['product_product_id'];

        if ($quantity > $stock) {
            throw new RuntimeException($item['product_name'] . " does not have enough stock.");
        }

        $itemTotal = $quantity * (float)$item['price'];
        $totalOrder += $itemTotal;
        $tableBody .= '
            <tr>
                <td>' . htmlspecialchars($item['product_name']) . '</td>
                <td>Rs. ' . number_format((float)$item['price'], 2) . '</td>
                <td>' . $quantity . '</td>
                <td>Rs. ' . number_format($itemTotal, 2) . '</td>
            </tr>';

        Database::execute(
            "UPDATE `product` SET `stock` = `stock` - ? WHERE `product_id` = ?",
            "ii",
            $quantity,
            $productId
        );
    }

    Database::execute("DELETE FROM `cart_item` WHERE `cart_cart_id` = ?", "i", $cartID);

    $connection->commit();
} catch (Throwable $e) {
    $connection->rollback();
    echo $e->getMessage();
    exit();
}

$htmlTable = '
<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width:100%;">
    <thead>
        <tr style="background-color:#FF9400; color:white;">
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>' . $tableBody . '</tbody>
</table>
<br>
<h3>Order Summary</h3>
<p><strong>Name:</strong> ' . htmlspecialchars($name) . '</p>
<p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>
<p><strong>Phone:</strong> ' . htmlspecialchars($phone) . '</p>
<p><strong>Shipping Address:</strong> ' . htmlspecialchars($shipping_address) . '</p>
<p><strong>Payment Method:</strong> ' . htmlspecialchars($payment) . '</p>
<p><strong>Total Order Amount:</strong> Rs. ' . number_format($totalOrder, 2) . '</p>';

$mailWarnings = [];

try {
    $mail = createMailer();
    $mail->addAddress($user_email);
    $mail->Subject = 'Order Confirmation - Thusitha Engineering';
    $mail->Body = '<h2>Thank you for your order!</h2>' . $htmlTable;
    $mail->send();
} catch (Exception $e) {
    $mailWarnings[] = "customer email";
}

try {
    $mail2 = createMailer();
    $mail2->addAddress(MAIL_ADMIN_EMAIL);
    $mail2->Subject = 'New Order Received - Thusitha Engineering';
    $mail2->Body = '<h2>New order placed by ' . htmlspecialchars($email) . '</h2>' . $htmlTable;
    $mail2->send();
} catch (Exception $e) {
    $mailWarnings[] = "admin email";
}

if ($mailWarnings) {
    echo '<div class="success-message">Order placed successfully, but ' . htmlspecialchars(implode(" and ", $mailWarnings)) . ' could not be sent.</div>';
} else {
    echo '<div class="success-message">Order placed and emails sent successfully.</div>';
}

?>
