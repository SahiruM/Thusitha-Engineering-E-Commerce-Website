<?php
session_start();
require "connection.php";

if (!isset($_SESSION["user"])) {
    echo "User not logged in.";
    exit();
}

$user_email = $_SESSION["user"]["customer_email"];

$newName = $_POST["username"];
$newTele = $_POST["usertele"];
$newAddress = $_POST["useraddress"];
$newPassword = $_POST["userpassword"]; // optional
$newPp = null;

// Get current user data
$result = Database::search("SELECT * FROM `customer_table` WHERE `customer_email` = '$user_email'");
if ($result->num_rows !== 1) {
    echo "User not found.";
    exit();
}

$currentData = $result->fetch_assoc();

// If a file was uploaded
if (isset($_FILES["fileInput"]) && $_FILES["fileInput"]["error"] == 0) {
    $fileTmpPath = $_FILES["fileInput"]["tmp_name"];
    $fileName = $_FILES["fileInput"]["name"];
    $uploadDir = "uploads/";
    $destinationPath = $uploadDir . uniqid() . "_" . $fileName;

    if (move_uploaded_file($fileTmpPath, $destinationPath)) {
        $newPp = $destinationPath;
    } else {
        echo "Error uploading profile picture.";
        exit();
    }
} else {
    $newPp = $currentData["customer_pp"]; // Keep existing image
}

// Update query
$query = "UPDATE `customer_table` SET 
    `customer_name` = '$newName',
    `customer_telephone` = '$newTele',
    `customer_address` = '$newAddress',
    `customer_pp` = '$newPp'";

// Add password only if changed
if (!empty($newPassword)) {
    $query .= ", `customer_password` = '$newPassword'";
}

$query .= " WHERE `customer_email` = '$user_email'";

// Run the update
Database::iud($query);
Database::iud("UPDATE `user` SET `name`='$newName', `mobile` = '$newTele',`password`='$newPassword' WHERE `email` = '$user_email'" );

// Update session with new info
$updatedResult = Database::search("SELECT * FROM `customer_table` WHERE `customer_email` = '$user_email'");
$_SESSION["user"] = $updatedResult->fetch_assoc();

echo "Profile updated successfully.";
?>
