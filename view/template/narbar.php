<?php
session_start();
require_once __DIR__ . '/../../helper.php';
$helper = new Helper();
//取得當前路由位置
$filename = pathinfo(basename($_SERVER['REQUEST_URI']))['filename'];
ob_start(); //緩衝輸出，確保header被呼叫之前，沒有任何輸出
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthyLife</title>
    <?php require __DIR__ . '/common.php'; ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="<?= $routing['base_url'] ?>">HealthyLife</a>
        <button class=" navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item  <?= $filename == 'healthylife' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= $routing['base_url'] ?>">首頁
                    </a>
                </li>
                <li class="nav-item <?= $filename == 'diet_record' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= $routing['diet_record'] ?>">飲食紀錄</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
                        會員資料
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= $routing['person_data'] ?>">基本資料</a>
                        <a class="dropdown-item" href="<?= $routing['body_data'] ?>">身體數據</a>
                        <!-- <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a> -->
                    </div>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                </li> -->
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" id="<?= $helper->login_status() ? 'logout_member' : 'login_member' ?>">
                    <?= $helper->login_status() ? '登出' : '登入' ?>
                </button>
            </form>

        </div>
    </nav>
    <script>
        $(document).ready(function() {
            //登入會員
            $("#login_member").click(function() {
                window.location.href =
                    "<?= $routing['login'] ?>";
            });

            //登出
            $("#logout_member").click(function() {
                $.ajax({
                    url: "<?= $api['logout'] ?>",
                    type: "POST",
                    data: {
                        'logout': true
                    },
                    success: function(data) {
                        window.location.href = "<?= $routing['base_url'] ?>";
                    },
                    error: function(error) {
                        console.error("Ajax request failed", error);
                    }
                });
            });
        });
    </script>