<?php
require "connection.php";

// Execute the delete query
Database::iud("DELETE FROM `message`");

// Return a simple success message
echo "success";
?>
