<?php

require "connection.php";
// session_start();


$id = $_POST["id"];




   $rs= Database::search("SELECT * FROM `product` WHERE `product_id`='".$id."'");

    $product = $rs->fetch_assoc();



    echo json_encode($product);






?>