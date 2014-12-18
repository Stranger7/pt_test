<form id="auth-form" onsubmit="login(); return false;">
    <?php \core\Html::CSRFToken('auth_form'); ?>
    <div id="auth-errors"></div>

    <div>
        <label for="auth_username">Имя пользователя</label>
        <input id="auth_username" name="username" type="text" style="width: 99%; margin-top: 5px" autocomplete="off">
    </div>

    <div style="margin-top: 8px">
        <label for="auth_password" >Пароль</label>
        <input id="auth_password" name="password" type="password" style="width: 99%; margin-top: 5px" autocomplete="off">
    </div>

    <div style="margin-top: 22px">
        <input type="submit" value="Войти" style="width: 50%; height: 34px" />
    </div>
</form>

<script>
    function login() {
        $.ajax({
            url      : 'auth/login',
            cache    : false,
            type     : 'POST',
            dataType : 'json',
            data     : $("#auth-form").serialize(),
            success  : function(data) {
                if (data.result == '1') {
                    window.location.replace('./');
                } else {
                    var elem = $("#auth-errors");
                    elem.addClass('error-container');
                    elem.html(data.message);
                }
            },
            error    : function(data) {
                $("#auth-errors").html(data.responseText);
            }
        });
    }
</script>
