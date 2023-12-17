<?php
require __DIR__ . '/../model/body_data.php';
$Body_data = new Body_data();
if ($_POST['weight']) {
    $result = $Body_data->update_weight($_POST['member_id'], $_POST['weight']);
    if ($result) {
        header('Content-Type: application/json');
        echo json_encode(['update' => true]);
        exit();
    } else {
        header('Content-Type: application/json');
        echo json_encode(['update' => false]);
        exit();
    }
}
