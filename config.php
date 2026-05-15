<?php

if (file_exists(__DIR__ . "/config.local.php")) {
    require_once __DIR__ . "/config.local.php";
}

defined('DB_HOST') || define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
defined('DB_USER') || define('DB_USER', getenv('DB_USER') ?: 'root');
defined('DB_PASSWORD') || define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '2003');
defined('DB_NAME') || define('DB_NAME', getenv('DB_NAME') ?: 'thusitha');
defined('DB_PORT') || define('DB_PORT', (int)(getenv('DB_PORT') ?: 3306));

defined('MAIL_HOST') || define('MAIL_HOST', getenv('MAIL_HOST') ?: 'smtp.gmail.com');
defined('MAIL_PORT') || define('MAIL_PORT', (int)(getenv('MAIL_PORT') ?: 587));
defined('MAIL_USERNAME') || define('MAIL_USERNAME', getenv('MAIL_USERNAME') ?: '');
defined('MAIL_PASSWORD') || define('MAIL_PASSWORD', getenv('MAIL_PASSWORD') ?: '');
defined('MAIL_FROM_EMAIL') || define('MAIL_FROM_EMAIL', getenv('MAIL_FROM_EMAIL') ?: MAIL_USERNAME);
defined('MAIL_FROM_NAME') || define('MAIL_FROM_NAME', getenv('MAIL_FROM_NAME') ?: 'Thusitha Engineering');
defined('MAIL_ADMIN_EMAIL') || define('MAIL_ADMIN_EMAIL', getenv('MAIL_ADMIN_EMAIL') ?: MAIL_FROM_EMAIL);
