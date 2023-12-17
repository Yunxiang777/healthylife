<?php
require __DIR__ . '/../model/body_data.php';
$Body_data = new Body_data();

//更新今日體重數據
if ($_POST['weight']) {
    $result = $Body_data->update_weight($_POST['member_id'], $_POST['weight']);
    header('Content-Type: application/json');
    echo json_encode(['update' => $result]);
    exit();
}
