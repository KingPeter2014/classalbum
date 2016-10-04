<?php
class Database {
    const HOST = "localhost";
    const DATABASE_NAME = "locali2e";
    const USERNAME = "root";
    const PASSWORD = "";
    private $connection_error = "Failed to connect to MySQL server. Please check the connection parameters.";
    private $connection = null;
    public function __construct() {
        $this->connect();
    }
    private function connect() {
        $this->connection = mysqli_connect(self::HOST, self::USERNAME, self::PASSWORD, self::DATABASE_NAME) or die($this->connection_error);
    }
    public function getConnection() {
        return $this->connection;
    }
    private function confirmQuery($query) {
        if (!$query) {
            die("Database query failed : " . mysqli_error($this->connection));
        }
    }
    public function query($query) {
        $result = mysqli_query($this->connection, $query);
        $this->confirmQuery($result);
        return $result;
    }
    public function escape($value) {
        $magic_quotes_active = get_magic_quotes_gpc();
        $new_enough_php = function_exists("mysqli_real_escape_string");
        if ($new_enough_php) {
            if ($magic_quotes_active) {
                $value = stripslashes($value);
            }
            $value = mysqli_real_escape_string($this->connection, $value);
        } else {
            if (!$magic_quotes_active) {
                $value = addslashes($value);
            }
        }
        return trim($value);
    }
