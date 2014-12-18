<?php /** @var array $entries */ ?>
<table class="ui-widget ui-widget-content">
    <tr class="ui-widget-header">
        <th>Наименование</th>
        <th>Описание</th>
        <th>Цена</th>
        <th>Остаток</th>
        <th width="1%"><button onclick="Product.create();">Добавить</button></th>
    </tr>
<?php for($i=0; $i<sizeof($entries); $i++): ?>
    <tr>
        <td><?= $entries[$i]['name'] ?></td>
        <td><?= $entries[$i]['description'] ?></td>
        <td style="text-align: right"><?= $entries[$i]['price'] ?></td>
        <td style="text-align: right"><?= $entries[$i]['quantity'] ?></td>
        <td><button onclick="Product.load(<?= $entries[$i]['id'] ?>)">Редактировать</button></td>
    </tr>
<?php endfor; ?>
</table>
<script>

</script>