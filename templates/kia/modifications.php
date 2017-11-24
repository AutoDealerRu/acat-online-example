<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<h1 class="title"><?php echo $breadcrumbs[2]->name . $breadcrumbs[5]->name ?></h1>
<table class="table">
    <thead class="table-head">
    <tr class="table-row bottom-line">
        <td class="table-cell">Модификация</td>
        <td class="table-cell">Период пр-ва</td>
        <td class="table-cell">Кузов</td>
        <td class="table-cell">Класс</td>
        <td class="table-cell">Рабочий обьем двигателя</td>
        <td class="table-cell">Топливо</td>
        <td class="table-cell">Трансмиссия</td>
        <td class="table-cell">Двигатель</td>
    </tr>
    </thead>
    <tbody class="table-body">
    <?php foreach ($modifications as $index => $item) { ?>
        <tr class="table-row bottom-line">
            <td class="table-cell">
                <a href='<?php echo "/{$hrefPrefix}{$item->type}/{$item->mark}/{$item->country_short}/{$item->family}/{$item->model}/{$item->modification}" ?>'><?php echo $item->modification ?></a>
            </td>
            <td class="table-cell">
                <?php echo substr($item->from_date, 8, 2).'.'.substr($item->from_date, 5, 2).'.'.substr($item->from_date, 0, 4);
                if (property_exists($item,'to_date')) echo ' - ';
                if (property_exists($item,'to_date')) echo (!$item->to_date ? 'по н.в.' : substr($item->to_date, 8, 2).'.'.substr($item->to_date, 5, 2).'.'.substr($item->to_date, 0, 4)); ?>
            </td>
            <td class="table-cell"><?php echo (property_exists($item,'body')) ? $item->body : ' - '; ?></td>
            <td class="table-cell"><?php echo (property_exists($item,'class')) ? $item->class : ' - '; ?></td>
            <td class="table-cell"><?php echo (property_exists($item,'engine_displacement')) ? $item->engine_displacement : ' - '; ?></td>
            <td class="table-cell"><?php echo (property_exists($item,'fuel')) ? $item->fuel : ' - '; ?></td>
            <td class="table-cell"><?php echo (property_exists($item,'transmission')) ? $item->transmission : ' - '; ?></td>
            <td class="table-cell"><?php echo (property_exists($item,'engine')) ? $item->engine : ' - '; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
