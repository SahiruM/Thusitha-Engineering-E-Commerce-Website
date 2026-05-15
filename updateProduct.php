<?php

require "connection.php";
require "require_admin.php";
require "upload_helpers.php";

$pName = trim($_POST["pName"] ?? "");
$pPrice = (float)($_POST["pPrice"] ?? 0);
$pStock = (int)($_POST["pStock"] ?? 0);
$id = (int)($_POST["id"] ?? 0);

if ($id <= 0 || $pName === "" || $pPrice <= 0 || $pStock < 0) {
    echo "Please enter valid product details.";
    exit();
}

try {
    $fileName = saveUploadedImage("image", "product", false);

    if ($fileName) {
        Database::execute(
            "UPDATE `product` SET `product_name` = ?, `price` = ?, `img` = ?, `stock` = ? WHERE `product_id` = ?",
            "sdsii",
            $pName,
            $pPrice,
            $fileName,
            $pStock,
            $id
        );
    } else {
        Database::execute(
            "UPDATE `product` SET `product_name` = ?, `price` = ?, `stock` = ? WHERE `product_id` = ?",
            "sdii",
            $pName,
            $pPrice,
            $pStock,
            $id
        );
    }

    echo "done";
} catch (RuntimeException $e) {
    echo $e->getMessage();
}

?>
