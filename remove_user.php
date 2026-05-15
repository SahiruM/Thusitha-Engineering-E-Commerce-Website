<?php

require "connection.php";
require "require_admin.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['user_id'])) {
    echo "No valid data received";
    exit();
}

$userID = (int)$_POST['user_id'];

if ($userID <= 0) {
    echo "Invalid user.";
    exit();
}

$connection = Database::connection();
$connection->begin_transaction();

try {
    Database::execute("DELETE FROM `customer_table` WHERE `customer_id` = ?", "i", $userID);
    Database::execute("DELETE FROM `user` WHERE `id` = ?", "i", $userID);
    $connection->commit();
    echo "success";
} catch (Throwable $e) {
    $connection->rollback();
    echo "Error deleting user: " . $e->getMessage();
}

?>
