<?php
require __DIR__ . '/template/narbar.php';
$helper->visitor_redirect();
require __DIR__ . '/../model/get_food_record.php';
require_once __DIR__ . '/../model/update_member_data.php';
$Update_member_data = new Update_member_data();
// 獲取個人訊息
$profile_message = $Update_member_data->member_message($_SESSION['member_id']);
//減脂肪所需熱量 $diet_tdee
$diet_tdee = $helper->tdee($profile_message['gender'], $profile_message['height'], $profile_message['weight'], $profile_message['age']) - 500;
// 獲取食物記錄結果
$foodRecordGetter = new Get_food_record();
//今日攝取食物
$result = $foodRecordGetter->getFoodRecord($formattedDate, $_SESSION['member_id']);
//今日總卡路里 $total_calories
$total_calories = $foodRecordGetter->today_calories($formattedDate, $_SESSION['member_id']);
//今日卡路里%數
$diet_percent = $total_calories / $diet_tdee * 100;
?>

<head>
    <link rel="stylesheet" href="../style/diet_record.css">
</head>
<div class="container">
    <h4>今日健康瘦身所需熱量進度條(<?= $diet_tdee ?>仟卡) <span class="badge badge-secondary">TDEE</span></h4>
    <div class="progress">
        <div class="progress-bar bg-info" role="progressbar" style="width: <?= $diet_percent ?>%" aria-valuenow="350" aria-valuemin="0" aria-valuemax="100"><?= $total_calories ?></div>
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

<?php $foodRecordGetter->closeConnection(); ?>