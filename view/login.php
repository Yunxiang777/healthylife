<?php require_once './template/narbar.php'; ?>

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
<?php require_once './template/common.php'; ?>


<script>
    $(document).ready(function() {
        $("#login").click(function() {
            // 获取 email 和 password 的值
            var email = $("#email").val();
            var password = $("#password").val();

            // 在这里执行你的登录逻辑，可以将 email 和 password 发送到服务器进行验证
            // 例如，你可以使用 AJAX 向服务器发送登录请求

            // 示例：使用 jQuery 的 AJAX
            $.ajax({
                type: "POST",
                url: "../model/login_check.php",
                data: {
                    email: email,
                    password: password
                },
                dataType: "json", // Specify the expected data type
                success: function(response) {
                    // Check the 'success' property in the JSON response
                    if (response.success) {
                        // Login successful logic
                        window.location.href = 'home.php';
                    } else {
                        // Login failed logic
                        console.log("Login failed");
                    }
                },
                error: function(error) {
                    // Handle Ajax request error
                    console.error("Ajax request failed", error);
                }
            });

        });
    });
</script>