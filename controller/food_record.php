<?php
// your_php_file.php

require_once '../model/get_food_record.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $foodName = $_POST['foodName'];
    $calories = $_POST['calories'];
    $users_id = $_POST['users_id'];
    $today = $_POST['today'];
    $mealTime = $_POST['mealTime'];

    // 在這裡使用你的 FoodRecordGetter 對象執行數據庫插入操作
    $foodRecordGetter = new Get_food_record();
    $foodRecordGetter->insertFoodRecord($foodName, $calories, $users_id, $today, $mealTime);

    echo "食物記錄插入成功";
}
