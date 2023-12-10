<?php
require __DIR__ . '/database.php';

/**
 * Class Login_check
 * 處理登入相關的驗證
 */
class Login_check
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * 登入驗證函式
     *
     * @param string $email 使用者輸入的電子郵件
     * @param string $password 使用者輸入的密碼
     * @return array|false 返回包含使用者資料的關聯陣列，若登入失敗則返回 false
     */
    public function login_confirm($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $this->conn->close();

        // 檢查是否有符合條件的結果
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            return $row;
        } else {

            return false;
        }
    }
}
