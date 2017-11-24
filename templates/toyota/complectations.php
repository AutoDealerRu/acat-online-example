<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<h1 class="title"><?php echo "Запчасти для {$mark} {$model}, список комплектаций ({$country})"?></h1>
<table class="table">
    <thead class="table-head">
    <tr class="table-row bottom-line">
        <td class="table-cell">Комплектация</td>
        <td class="table-cell">Производство</td>
        <td class="table-cell">Двигатель</td>
        <td class="table-cell">Кузов</td>
        <td class="table-cell">Класс</td>
        <td class="table-cell">КПП</td>
        <td class="table-cell">Другое</td>
    </tr>
    </thead>
    <tbody class="table-body">
    <?php foreach ($complectations as $item) {?>
        <tr class="table-row bottom-line">
            <td class="table-cell">
                <a href="/<?php echo $hrefPrefix . $item->type . '/' . $item->mark_short_name . '/' . $item->country_short_name . '/' . $item->catalog_code . '/' . $item->model_code . '/' . $item->sysopt . '/' . $item->complectation_code ?>">
                    <?php echo $item->model_code ?>
                </a>
            </td>
            <td class="table-cell">
                <?php echo substr($item->prod_start, 8, 2).'.'.substr($item->prod_start, 5, 2).'.'.substr($item->prod_start, 0, 4) ?>
                <?php echo ' - '.(!$item->prod_end ? 'по н.в.' : substr($item->prod_end, 8, 2).'.'.substr($item->prod_end, 5, 2).'.'.substr($item->prod_end, 0, 4)) ?>
            </td>
            <td class="table-cell"><?php echo $item->engine_short_name ?></td>
            <td class="table-cell"><?php echo $item->body_short_name ?></td>
            <td class="table-cell"><?php echo $item->grade_short_name ?></td>
            <td class="table-cell"><?php echo $item->kpp_short_name ?></td>
            <td class="table-cell"><?php echo $item->other_short_name ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<h2>Расшифровка сокращений:</h2>
<table class="table">
    <thead class="table-head">
        <tr class="table-row bottom-line">
            <td class="table-cell" style='width: 20%'></td>
            <td class="table-cell" style="vertical-align: top; padding: 0;">
                <table class="table table-child" style='border-left: none;'>
                    <thead class="table-head">
                        <tr class="table-row bottom-line">
                            <td class="table-cell" style='width: 20%'>Сокращение</td>
                            <td class="table-cell">Расшифровка</td>
                        </tr>
                    </thead>
                </table>
            </td>
        </tr>
    </thead>
    <tbody class="table-body">
    <?php foreach ($abbreviations as $group) { ?>
        <tr class="table-row bottom-line">
            <td class="table-cell"><?php echo $group->type_name ?></td>
            <td class="table-cell" style="vertical-align: top; padding: 0;">
                <table class="table table-child">
                    <tbody class="table-body">
                    <?php foreach ($group->items as $item) {?>
                        <tr class="table-row bottom-line">
                            <td class="table-cell" style="width: 20%; padding: 5px 5px 5px 20px;"><?php echo $item->sign ?></td>
                            <td class="table-cell" style="padding: 5px 5px 5px 20px;"><?php echo $item->description ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</body>
</html>
