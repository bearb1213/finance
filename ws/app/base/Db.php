<?php


class DB {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $pdo = null;

    public function __construct($host, $dbname, $username, $password) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    public function getDb() {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO(
                    "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                    $this->username,
                    $this->password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                throw new PDOException("Database connection error: " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}

// Configuration
$db = new DB('localhost', 'tp_flight', 'root', '');