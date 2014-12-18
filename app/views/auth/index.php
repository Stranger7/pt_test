<!DOCTYPE html>
<html>
<?php
/** @var array $css */
/** @var array $js */
\core\App::view('common\head', [
    'title' => (isset($title) ? $title : ''),
    'css' => $css,
    'js' => $js
]);
?>
<body>
<div id="tabs" style="position: absolute; width: 50%; margin-left: 24%; margin-top: 50px">
    <ul>
        <li><a href="#tabs-1">Авторизация</a></li>
        <li><a href="#tabs-2">Регистрация</a></li>
    </ul>
    <div id="tabs-1">
        <?php \core\App::view('auth\auth_form'); ?>
    </div>
    <div id="tabs-2">
        <?php \core\App::view('auth\reg_form'); ?>
    </div>
</div>

<script>
    $(function() {
        $( "#tabs" ).tabs();
    });
</script>

</body>
</html>