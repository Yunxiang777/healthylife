<?php
require_once __DIR__ . '/../config.php';

/**
 * Database 類別用於處理與資料庫的連線。
 */
class Database
{
    private $conn;

    public function __construct()
    {
        $config = $GLOBALS['config'];

        $this->conn = new mysqli($config['db_host'], $config['db_username'], $config['db_password'], $config['db_name']);

        if ($this->conn->connect_error) {
            die("資料庫連線失敗" . $this->conn->connect_error);
        }
    }

    // 連線資料庫
    public function getConnection()
    {
        return $this->conn;
    }

    // 關閉資料庫連接
    public function closeConnection()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
