<?php
require "connection.php";

if (isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    $result = Database::iud("DELETE FROM `checkout` WHERE `id` = '$orderId'");
    echo "success";
} else {
    echo "Invalid request.";
}
?>
