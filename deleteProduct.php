<?php

require "connection.php";
require "require_admin.php";

$item_id = (int)($_POST["id"] ?? 0);

if ($item_id <= 0) {
    echo "Invalid product.";
    exit();
}

Database::execute("DELETE FROM `wishlist` WHERE `product_product_id` = ?", "i", $item_id);
Database::execute("DELETE FROM `cart_item` WHERE `product_product_id` = ?", "i", $item_id);
Database::execute("DELETE FROM `reviews` WHERE `product_product_id` = ?", "i", $item_id);
Database::execute("DELETE FROM `product` WHERE `product_id` = ?", "i", $item_id);

echo "done";

?>
