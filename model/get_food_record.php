<?php
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../helper.php';
$helper_food_record = new Helper();

// 輸出相應的時段
$mealTime = $helper_food_record->mealTime();

// 當前日期為 "Y-m-d"（年-月-日）
$formattedDate = $helper_food_record->currentDateTime();

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
     * @param string $member_id 會員id
     * @return mysqli_result 食物記錄的 mysqli_result 物件
     */
    public function getFoodRecord($mealTime, $member_id)
    {

        $stmt = $this->conn->prepare("SELECT name, calories, time_period FROM food_record WHERE date = ? AND users_id = ? ");
        $stmt->bind_param("ss", $mealTime, $member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

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

        return $result;
    }

    /**
     * 獲取指定日期的卡路里總和。
     *
     * @param string $today 日期
     * @param string $member_id 會員id
     * @return int totalCalories 今日所食用卡路里總和
     */
    public function today_calories($today, $member_id)
    {
        $stmt = $this->conn->prepare("SELECT calories FROM food_record WHERE date = ? AND users_id = ? ");
        $stmt->bind_param("ss", $today, $member_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $totalCalories = 0;

        // 逐一迴圈計算每筆卡路里的總和
        while ($row = $result->fetch_assoc()) {
            $totalCalories += $row['calories'];
        }

        $stmt->close();

        return $totalCalories;
    }

    /**
     * 關閉資料庫連接
     */
    public function closeConnection()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
