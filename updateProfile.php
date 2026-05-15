<?php

session_start();
require "connection.php";
require "upload_helpers.php";

if (!isset($_SESSION["user"])) {
    echo "User not logged in.";
    exit();
}

$user_email = $_SESSION["user"]["customer_email"];

$newName = trim($_POST["username"] ?? "");
$newTele = trim($_POST["usertele"] ?? "");
$newAddress = trim($_POST["useraddress"] ?? "");
$newPassword = $_POST["userpassword"] ?? "";

if ($newName === "" || !preg_match('/^\d{10}$/', $newTele) || $newAddress === "") {
    echo "Please enter valid profile details.";
    exit();
}

$result = Database::select("SELECT * FROM `customer_table` WHERE `customer_email` = ?", "s", $user_email);
if ($result->num_rows !== 1) {
    echo "User not found.";
    exit();
}

$currentData = $result->fetch_assoc();

try {
    $uploadedPp = saveUploadedImage("fileInput", "uploads", false);
} catch (RuntimeException $e) {
    echo $e->getMessage();
    exit();
}

$newPp = $uploadedPp ?: $currentData["customer_pp"];

if ($newPassword !== "") {
    if (strlen($newPassword) < 8) {
        echo "Password must be at least 8 characters.";
        exit();
    }

    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    Database::execute(
        "UPDATE `customer_table` SET `customer_name` = ?, `customer_telephone` = ?, `customer_address` = ?, `customer_pp` = ?, `customer_password` = ? WHERE `customer_email` = ?",
        "ssssss",
        $newName,
        $newTele,
        $newAddress,
        $newPp,
        $passwordHash,
        $user_email
    );
    Database::execute("UPDATE `user` SET `name` = ?, `mobile` = ?, `password` = ? WHERE `email` = ?", "ssss", $newName, $newTele, $passwordHash, $user_email);
} else {
    Database::execute(
        "UPDATE `customer_table` SET `customer_name` = ?, `customer_telephone` = ?, `customer_address` = ?, `customer_pp` = ? WHERE `customer_email` = ?",
        "sssss",
        $newName,
        $newTele,
        $newAddress,
        $newPp,
        $user_email
    );
    Database::execute("UPDATE `user` SET `name` = ?, `mobile` = ? WHERE `email` = ?", "sss", $newName, $newTele, $user_email);
}

$updatedResult = Database::select("SELECT * FROM `customer_table` WHERE `customer_email` = ?", "s", $user_email);
$_SESSION["user"] = $updatedResult->fetch_assoc();

echo "Profile updated successfully.";

?>
