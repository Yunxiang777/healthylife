<?php
require_once 'database.php';
// 設定時區為台灣台北
date_default_timezone_set('Asia/Taipei');
// 取得當前時間
$currentHour = date('G');

// 判斷時間範圍並輸出相應的時段
if ($currentHour >= 5 && $currentHour < 11) {
    $mealTime = "早餐時段";
} elseif ($currentHour >= 11 && $currentHour < 14) {
    $mealTime = "午餐時段";
} elseif ($currentHour >= 14 && $currentHour < 19) {
    $mealTime = "晚餐時段";
} else {
    $mealTime = "點心時刻";
}


class Get_food_record
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getFoodRecord($mealTime)
    {
        // 避免 SQL 注入，使用 prepared statement
        $stmt = $this->conn->prepare("SELECT name, calories, time_period FROM food_record WHERE time_period = ?");
        $stmt->bind_param("s", $mealTime);

        // 執行查詢
        $stmt->execute();

        // 獲取結果集
        $result = $stmt->get_result();

        // 關閉 prepared statement
        $stmt->close();

        // 關閉資料庫連接
        $this->conn->close();

        return $result;
    }

    public function insertFoodRecord($foodName, $calories, $users_id, $today, $mealTime)
    {
        // 使用 prepared statement 防止 SQL 注入
        $stmt = $this->conn->prepare("INSERT INTO food_record (name, calories, users_id, date, time_period) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $foodName, $calories, $users_id, $today, $mealTime);

        // 執行插入操作
        $stmt->execute();

        // 關閉 prepared statement
        $stmt->close();

        // 關閉資料庫連接
        $this->conn->close();
    }
}
