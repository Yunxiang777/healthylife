<?php
require __DIR__ . '/template/narbar.php';
$helper->visitor_redirect();
require_once __DIR__ . '/../model/update_member_data.php';
$Update_member_data = new Update_member_data();
// 獲取個人訊息
$profile_message = $Update_member_data->member_message($_SESSION['member_id']);
$tedd = $helper->tdee($profile_message['gender'], $profile_message['height'], $profile_message['weight'], $profile_message['age']);
?>

<head>
    <!-- sweetalert2  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

</head>
<div class="container">
    <div class="row" style="margin-top: 30px;">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $profile_message['name'] . '的體態數據' ?></h5>
                    <div class="row">
                        <div class="col-6">TDEE基礎代謝率 : <?= $tedd ?></div>
                        <div class="col-6">健康瘦身卡路里需求 : <?= $tedd - 500 ?></div>
                    </div>
                    <div class="input-group mt-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-info" type="button" id="update_weight">更新</button>
                        </div>
                        <input type="text" class="form-control" placeholder="輸入本日體重(kg)" id="input_weight"
                            aria-label="輸入本日體重(kg)" aria-describedby="update_weight">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">An item</li>
                        <li class="list-group-item">A second item</li>
                        <li class="list-group-item">A third item</li>
                        <li class="list-group-item">A fourth item</li>
                        <li class="list-group-item">And a fifth one</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {

    $('#update_weight').click(function() {

        var weightValue = $('#input_weight').val();

        //如果體重輸入格式錯誤，提示錯誤並終止
        if (weight_error(weightValue)) return;

        $.ajax({
            type: 'POST',
            url: '<?= $api['body_data'] ?>',
            data: {
                'member_id': <?= $_SESSION['member_id'] ?>,
                'weight': weightValue
            },
            success: function(response) {
                if (response.update) {
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error updating weight:', error);
            }
        });
    });

    /**
     * 輸入體重格式判斷
     *
     * @param {number|string} weight 輸入體重數值
     * @return {boolean} 返回輸入格式正確與否
     */
    function weight_error(weight) {
        var regex = /^\d+(\.\d{1})?$/;
        if (!regex.test(weight)) {
            Swal.fire({
                icon: 'error',
                title: '錯誤',
                text: '請輸入最多小數點後一位的數字',
                showConfirmButton: false,
                timer: 2000
            });
            return true;
        } else {
            return false;
        }
    }
});
</script>