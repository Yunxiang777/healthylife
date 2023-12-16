<?php
require __DIR__ . '/template/narbar.php';
require __DIR__ . '/../model/get_food_record.php';
$helper->visitor_redirect();

// 獲取食物記錄結果
$foodRecordGetter = new Get_food_record();
$result = $foodRecordGetter->getFoodRecord($formattedDate, $_SESSION['member_id']);
?>

<head>
    <link rel="stylesheet" href="../style/diet_record.css">
</head>
<div class="container">
    <h3><?= $mealTime ?></h3>
    <h5>今日總熱量攝取 <?= $foodRecordGetter->today_calories($formattedDate, $_SESSION['member_id']) ?></h5>
    <div class="progress">
        <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="50" aria-valuemin="0"
            aria-valuemax="100">153</div>
    </div>
    <div class="food_box">
        <input type="text" id="food" placeholder="食物" class="input_diet">
        <input type="text" id="calories" placeholder="卡路里(大卡)" class="input_diet">
        <button type="button" class="btn btn-outline-info" id="add_food">新增食物</button>
    </div>
</div>

<div class="container">
    <ul class="list-group food_list">
        <?php
        while ($row = $result->fetch_assoc()) {
            echo '<li class="list-group-item">食物: ' . $row['name'] . '，卡路里: ' . $row['calories'] . '，時段: ' . $row['time_period'] . '</li>';
        }
        ?>
    </ul>
</div>

<script>
$(document).ready(function() {
    //新增食物觸發
    $("#add_food").on("click", function() {
        // 獲取食物和卡路里的值
        var foodName = $("#food").val();
        var calories = $("#calories").val();
        var today = formatDate(new Date());

        $.ajax({
            type: "POST",
            url: "../controller/food_record.php",
            data: {
                foodName: foodName,
                calories: calories,
                users_id: 1,
                today: today,
                mealTime: "<?= $mealTime ?>"
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

    // 日期格式化函數
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
});
</script>

<?php $foodRecordGetter->closeConnection();?>