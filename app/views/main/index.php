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
<?php /** @var int $role */
\core\App::view('menu', ['role' => $role]);
\core\Html::CSRFToken();
?>
<p style="font-size: 24px">Главная страница</p>
</body>
</html>