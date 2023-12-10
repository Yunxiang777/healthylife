<?php
require_once __DIR__ . '/database.php';
class Update_member_data
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * 將會員數據更新到資料庫
     *
     * @param array $userData 包含會員數據的關聯陣列
     * @param int $member_id 會員ID
     * @return bool 成功時返回 true，失敗時返回 false
     */
    public function update_data($userData)
    {
        $stmt = $this->conn->prepare("UPDATE member_data SET name = ?, age = ?, address = ?, height = ?, weight = ?, gender = ?, profession = ?, phone = ? WHERE users_id = ?");
        $stmt->bind_param("ssssssssi", $userData['name'], $userData['age'], $userData['address'], $userData['height'], $userData['weight'], $userData['gender'], $userData['profession'], $userData['phone'], $userData['member_id']);
        $result = $stmt->execute();
        $affectedRows = $stmt->affected_rows;
        $stmt->close();

        return ($result && $affectedRows > 0);
    }

    /**
     * 將會員頭像更新到資料庫
     *
     * @param array $image 包含會員數據的關聯陣列
     * @return bool 成功時返回 true，失敗時返回 false
     */
    public function update_image($image)
    {
        $stmt = $this->conn->prepare("UPDATE member_data SET photo = ? WHERE users_id = ?");
        $stmt->bind_param("si", $image['file_name'], $image['member_id']);
        $result = $stmt->execute();
        $affectedRows = $stmt->affected_rows;
        $stmt->close();

        return ($result && $affectedRows > 0);
    }

    /**
     * 會員個人資料頁
     *
     * @param array $member_id 會員id
     * @return bool 返回關聯數組
     */
    public function member_message($member_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM member_data  WHERE users_id = ?");
        $stmt->bind_param("i", $member_id);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $data[0];
    }
}
