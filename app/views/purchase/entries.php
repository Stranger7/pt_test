<?php
/**
 * @var array $entries
 */
?>
<button onclick="Purchase.create();">Купить</button>
<table class="ui-widget ui-widget-content">
    <tr class="ui-widget-header">
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
        <td><?= $purchase->product->asString() ?></td>
        <td><?= $purchase->date->asString('d.m.Y H:i:s') ?></td>
        <td style="text-align: right"><?= $purchase->price->asString() ?></td>
        <td style="text-align: right"><?= $purchase->quantity->asString() ?></td>
        <td style="text-align: right"><?= number_format($purchase->price->get() * $purchase->quantity->get()) ?></td>
    </tr>
<?php endfor; ?>
</table>
<script>

</script>