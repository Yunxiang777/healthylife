<?php
require __DIR__ . '/../model/login_check.php';
$Login_check = new Login_check();

//確認使用者觸發帳號密碼登入
if ($_POST['email']) {
    $result = $Login_check->login_confirm($_POST['email'], $_POST['password']);
    //確認帳號密碼是否存在
    if ($result) {
        echo $result['id'];
        exit();
    } else {
        echo false;
        exit();
    }
}
