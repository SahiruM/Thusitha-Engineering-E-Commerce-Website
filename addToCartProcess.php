<?php
require "connection.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user2"])) {
    // If the user is not logged in, redirect them to the login page
    header("Location: login.php");
    exit();
}

// Get product ID from the POST request
$id = $_POST["id"];

// Retrieve the logged-in user's ID from the session
$userid = $_SESSION["user2"]["id"];

// Fetch the user's cart data
$resultSet = Database::search("SELECT * FROM `cart` WHERE `user_id` = '$userid'");
$data = $resultSet->fetch_assoc();

if ($data) {
    // Check if the product is already in the cart
    $rs2 = Database::search("SELECT * FROM `cart_item` WHERE `product_product_id` = '".$id."' AND `cart_cart_id` = '".$data["cart_id"]."'");
    $count = $rs2->num_rows;

    if ($count == 1) {
        // If the product is already in the cart, increase its quantity
        Database::iud("UPDATE `cart_item` SET `quantity` = `quantity` + 1 WHERE `product_product_id` = '".$id."' AND `cart_cart_id` = '".$data["cart_id"]."'");
        echo "done";  // Product quantity updated
    } else {
        // If the product is not in the cart, add it as a new item
        Database::iud("INSERT INTO `cart_item` (`cart_cart_id`, `product_product_id`, `quantity`) VALUES ('".$data["cart_id"]."', '".$id."', 1)");
        echo "done";  // Product added to the cart
    }
} else {
    // Handle case if there is no cart for the user (optional)
    echo "No cart found for this user!";
}
?>
