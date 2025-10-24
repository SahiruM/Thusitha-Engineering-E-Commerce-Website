<?php
require "connection.php";

$pName = $_POST["pName"];
$pPrice = $_POST["pPrice"];

$pStock = $_POST["pStock"];


    



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





            

            Database::iud("INSERT INTO `product` (`product_name`,`price`,`img`,`stock`) VALUES ('".$pName."','".$pPrice."','".$file_name."','".$pStock."')");
        } else {
            echo ("Invalid Image type");
        }
    }else{
        echo("empty Image ");
    }

echo ("Product image saved successfully");
