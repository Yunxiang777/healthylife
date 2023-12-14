<?php
require __DIR__ . '/../model/login_check.php';
$Login_check = new Login_check();

//確認使用者觸發帳號密碼登入
$result = $Login_check->login_confirm($_POST['email'], $_POST['password']);
if ($result) {
    session_start();
    $_SESSION['member_id'] = $result['id'];
    $_SESSION['email'] = $result['email'];
    $_SESSION['login_status'] = true;
    header('Content-Type: application/json');
    echo json_encode(['login_status' => true]);
    exit();
} else {
    $_SESSION['login_status'] = false;
    echo json_encode(['login_status' => false]);
    exit();
}
