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
}
