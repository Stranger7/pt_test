<?php
/**
 * @var array $entries
 */
?>

<!DOCTYPE html>
<html>
<?php
/** @var array $css */
/** @var array $js */
\core\App::view('common\head', [
    'title' => (isset($title) ? $title : ''),
    'css' => $css,
    'js' => $js,
]);
?>
<body>
<?php /** @var int $role */
\core\App::view('menu', ['role' => $role]);
?>
<div id="errors"></div>
<div id="purchase-entries" class="ui-widget" style="padding-top: 10px">
    <table class="ui-widget ui-widget-content">
        <tr class="ui-widget-header">
            <th>Пользователь</th>
            <th>Товар</th>
            <th>Дата покупки</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Сумма</th>
        </tr>
        <?php for($i=0; $i<sizeof($entries); $i++): ?>
        <tr>
            <?php /** @var \app\models\Purchase $purchase */
            $purchase->deployFromRow($entries[$i]); ?>
            <td><?= $purchase->username->asString() ?></td>
            <td><?= $purchase->product->asString() ?></td>
            <td><?= $purchase->date->asString('d.m.Y H:i:s') ?></td>
            <td style="text-align: right"><?= $purchase->price->asString() ?></td>
            <td style="text-align: right"><?= $purchase->quantity->asString() ?></td>
            <td style="text-align: right"><?= number_format($purchase->price->get() * $purchase->quantity->get()) ?></td>
        </tr>
        <?php endfor; ?>
    </table>
</div>
</body>
</html>
