<?php
session_start();

$userid = $_SESSION["user2"]["id"];
require "connection.php";


$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$message = $_POST["message"];

// Basic sanitization
$name = addslashes($name);
$email = addslashes($email);
$phone = addslashes($phone);
$message = addslashes($message);

// Perform the insert query
Database::iud("INSERT INTO `message` (`msg_name`, `msg_mail`, `phone`, `comment`) VALUES ('".$name."', '".$email."', '".$phone."', '".$message."')");
