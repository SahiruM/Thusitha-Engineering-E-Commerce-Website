<?php

require "connection.php";
session_start();

$adminemail = $_POST["adminemail"];
$adminpassword = $_POST["adminpassword"];

// Check admin credentials
$resultSet = Database::search("SELECT * FROM `admin_table` WHERE `admin_email` = '".$adminemail."' AND `admin_password` = '".$adminpassword."'");

if ($resultSet->num_rows == 1) {
    $admin = $resultSet->fetch_assoc();
    $_SESSION["admin"] = $admin;

    echo "done";
} else {
    echo "Email or Password is wrong";
}

?>
