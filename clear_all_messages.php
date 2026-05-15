<?php

require "connection.php";
require "require_admin.php";

Database::iud("DELETE FROM `message`");

echo "success";

?>
