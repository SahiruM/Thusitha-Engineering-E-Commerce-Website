<?php
require "connection.php";

// Get the item ID from POST
$item_id = $_POST["id"];


        // Quantity is 1, so delete the item
        Database::iud("DELETE FROM `wishlist` WHERE `product_product_id` = '".$item_id."'");

        Database::iud("DELETE FROM `cart_item` WHERE `product_product_id` = '".$item_id."'");

        Database::iud("DELETE FROM `reviews` WHERE `product_product_id` = '".$item_id."'");

        Database::iud("DELETE FROM `product` WHERE `product_id` = '".$item_id."'");
      echo("done");

?>
