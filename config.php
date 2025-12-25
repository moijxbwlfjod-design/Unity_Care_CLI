<?php
class Connect{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $charset = "utf8mb4";

    function connectToDB($host, $username, $password, $dbname){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        try{
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch(PDOException $e){
            echo "Connection Error: ".$e->getMessage();
        }
    }
}

$pdo = new Connect();
$conn_result = $pdo->connectToDB("localhost", "root", "moha_med2007", "unity_care");