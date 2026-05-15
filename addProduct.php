<?php

require "connection.php";
require "upload_helpers.php";

$pName = trim($_POST["pName"] ?? "");
$pPrice = (float)($_POST["pPrice"] ?? 0);
$pStock = (int)($_POST["pStock"] ?? 0);

if ($pName === "" || $pPrice <= 0 || $pStock < 0) {
    echo "Please enter valid product details.";
    exit();
}

try {
    $fileName = saveUploadedImage("image", "product", true);

    Database::execute(
        "INSERT INTO `product` (`product_name`, `price`, `img`, `stock`) VALUES (?, ?, ?, ?)",
        "sdsi",
        $pName,
        $pPrice,
        $fileName,
        $pStock
    );

    echo "done";
} catch (RuntimeException $e) {
    echo $e->getMessage();
}

?>
