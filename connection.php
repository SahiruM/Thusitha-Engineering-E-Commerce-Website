<?php

require_once __DIR__ . "/config.php";

if (file_exists(__DIR__ . "/config.local.php")) {
    require_once __DIR__ . "/config.local.php";
}

class Database {

    public static $connection;

    public static function setUpConnection() {

        if (!isset(Database::$connection)) {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            Database::$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
            Database::$connection->set_charset("utf8mb4");
        }
    }

    public static function connection() {
        Database::setUpConnection();
        return Database::$connection;
    }

    public static function iud($q) {

        Database::setUpConnection();
        return Database::$connection->query($q);
    }

    public static function search($q) {

        Database::setUpConnection();
        return Database::$connection->query($q);
    }

    public static function prepare($q) {
        Database::setUpConnection();
        return Database::$connection->prepare($q);
    }

    public static function execute($q, $types = "", ...$params) {
        $stmt = Database::prepare($q);

        if ($types !== "") {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt;
    }

    public static function select($q, $types = "", ...$params) {
        $stmt = Database::execute($q, $types, ...$params);
        return $stmt->get_result();
    }

    public static function escape($value) {
        Database::setUpConnection();
        return Database::$connection->real_escape_string($value);
    }
}

?>
