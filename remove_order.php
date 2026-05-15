<?php

require "connection.php";
require "require_admin.php";

$orderId = (int)($_POST['order_id'] ?? 0);

if ($orderId <= 0) {
    echo "Invalid request.";
    exit();
}

Database::execute("DELETE FROM `checkout` WHERE `id` = ?", "i", $orderId);
echo "success";

?>
