<?php

class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "healthylife";
    private $conn;

    // 构造函数，在创建对象时自动执行数据库连接
    public function __construct()
    {
        $this->connect();
    }

    // 连接数据库
    private function connect()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // 检查连接是否成功
        if ($this->conn->connect_error) {
            die("连接失败：" . $this->conn->connect_error);
        }
    }

    // 获取数据库连接对象
    public function getConnection()
    {
        return $this->conn;
    }

    // 关闭数据库连接
    public function closeConnection()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
