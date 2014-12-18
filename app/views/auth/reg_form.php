<form id="reg-form" onsubmit="register(); return false;">
    <?php \core\Html::CSRFToken('reg_form'); ?>
    <div id="reg-errors"></div>

    <div>
        <label for="reg_username">Имя пользователя</label>
        <input id="reg_username" name="username" type="text" style="width: 99%; margin-top: 5px" autocomplete="off">
    </div>

    <div style="margin-top: 8px">
        <label for="reg_password">Пароль</label>
        <input id="reg_password" name="password" type="password" style="width: 99%; margin-top: 5px" autocomplete="off">
    </div>

    <div style="margin-top: 8px">
        <label for="reg_confirm_password">Еще раз введите пароль</label>
        <input id="reg_confirm_password" name="confirm_password" type="password" style="width: 99%; margin-top: 5px" autocomplete="off">
    </div>

    <div style="margin-top: 22px">
        <input type="submit" value="Зарегистрироваться и войти" style="width: 50%; height: 34px" />
    </div>
</form>
<script>
    function register() {
        $.ajax({
            url      : 'auth/register',
            cache    : false,
            type     : 'POST',
            dataType : 'json',
            data     : $("#reg-form").serialize(),
            success  : function(data) {
                if (data.result == '1') {
                    window.location.replace('./');
                } else {
                    var elem = $("#reg-errors");
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
