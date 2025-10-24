<?php
session_start();
require "connection.php";

$userid = $_SESSION["user2"]["id"];
$message = $_POST["message"];

$userid = intval($userid);
$message = addslashes($message);

Database::iud("INSERT INTO `comments` (`msg`, `user_id`) VALUES ('".$message."', '".$userid."')");
