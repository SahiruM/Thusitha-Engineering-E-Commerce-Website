<?php

require "connection.php";
session_start();

$adminemail = trim($_POST["adminemail"] ?? "");
$adminpassword = $_POST["adminpassword"] ?? "";

if ($adminemail === "" || $adminpassword === "") {
    echo "Please enter your email and password";
    exit();
}

$resultSet = Database::select("SELECT * FROM `admin_table` WHERE `admin_email` = ?", "s", $adminemail);

if ($resultSet->num_rows !== 1) {
    echo "Email or Password is wrong";
    exit();
}

$admin = $resultSet->fetch_assoc();
$storedPassword = $admin["admin_password"];
$validPassword = password_verify($adminpassword, $storedPassword) || hash_equals($storedPassword, $adminpassword);

if (!$validPassword) {
    echo "Email or Password is wrong";
    exit();
}

if (hash_equals($storedPassword, $adminpassword)) {
    $newHash = password_hash($adminpassword, PASSWORD_DEFAULT);
    Database::execute(
        "UPDATE `admin_table` SET `admin_password` = ? WHERE `admin_email` = ?",
        "ss",
        $newHash,
        $adminemail
    );
    $admin["admin_password"] = $newHash;
}

$_SESSION["admin"] = $admin;

echo "done";

?>
