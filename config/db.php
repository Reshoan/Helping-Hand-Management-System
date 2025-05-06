<?php
// config/db.php

class Database {
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            $host = "localhost";        // or the hostname of your Oracle server
            $port = "1521";             // default Oracle port
            $sid  = "XE";               // or your Oracle SID or service name
            $username = "your_username";
            $password = "your_password";

            $tns = "(DESCRIPTION =
                        (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
                        (CONNECT_DATA =
                            (SID = $sid)
                        )
                    )";

            try {
                self::$connection = new PDO("oci:dbname=$tns;charset=AL32UTF8", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
