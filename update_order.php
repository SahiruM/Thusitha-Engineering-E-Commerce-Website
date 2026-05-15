<?php

require "connection.php";
require "require_admin.php";

$id = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$payment = trim($_POST['payment'] ?? '');
$address = trim($_POST['shipping_address'] ?? '');

if ($id <= 0 || $name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $phone === '' || $address === '') {
    echo "Invalid order details.";
    exit();
}

Database::execute(
    "UPDATE `checkout` SET `name` = ?, `email` = ?, `phone` = ?, `payment_method` = ?, `shipping_address` = ? WHERE `id` = ?",
    "sssssi",
    $name,
    $email,
    $phone,
    $payment,
    $address,
    $id
);

echo "success";

?>
