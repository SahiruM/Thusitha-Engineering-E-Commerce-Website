<?php
require "connection.php";

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$payment = $_POST['payment'];
$address = $_POST['shipping_address'];

$update = Database::iud("UPDATE `checkout` SET 
    `name`='$name', 
    `email`='$email', 
    `phone`='$phone', 
    `payment_method`='$payment', 
    `shipping_address`='$address' 
    WHERE `id`='$id'");

?>
