<?php
// config/db.php

class Database {
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            $host = "localhost";
            $port = "1521";
            $service = "XE";
            $username = "hhms";
            $password = "hhms";

            $tns = "(DESCRIPTION =
                        (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
                        (CONNECT_DATA =
                            (SERVICE_NAME = $service)
                        )
                    )";

            try {
                self::$connection = new PDO("oci:dbname=$tns;charset=AL32UTF8", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Database connection successful.";
            } catch (PDOException $e) {
                die("Database connection failed: An error occurred while connecting to the database.");
            }
        }
        return self::$connection;
    }

    public static function closeConnection() {
        self::$connection = null;
    }
}

Database::getConnection();
?>
