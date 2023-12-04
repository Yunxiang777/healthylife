<?php
require_once './template/narbar.php';
require_once '../model/get_food_record.php';

// 創建 FoodRecordGetter 對象
$foodRecordGetter = new Get_food_record();
// 獲取食物記錄結果
$result = $foodRecordGetter->getFoodRecord($mealTime);
?>

<head>
    <link rel="stylesheet" href="../style/diet_record.css">
</head>
<div class="container">
    <h1><?php echo $mealTime; ?></h1>
    <div class="food_box">
        <input type="text" id="food" placeholder="食物" class="input_diet">
        <input type="text" id="calories" placeholder="卡路里(大卡)" class="input_diet">
        <button type="button" class="btn btn-outline-info" id="add_food">新增食物</button>
    </div>
</div>

<div class="container">
    <ul class="list-group food_list">
        <?php
        // 遍歷結果集，生成每一個 <li>
        while ($row = $result->fetch_assoc()) {
            echo '<li class="list-group-item">食物: ' . $row['name'] . '，卡路里: ' . $row['calories'] . '，時段: ' . $row['time_period'] . '</li>';
        }
        ?>
    </ul>
</div>

<?php require_once './template/common.php'; ?>

<script>
$(document).ready(function() {
    // 當頁面加載完成後，綁定點擊事件
    $("#add_food").on("click", function() {
        // 獲取食物和卡路里的值
        var foodName = $("#food").val();
        var calories = $("#calories").val();

        // 日期格式化函數，請根據實際需求使用你喜歡的方式
        function formatDate(date) {
            var dd = date.getDate();
            var mm = date.getMonth() + 1;
            var yyyy = date.getFullYear();

            if (dd < 10) {
                dd = '0' + dd;
            }

            if (mm < 10) {
                mm = '0' + mm;
            }

            return yyyy + '-' + mm + '-' + dd;
        }

        var today = formatDate(new Date());

        // 執行 AJAX 請求
        $.ajax({
            type: "POST",
            url: "../controller/food_record.php", // 請替換成實際的 PHP 文件路徑
            data: {
                foodName: foodName,
                calories: calories,
                users_id: 1,
                today: today,
                mealTime: "<?php echo $mealTime; ?>"
            },
            success: function(response) {
                // 處理成功的回應
                location.reload();
            },
            error: function(error) {
                // 處理錯誤
                console.error(error);
            }
        });
    });
});
</script>