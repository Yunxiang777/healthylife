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

// 獲取當前日期與時間
$currentDateTime = new DateTime();

// 格式化日期與時間為 "Y-m-d"（年-月-日）
$formattedDate = $currentDateTime->format('Y-m-d');

/**
 * Get_food_record 類別用於獲取和插入食物記錄相關資料。
 */
class Get_food_record
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * 獲取指定日期的食物記錄。
     *
     * @param string $mealTime 日期
     * @return mysqli_result 食物記錄的 mysqli_result 物件
     */
    public function getFoodRecord($mealTime)
    {

        $stmt = $this->conn->prepare("SELECT name, calories, time_period FROM food_record WHERE date = ?");
        $stmt->bind_param("s", $mealTime);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $this->conn->close();

        return $result;
    }

    /**
     * 插入食物記錄。
     *
     * @param string $foodName 食物名稱
     * @param int $calories 卡路里
     * @param int $users_id 使用者ID
     * @param string $today 日期
     * @param string $mealTime 用餐時段
     * @return bool 插入是否成功的布林值
     */
    public function insertFoodRecord($foodName, $calories, $users_id, $today, $mealTime)
    {
        $stmt = $this->conn->prepare("INSERT INTO food_record (name, calories, users_id, date, time_period) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $foodName, $calories, $users_id, $today, $mealTime);
        $result = $stmt->execute();
        $stmt->close();
        $this->conn->close();

        return $result;
    }
}
