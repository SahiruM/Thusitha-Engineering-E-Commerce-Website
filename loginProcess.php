<?php

require "connection.php";
session_start();

$email = $_POST["email"];
$password = $_POST["password"];

$resultSet = Database::search("SELECT * FROM `customer_table` WHERE `customer_email` = '".$email."' AND `customer_password` = '".$password."'");

$count = $resultSet->num_rows;

if($count == 1){
    $user = $resultSet->fetch_assoc();
    $_SESSION["user"] = $user;

   $rs =  Database::search("SELECT * FROM `user` WHERE `email` = '".$email."' AND `password` = '".$password."'");
   if($rs->num_rows==1){

    $user2 = $rs->fetch_assoc();
    $_SESSION["user2"] = $user2;

   }

    // 👉 UPDATE login_count by 1
    Database::iud("UPDATE `customer_table` SET `login_count` = `login_count` + 1 WHERE `customer_id` = '".$user['customer_id']."'");

    echo("done");

} else {
    echo("Email or Password is wrong");
}

?>
