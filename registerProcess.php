<?php

require "connection.php";
require "upload_helpers.php";
session_start();

$newName = trim($_POST["username"] ?? "");
$newEmail = trim($_POST["useremail"] ?? "");
$newTele = trim($_POST["usertele"] ?? "");
$newAdress = trim($_POST["useraddress"] ?? "");
$newPassword = $_POST["userpassword"] ?? "";

if ($newName === "" || $newEmail === "" || $newTele === "" || $newAdress === "" || $newPassword === "") {
    echo "Please fill in all required fields.";
    exit();
}

if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
    echo "Please enter a valid email address.";
    exit();
}

if (!preg_match('/^\d{10}$/', $newTele)) {
    echo "Telephone number must be exactly 10 digits.";
    exit();
}

if (strlen($newPassword) < 8) {
    echo "Password must be at least 8 characters.";
    exit();
}

$existingUser = Database::select("SELECT `customer_id` FROM `customer_table` WHERE `customer_email` = ?", "s", $newEmail);
if ($existingUser->num_rows > 0) {
    echo "An account with this email already exists.";
    exit();
}

$newPp = null;

try {
    $newPp = saveUploadedImage("fileInput", "uploads", false);
} catch (RuntimeException $e) {
    echo $e->getMessage();
    exit();
}

$passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

Database::execute(
    "INSERT INTO `customer_table` (`customer_name`, `customer_email`, `customer_telephone`, `customer_address`, `customer_password`, `customer_pp`) VALUES (?, ?, ?, ?, ?, ?)",
    "ssssss",
    $newName,
    $newEmail,
    $newTele,
    $newAdress,
    $passwordHash,
    $newPp
);

Database::execute(
    "INSERT INTO `user` (`name`, `mobile`, `email`, `password`) VALUES (?, ?, ?, ?)",
    "ssss",
    $newName,
    $newTele,
    $newEmail,
    $passwordHash
);

$userId = Database::connection()->insert_id;
Database::execute("INSERT INTO `cart` (`user_id`) VALUES (?)", "i", $userId);

echo "done";

?>
