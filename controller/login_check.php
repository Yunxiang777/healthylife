<?php
session_start();
require __DIR__ . '/../model/login_check.php';
$Login_check = new Login_check();

//確認使用者觸發帳號密碼登入
if (isset($_POST['email'])) {
    $result = $Login_check->login_confirm($_POST['email'], $_POST['password']);
    login($result, $_POST['remember_me']);
}

//使用者登出
if (isset($_POST['logout'])) {
    session_destroy();
    session_unset();
}

/**
 * 使用者登入判斷，執行存入sesseion動作
 * 
 * @param boolean $result 確認資料庫是否有此帳戶
 * @param string $remember_me 是否有勾選記住我
 */
function login($result, $remember_me)
{
    if ($result) {
        $_SESSION['member_id'] = $result['id'];
        $_SESSION['email'] = $result['email'];
        $_SESSION['login_status'] = true;
        $remember_me = ($_POST['remember_me'] === 'true') ? true : false;

        // 如果勾選了 "Remember Me"，設置 Cookie
        if ($remember_me) {
            setcookie('remember_me_email', $result['email'], time() + (7 * 24 * 60 * 60), '/');
        } else {
            setcookie('remember_me_email', '', time() - 3600, '/');
        }

        header('Content-Type: application/json');
        echo json_encode(['login_status' => true]);
        exit();
    } else {
        $_SESSION['login_status'] = false;
        echo json_encode(['login_status' => false]);
        exit();
    }
}
