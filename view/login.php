<?php require_once __DIR__ . '/template/narbar.php' ?>

<head>
    <link rel="stylesheet" href="../style/login.css">
</head>
<div class="container">
    <form class="form_style">
        <div class="form-group">
            <label for="email">郵件地址 <span id="mail_check"></span></label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">我們絕對不會洩漏您個人隱私</small>
        </div>
        <div class="form-group">
            <label for="password">密碼 <span id="password_check"></span></label>
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

        //檢查帳號密碼輸入格式
        if (!validateLogin(email, password)) return;

        $.ajax({
            type: "POST",
            url: "../controller/login_check.php",
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                //檢查帳號密碼是否正確
                login_check(response.login_status);
            },
            error: function(error) {
                console.error("Ajax request failed", error);
            }
        });

    });

});

//檢查帳號密碼輸入格式
function validateLogin(email, password) {
    var loginErrors = {};

    // Check email
    if (!email.trim()) {
        loginErrors.email = "Email 不能為空";
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        loginErrors.email = "Email 格式錯誤";
    } else {
        loginErrors.email = '';
    }

    // Check password
    if (!password.trim()) {
        loginErrors.password = "密碼不能為空";
    } else {
        loginErrors.password = '';
    }

    if (loginErrors.email || loginErrors.password) {
        $("#mail_check").html(loginErrors.email).css("display", "inline");
        $("#password_check").html(loginErrors.password).css("display", "inline");
        return false; // Exit the function if there are errors
    } else {
        return true;
    }

}

//檢查帳號密碼是否正確
function login_check(login_status) {
    if (login_status) {
        $("#mail_check").html('').css("display", "none");
        $("#password_check").html('').css("display", "none");
        window.location.href = '../index.php';
    } else {
        $("#mail_check").html('帳號密碼錯誤').css("display", "inline");
        $("#password_check").html('帳號密碼錯誤').css("display", "inline");
    }
}
</script>