<?php
// config/db.php

class Database {
    private $connection;

    // Constructor will connect when an instance is created
    public function __construct() {
        $username = "your_username";      // Replace with your Oracle DB username
        $password = "your_password";      // Replace with your Oracle DB password
        $connection_string = "//localhost:1521/XE";  // Update as needed

        $this->connection = oci_connect($username, $password, $connection_string);

        if (!$this->connection) {
            $e = oci_error();
            die("Connection failed: " . htmlentities($e['message']));
        }
    }

    // Getter to return the connection
    public function getConnection() {
        return $this->connection;
    }

    // Optional: method to close connection
    public function closeConnection() {
        if ($this->connection) {
            oci_close($this->connection);
        }
    }
}
