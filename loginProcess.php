<?php

require "connection.php";
session_start();

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if ($email === "" || $password === "") {
    echo "Please enter your email and password";
    exit();
}

$resultSet = Database::select("SELECT * FROM `customer_table` WHERE `customer_email` = ?", "s", $email);

if ($resultSet->num_rows !== 1) {
    echo "Email or Password is wrong";
    exit();
}

$user = $resultSet->fetch_assoc();
$storedPassword = $user["customer_password"];
$validPassword = password_verify($password, $storedPassword) || hash_equals($storedPassword, $password);

if (!$validPassword) {
    echo "Email or Password is wrong";
    exit();
}

if (hash_equals($storedPassword, $password) && Database::columnLength("customer_table", "customer_password") >= 60) {
    $newHash = password_hash($password, PASSWORD_DEFAULT);
    Database::execute(
        "UPDATE `customer_table` SET `customer_password` = ? WHERE `customer_id` = ?",
        "si",
        $newHash,
        $user["customer_id"]
    );
    $user["customer_password"] = $newHash;
}

$_SESSION["user"] = $user;

$rs = Database::select("SELECT * FROM `user` WHERE `email` = ?", "s", $email);

if ($rs->num_rows === 1) {
    $user2 = $rs->fetch_assoc();
    $_SESSION["user2"] = $user2;
}

Database::execute(
    "UPDATE `customer_table` SET `login_count` = `login_count` + 1 WHERE `customer_id` = ?",
    "i",
    $user["customer_id"]
);

echo "done";

?>
