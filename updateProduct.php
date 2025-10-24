<?php
require "connection.php";

$pName = $_POST["pName"];
$pPrice = $_POST["pPrice"];

$pStock = $_POST["pStock"];
$id = $_POST["id"];


    



$allowed_img_extentions = array("image/jpg", "image/png", "image/jpeg", "image/svg+xml");


    if (isset($_FILES["image"])) {

        $img_file = $_FILES["image"];
        $file_extention = $img_file["type"];

        if (in_array($file_extention, $allowed_img_extentions)) {

            $new_img_extention;

            if ($file_extention == "image/jpg") {
                $new_img_extention = ".jpg";
            } else if ($file_extention == "image/jpeg") {
                $new_img_extention = ".jpeg";
            } else if ($file_extention == "image/png") {
                $new_img_extention = ".png";
            } else if ($file_extention == "image/svg+xml") {
                $new_img_extention = ".svg";
            }

            $file_name = "product//" . uniqid() . $new_img_extention;
            move_uploaded_file($img_file["tmp_name"], $file_name);





            


            Database::iud("UPDATE `product` SET `product_name`='".$pName."',`price`='".$pPrice."',`img`='".$file_name."',`stock`='".$pStock."' WHERE `product_id`='".$id."'");
        } else {
            echo ("Invalid Image type");
        }
    }else{
        Database::iud("UPDATE `product` SET `product_name`='".$pName."',`price`='".$pPrice."',`stock`='".$pStock."' WHERE `product_id`='".$id."'");

    }

