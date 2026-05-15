<?php

define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '2003');
define('DB_NAME', getenv('DB_NAME') ?: 'thusitha');
define('DB_PORT', (int)(getenv('DB_PORT') ?: 3306));

define('MAIL_HOST', getenv('MAIL_HOST') ?: 'smtp.gmail.com');
define('MAIL_PORT', (int)(getenv('MAIL_PORT') ?: 587));
define('MAIL_USERNAME', getenv('MAIL_USERNAME') ?: '');
define('MAIL_PASSWORD', getenv('MAIL_PASSWORD') ?: '');
define('MAIL_FROM_EMAIL', getenv('MAIL_FROM_EMAIL') ?: MAIL_USERNAME);
define('MAIL_FROM_NAME', getenv('MAIL_FROM_NAME') ?: 'Thusitha Engineering');
define('MAIL_ADMIN_EMAIL', getenv('MAIL_ADMIN_EMAIL') ?: MAIL_FROM_EMAIL);

