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
<p class="big"><?= (isset($title) ? $title : '') ?></p>
<div id="errors"></div>
<div id="product-entries" class="ui-widget"></div>

<div id="dialog-form" title="Создать/редактировать товар">
    <div id="form-errors"  class="validateTips"></div>

    <form id="product-form">
        <fieldset>
            <label for="name">Наименование *</label>
            <input type="text" name="name" id="name" value="" class="text ui-widget-content ui-corner-all">
            <label for="description">Описание</label>
            <input type="text" name="description" id="description" value="" class="text ui-widget-content ui-corner-all">
            <label for="price">Цена *</label>
            <input type="text" name="price" id="price" value="" class="text ui-widget-content ui-corner-all">
            <label for="quantity">Остаток *</label>
            <input type="text" name="quantity" id="quantity" value="" class="text ui-widget-content ui-corner-all">

            <!-- Allow form submission with keyboard without duplicating the dialog button -->
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
</div>

</body>
</html>