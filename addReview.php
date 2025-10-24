<?php
require "connection.php";
session_start();

$userid = $_SESSION["user2"]["id"];
$id = $_POST["id"];
$value = $_POST["value"];

$review_rs = Database::search("SELECT * FROM `reviews` WHERE `product_product_id` = '".$id."' AND `user_id` = '$userid'");

if($review_rs->num_rows > 0){
    $review = $review_rs->fetch_assoc();
    Database::iud("UPDATE `reviews` SET `review_value` = '".$value."' WHERE `review_id` = '".$review["review_id"]."'");
}else{
    Database::iud("INSERT INTO `reviews` (`review_value`,`user_id`,`product_product_id`) VALUES ('".$value."','$userid','".$id."')");
}