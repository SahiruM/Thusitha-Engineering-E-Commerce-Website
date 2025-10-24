<?php
require "connection.php";
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user2"])) {
    $userid = $_SESSION["user2"]["id"];
    $user_email = $_SESSION["user2"]["email"];

    $name = addslashes($_POST['name']);
    $shipping_address = addslashes($_POST['shipping_address']);
    $email = addslashes($_POST['email']);
    $phone = addslashes($_POST['phone']);
    $payment = addslashes($_POST['payment']);

    // Save order info
    Database::iud("INSERT INTO `checkout` (`name`, `shipping_address`, `email`, `phone`, `payment_method`) 
    VALUES ('$name', '$shipping_address', '$email', '$phone', '$payment')");

    // Get cart
    $cartResult = Database::search("SELECT * FROM `cart` WHERE `user_id` = '$userid'");

    if ($cartResult->num_rows == 1) {
        $cartData = $cartResult->fetch_assoc();
        $cartID = $cartData['cart_id'];

        $cartItems = Database::search(
            "SELECT * FROM `cart_item` 
            INNER JOIN `product` ON `product`.`product_id` = `cart_item`.`product_product_id`
            WHERE `cart_cart_id` = '$cartID'"
        );

        // Generate HTML table
        $tableBody = '';
        $totalOrder = 0;
        while ($item = $cartItems->fetch_assoc()) {


            
            $itemTotal = $item['quantity'] * $item['price'];
            $totalOrder += $itemTotal;
            $tableBody .= '
                <tr>
                    <td>' . htmlspecialchars($item['product_name']) . '</td>
                    <td>$' . number_format($item['price'], 2) . '</td>
                    <td>' . $item['quantity'] . '</td>
                    <td>$' . number_format($itemTotal, 2) . '</td>
                </tr>';
                Database::iud("UPDATE `product` SET `stock` = `stock` - {$item['quantity']} WHERE `product_id` = {$item['product_product_id']}");
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
        <p><strong>Total Order Amount:</strong> $' . number_format($totalOrder, 2) . '</p>';

        // Send email to user
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'sahirumejitha123@gmail.com';
            $mail->Password   = 'mwks ymdk awxr glsp'; // App password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('sahirumejitha123@gmail.com', 'Thusitha Engineering');
            $mail->addAddress($user_email);

            $mail->isHTML(true);
            $mail->Subject = 'Order Confirmation - Thusitha Engineering';
            $mail->Body = '<h2>Thank you for your order!</h2>' . $htmlTable;

            $mail->send();
        } catch (Exception $e) {
            echo "Failed to send email to customer. Error: {$mail->ErrorInfo}";
        }

        // Send email to admin
        $mail2 = new PHPMailer(true);
        try {
            $mail2->isSMTP();
            $mail2->Host       = 'smtp.gmail.com';
            $mail2->SMTPAuth   = true;
            $mail2->Username   = 'sahirumejitha123@gmail.com';
            $mail2->Password   = 'mwks ymdk awxr glsp';
            $mail2->SMTPSecure = 'tls';
            $mail2->Port       = 587;

            $mail2->setFrom('sahirumejitha123@gmail.com', 'Thusitha Engineering');
            $mail2->addAddress('sahirumejitha123@gmail.com'); // Admin email

            $mail2->isHTML(true);
            $mail2->Subject = 'New Order Received - Thusitha Engineering';
            $mail2->Body = '<h2>New order placed by ' . htmlspecialchars($email) . '</h2>' . $htmlTable;

            $mail2->send();
        } catch (Exception $e) {
            echo "Failed to send email to admin. Error: {$mail2->ErrorInfo}";
        }

        echo '<div class="success-message">Order placed and emails sent successfully.</div>';
    } else {
        echo "No cart found for this user.";
    }
} else {
    echo "Invalid request or user not logged in.";
}
?>
