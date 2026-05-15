<?php

require "connection.php";
require "require_admin.php";

$id = (int)($_POST["id"] ?? 0);

if ($id <= 0) {
    echo json_encode(null);
    exit();
}

$rs = Database::select("SELECT * FROM `product` WHERE `product_id` = ?", "i", $id);
$product = $rs->fetch_assoc();

echo json_encode($product);

?>
