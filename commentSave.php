<?php

session_start();
require "connection.php";

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$message = trim($_POST["message"] ?? "");

if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || $phone === "" || $message === "") {
    echo "Please enter valid message details.";
    exit();
}

Database::execute(
    "INSERT INTO `message` (`msg_name`, `msg_mail`, `phone`, `comment`) VALUES (?, ?, ?, ?)",
    "ssss",
    $name,
    $email,
    $phone,
    $message
);

echo "done";

?>
