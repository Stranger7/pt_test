<nav>
    <a href="<?= \core\Utils::url() ?>">[Главная]</a>&nbsp;&nbsp;
    <a href="<?= \core\Utils::url('/purchase') ?>">[Покупки]</a>&nbsp;&nbsp;
    <?php if (isset($role) && $role === 1): ?>
        <a href="<?= \core\Utils::url('/product') ?>">[Товары]</a>&nbsp;&nbsp;
        <a href="<?= \core\Utils::url('/purchase/all') ?>">[Все покупки]</a>&nbsp;&nbsp;
    <?php endif; ?>
    <a onclick="logout()" style="float: right">[Выход]</a>
</nav>
<script>
    function logout() {
        var token_name = '<?= \core\App::config()->get(\core\Config::SECURITY_SECTION, 'csrf_token_name') ?>';
        var params = Utils.securityToken(token_name);
        $.ajax({
            url      : Globals.app + '/auth/logout',
            cache    : false,
            type     : 'POST',
            data     : params,
            dataType : 'json',
            complete : function() {
                window.location.replace('<?= \core\Utils::url('auth') ?>');
            },
            error    : function(data) {
                $("#auth-errors").html(data.responseText);
            }
        });
    }
</script>
