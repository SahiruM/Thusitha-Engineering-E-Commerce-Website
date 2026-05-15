<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["admin"])) {
    http_response_code(403);
    echo "Admin login required.";
    exit();
}

