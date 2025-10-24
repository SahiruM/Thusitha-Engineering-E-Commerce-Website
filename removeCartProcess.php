<?php
require "connection.php";

// Get the item ID from POST
$item_id = $_POST["id"];

// Fetch current quantity
$rs = Database::search("SELECT `quantity` FROM `cart_item` WHERE `cart_item_id` = '".$item_id."'");
$data = $rs->fetch_assoc();

if ($data) {
    if ($data["quantity"] > 1) {
        // Decrease quantity by 1
        Database::iud("UPDATE `cart_item` SET `quantity` = `quantity` - 1 WHERE `cart_item_id` = '".$item_id."'");
    } else {
        // Quantity is 1, so delete the item
        Database::iud("DELETE FROM `cart_item` WHERE `cart_item_id` = '".$item_id."'");
    }
    echo "done";
} else {
    echo "Item not found";
}
?>
