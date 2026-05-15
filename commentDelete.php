<?php

session_start();
require "connection.php";

if (!isset($_SESSION["user2"]["id"])) {
    echo "Please log in first.";
    exit();
}

$userid = (int)$_SESSION["user2"]["id"];
$id = (int)($_POST["id"] ?? 0);

if ($id <= 0) {
    echo "Invalid comment.";
    exit();
}

Database::execute("DELETE FROM `comments` WHERE `comments_id` = ? AND `user_id` = ?", "ii", $id, $userid);

echo "done";

?>
