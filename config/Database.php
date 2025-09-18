<?php
class Database {
    private $host     = 'server1865';
    private $db_name  = 'u246220442_mimu';
    private $username = 'u246220442_ananda';
    private $password = 'Rezky-ananda12';
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $dsn    = "mysql:host={$this->host}; dbname={$this->db_name};charset=utf8mb4";
            $option = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            $this->conn = new PDO($dsn, $this->username, $this->password, $option);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }

        return $this->conn;
    }
}
?>