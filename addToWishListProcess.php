<?php

require "connection.php";
session_start();


$id = $_POST["id"];


// $email = $_SESSION["user"]["email"];

$userid=$_SESSION["user2"]["id"];



$resultSet = Database::search("SELECT * FROM `wishlist` WHERE `user_id` = '".$userid."' AND `product_product_id`= '".$id."'  ");



$data = $resultSet ->fetch_assoc();





$count = $resultSet->num_rows;

if($count == 0){

    Database::iud("INSERT INTO `wishlist` (`product_product_id`,`user_id`) VALUES ('".$id."' , '".$userid."'  ) ");
    echo("done");

}








?>