<?php
require_once 'database.php'; // 包含数据库连接文件

// 获取从前端传递的用户名和密码
$email = $_POST['email'];
$password = $_POST['password'];

// 在实际应用中，请使用密码哈希函数（如password_hash）进行安全处理

// 执行数据库查询
$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 用户验证成功
    $response['success'] = true;
} else {
    // 用户验证失败
    $response['success'] = false;
}

// 输出 JSON 数据
echo json_encode($response);

// 不要关闭连接，因为其他文件可能仍在使用该连接

// 注意：如果 login_check.php 中有后续代码，最好使用 exit 或 die 等终止脚本，以防止继续执行其他代码
// exit();