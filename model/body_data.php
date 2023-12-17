<?php
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../helper.php';

/**
 * Body_data 類別用於紀錄身體數據與體重變化。
 */
class Body_data
{
    /** 
     * @param string $formattedDate Y-m-d"（年-月-日）
     */
    private $conn;
    private $formattedDate;

    public function __construct()
    {
        $database = new Database();
        $helper_body_data = new Helper();
        $this->conn = $database->getConnection();
        $this->formattedDate = $helper_body_data->currentDateTime();
    }

    /**
     * 更新或插入使用者的體重資料。
     *
     * @param int $member_id 使用者 ID
     * @param float $weight 新的體重
     * @return bool 更新或插入是否成功的布林值
     */
    public function update_weight($member_id, $weight)
    {
        // 檢查資料庫中是否已經存在指定日期的數據
        $existingData = $this->get_body_data($member_id, $this->formattedDate);

        if ($existingData) {
            // 如果數據已存在，則更新體重
            $sql = "UPDATE weight_record SET weight = ? WHERE member_id = ? AND date = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("dss", $weight, $member_id, $this->formattedDate);
        } else {
            // 如果數據不存在，則插入新數據
            $sql = "INSERT INTO weight_record (member_id, weight, date) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("dss", $member_id, $weight, $this->formattedDate);
        }

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    /**
     * 獲取指定日期的使用者體重資料。
     *
     * @param int $member_id 使用者 ID
     * @param string $formattedDate 指定的日期
     * @return array|null 使用者體重資料的關聯陣列，如果不存在返回 null
     */
    private function get_body_data($member_id, $formattedDate)
    {
        $sql = "SELECT * FROM weight_record WHERE member_id = ? AND date = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ds", $member_id, $formattedDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row;
    }
}
