<?php

require "connection.php";
// session_start();


$id = $_POST["id"];




    Database::iud("DELETE FROM `wishlist` WHERE `wish_id`='".$id."' ");
    echo("done");










?>