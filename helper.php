<?php
require_once __DIR__ . '/config.php';

/**
 * Helper 類別提供一些輔助功能。
 */
class Helper
{
    /** @var array $routing 存儲路由資訊的陣列 */
    private $routing;

    public function __construct()
    {
        global $routing;
        // 設定時區為台灣台北
        date_default_timezone_set('Asia/Taipei');
        $this->routing = $routing;
    }

    /**
     * 檢查使用者登入狀態。
     *
     * @return bool 登入狀態為真時返回 true，否則返回 false。
     */
    public function login_status()
    {
        if (isset($_SESSION['login_status']) && $_SESSION['login_status'] === true) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 若使用者未登入，將訪客導向登入頁面。
     */
    public function visitor_redirect()
    {
        $routing = $this->routing;
        if (!($this->login_status())) {
            header("Location:" . $routing['login']);
            exit();
        }
    }

    /**
     * 計算使用者目前的TDEE數據
     *
     * @param string $gender 使用者性別 ('男' 或 '女')
     * @param float $height 使用者身高（單位：公分）
     * @param float $weight 使用者體重（單位：公斤）
     * @param int $age 使用者年齡
     * @return float 使用者的TDEE數據
     */
    public function tdee($gender, $height, $weight, $age)
    {
        // BMR的計算，根據Harris-Benedict方程式
        if ($gender === '男') {
            $bmr = 88.362 + (13.397 * $weight) + (4.799 * $height) - (5.677 * $age);
        } elseif ($gender === '女') {
            $bmr = 447.593 + (9.247 * $weight) + (3.098 * $height) - (4.330 * $age);
        } else {
            return false;
        }

        // 根據活動水平估算TDEE
        $activityMultiplier = 1.55; // 中度活動水平
        $tdee = round($bmr * $activityMultiplier);

        return $tdee;
    }

    /**
     * 返回當前日期與時間的格式化字串
     *
     * @return string 格式化的日期與時間（'Y-m-d'）
     */
    public function mealTime()
    {
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

        return $mealTime;
    }

    /**
     * 返回當前時間對應的日期Y-m-d"（年-月-日）
     *
     * @return string Y-m-d"（年-月-日）
     */
    public function currentDateTime()
    {
        $currentDateTime = new DateTime();

        // 格式化日期與時間為 "Y-m-d"（年-月-日）
        return $currentDateTime->format('Y-m-d');
    }
}
