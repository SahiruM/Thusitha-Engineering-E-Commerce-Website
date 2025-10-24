<?php
require "connection.php";
session_start();

$newName = $_POST["username"];
$newEmail = $_POST["useremail"];
$newTele = $_POST["usertele"];
$newAdress = $_POST["useraddress"];
$newPassword = $_POST["userpassword"];

$newPp = null; 

// Check if a file is uploaded
if (isset($_FILES["fileInput"]) && $_FILES["fileInput"]["error"] == 0) {
    $fileTmpPath = $_FILES["fileInput"]["tmp_name"];
    $fileName = $_FILES["fileInput"]["name"];
    $uploadDir = "uploads/"; // Ensure this directory exists with correct permissions
    $destinationPath = $uploadDir . uniqid() . "_" . $fileName;

    if (move_uploaded_file($fileTmpPath, $destinationPath)) {
        $newPp = $destinationPath;
    } else {
        echo "Error uploading file.";
        exit();
    }
}

// Insert user data into the database
Database::iud("INSERT INTO `customer_table` (`customer_name`, `customer_email`, `customer_telephone`, `customer_address`, `customer_password`, `customer_pp`) 
VALUES ('$newName', '$newEmail', '$newTele', '$newAdress', '$newPassword', '$newPp')");

Database::iud("INSERT INTO `user` (`name`,`mobile`,`email`,`password`) VALUES ('$newName','$newTele','$newEmail','$newPassword')");
$rs = Database::search("SELECT * FROM `user` WHERE `email`='$newEmail' AND `password` = '$newPassword'");
$user = $rs->fetch_assoc();
Database::iud("INSERT INTO `cart` (`user_id`) VALUES ('".$user["id"]."')");
echo "done";
?>
