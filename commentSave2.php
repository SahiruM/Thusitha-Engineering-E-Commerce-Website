<?php

session_start();
require "connection.php";

if (!isset($_SESSION["user2"]["id"])) {
    echo "Please log in first.";
    exit();
}

$userid = (int)$_SESSION["user2"]["id"];
$message = trim($_POST["message"] ?? "");

if ($message === "") {
    echo "Comment cannot be empty.";
    exit();
}

Database::execute("INSERT INTO `comments` (`msg`, `user_id`) VALUES (?, ?)", "si", $message, $userid);

echo "done";

?>
