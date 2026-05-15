<?php

session_start();
require "connection.php";

if (!isset($_SESSION["user2"]["id"])) {
    echo "Please log in first.";
    exit();
}

$userid = (int)$_SESSION["user2"]["id"];
$id = (int)($_POST["id"] ?? 0);
$text = trim($_POST["text"] ?? "");

if ($id <= 0 || $text === "") {
    echo "Invalid comment.";
    exit();
}

Database::execute("UPDATE `comments` SET `msg` = ? WHERE `comments_id` = ? AND `user_id` = ?", "sii", $text, $id, $userid);

echo "done";

?>
