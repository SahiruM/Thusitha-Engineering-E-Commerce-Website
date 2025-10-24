<?php
session_start();
require "connection.php";

$userid = $_SESSION["user2"]["id"];
$id = $_POST["id"];
$text = $_POST["text"];

// Basic sanitization
$id = intval($id);
$text = addslashes($text);

// Perform the update query
Database::iud("UPDATE `comments` SET `msg` = '".$text."' WHERE `comments_id` = '".$id."'");
