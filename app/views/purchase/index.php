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
<div id="errors"></div>
<div id="purchase-entries" class="ui-widget" style="padding-top: 10px"></div>

<div id="dialog-form" title="Купить">
    <div id="form-errors" class="validateTips"></div>

    <form id="purchase-form">
        <fieldset>
            <label for="product_id">Товар *</label>
            <select name="product_id" id="product_id" class="text ui-widget-content ui-corner-all">
            <?php /** @var array $products */;
            foreach($products as $product): ?>
                <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
            <?php endforeach; ?>
            </select>

            <label for="quantity">Количество *</label>
            <input type="text" name="quantity" id="quantity" value="" class="text ui-widget-content ui-corner-all">

            <!-- Allow form submission with keyboard without duplicating the dialog button -->
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
</div>

</body>
</html>