<?php require_once __DIR__ . '/template/narbar.php' ?>

<head>
    <link rel="stylesheet" href="../style/login.css">
</head>
<div class="container">
    <form class="form_style">
        <div class="form-group">
            <label for="email">郵件地址</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">我們絕對不會洩漏您個人隱私</small>
        </div>
        <div class="form-group">
            <label for="password">密碼</label>
            <input type="password" class="form-control" id="password">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="check">
            <label class="form-check-label" for="check">記住我</label>
        </div>
        <button type="button" class="btn btn-primary" id="login">登入</button>
    </form>
</div>

<script>
$(document).ready(function() {
    //登入確認觸發
    $("#login").click(function() {
        var email = $("#email").val();
        var password = $("#password").val();
        $.ajax({
            type: "POST",
            url: "../controller/login_check.php",
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                if (response) {
                    window.location.href = '../index.php';
                } else {
                    console.log("帳號密碼有誤");
                }
            },
            error: function(error) {
                console.error("Ajax request failed", error);
            }
        });

    });
});
</script>