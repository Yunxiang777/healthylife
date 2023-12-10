<?php
require __DIR__ . '/../model/get_food_record.php';
$foodRecordGetter = new Get_food_record();

//判斷新增食物的結果
if ($_POST['users_id']) {
    $foodName = $_POST['foodName'];
    $calories = $_POST['calories'];
    $users_id = $_POST['users_id'];
    $today = $_POST['today'];
    $mealTime = $_POST['mealTime'];
    $result = $foodRecordGetter->insertFoodRecord($foodName, $calories, $users_id, $today, $mealTime);
    if ($result) {
        echo true;
        exit();
    } else {
        false;
        exit();
    }
}
