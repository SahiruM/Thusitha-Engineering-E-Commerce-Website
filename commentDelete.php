<?php
session_start();
require "connection.php";


$userid = $_SESSION["user2"]["id"];
$id = $_POST["id"];

// Basic sanitization
$id = intval($id);

// delete query
Database::iud("DELETE FROM `comments` WHERE `comments_id` = '".$id."'");
