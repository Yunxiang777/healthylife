<?php
require_once './template/narbar.php';
require_once __DIR__ . '/../model/update_member_data.php';
$Update_member_data = new Update_member_data();
// 獲取個人訊息
$profile_message = $Update_member_data->member_message(1);

?>

<head>
    <link rel="stylesheet" href="../style/person_data.css">
    <!-- cropperjs，圖片裁減cdn，css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.css">
</head>
<div class="container">
    <div class="card mt-3">
        <div class="photo">
            <input type="file" class="form-control-file" id="fileInput" name="profileImage" style="display: none;">
            <label for="fileInput">
                <img src="<?= $profile_message['photo'] !== '' ?   './../upload/profile/' . $profile_message['photo'] . '?=' . time() : './../images/default.png' ?>" id="member_img" class="card-img-top">
            </label>
        </div>
        <div class="card-body">
            <form>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="name">姓名</label>
                        <input type="text" class="form-control" id="name" value="<?= $profile_message['name'] ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="age">年齡</label>
                        <input type="text" class="form-control" id="age" value="<?= $profile_message['age'] ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="address">住址</label>
                        <input type="text" class="form-control" id="address" value="<?= $profile_message['address'] ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="height">身高(cm)</label>
                        <input type="text" class="form-control" id="height" value="<?= $profile_message['height'] ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="weight">體重(kg)</label>
                        <input type="text" class="form-control" id="weight" value="<?= $profile_message['weight'] ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="gender">性別</label>
                        <select class="custom-select" id="gender">
                            <option <?= $profile_message['gender'] === '男' ? 'selected' : ''; ?> value="男">男</option>
                            <option <?= $profile_message['gender'] === '女' ? 'selected' : ''; ?> value="女">女</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="profession">職業</label>
                        <input type="text" class="form-control" id="profession" value="<?= $profile_message['profession'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone">手機</label>
                        <input type="text" class="form-control" id="phone" value="<?= $profile_message['phone'] ?>" required>
                    </div>
                </div>
                <button class="btn btn-info" type="button" id="update_member_data">更新基本資料</button>
            </form>
        </div>
    </div>
</div>

<!-- 用於裁剪圖片Modal -->
<div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">裁剪圖片</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <img src="" id="cropperImage" style="max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <!-- 新增裁剪確認按鈕 -->
                <button type="button" class="btn  btn-info" id="cropConfirm">確認</button>
            </div>
        </div>
    </div>
</div>

<!-- cropperjs，圖片裁減cdn，js-->
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js"></script>

<script>
    $(document).ready(function() {

        // 初始化 cropper，但暫時不設定圖片
        var cropper = new Cropper(document.getElementById('cropperImage'), {
            aspectRatio: 16 / 9, // 裁剪框的寬高比例
            viewMode: 1, // 裁剪框的視圖模式
            guides: true, // 顯示裁剪框的導引線
            autoCropArea: 0.8, // 自動裁剪區域的大小
        });

        // 選擇圖片，啟動裁剪功能
        $("#fileInput").change(function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                // 將圖片顯示在 modal 中
                $("#cropperImage").attr("src", e.target.result);

                // 開啟 modal
                $('#cropModal').modal('show');

                // 等 modal 顯示後再設定圖片
                $('#cropModal').on('shown.bs.modal', function() {
                    cropper.replace(e.target.result);
                });
            };
            reader.readAsDataURL(file);
        });

        // 在 modal 關閉時銷毀 cropper
        $('#cropModal').on('hidden.bs.modal', function() {
            cropper.destroy();
        });

        //裁剪確認按鈕事件
        $("#cropConfirm").click(function() {
            // 獲取裁剪後的圖像 Canvas
            var croppedCanvas = cropper.getCroppedCanvas();
            // 將 Canvas 轉換為 Blob 對象
            croppedCanvas.toBlob(function(blob) {
                var formData = new FormData();
                formData.append('photo', blob, 'cropped_image.jpg');
                formData.append('member_id', '1');
                $('#cropModal').modal('hide');

                $.ajax({
                    type: "POST",
                    url: "<?= $domain  . 'controller/person_data.php' ?>",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }, 'image/jpeg');
        });

        // 使用者表單事件
        $("#update_member_data").click(function() {
            // 獲取表單數據
            var name = $("#name").val();
            var age = $("#age").val();
            var address = $("#address").val();
            var height = $("#height").val();
            var weight = $("#weight").val();
            var gender = $("#gender").val();
            var profession = $("#profession").val();
            var phone = $("#phone").val();

            $.ajax({
                type: "POST",
                url: "<?= $domain . 'controller/person_data.php' ?>",
                data: {
                    name: name,
                    age: age,
                    address: address,
                    height: height,
                    weight: weight,
                    gender: gender,
                    profession: profession,
                    phone: phone,
                    member_id: '1',
                    update_member_data: true
                },
                success: function(response) {
                    // 成功處理請求後的操作
                    console.log(response);
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