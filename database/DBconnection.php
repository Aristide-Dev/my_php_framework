<?php

namespace Database;

use PDO;

class DBconnection
{
    private $dbname;
    private $host;
    private $username;
    private $password;
    private $pdo;

    public function __construct(string $dbname, string $host, string $username, string $password)
    {
        $this->dbname = $dbname;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }


    public function getPDO(): PDO
    {
        return $this->pdo ?? $this->pdo = new PDO("mysql:dbname={$this->dbname};host={$this->host};charset=utf8mb4;", $this->username, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);
    }
}
