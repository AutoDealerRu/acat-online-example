<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<div class="countries">
    <?php foreach ($countries as $index => $country) {?>
        <a class="country <?php echo $country == $currentCountry ? 'active' : ''?>" href="/<?php echo $hrefPrefix . $country->type . '/' . $country->mark . '/' . $country->country_short_name ?>">
            <?php echo $country->full_name ?>
        </a>
    <?php } ?>
</div>
<table class="table">
    <thead class="table-head">
        <tr class="table-row bottom-line">
            <td class="table-cell">Модель</td>
            <td class="table-cell">Серия</td>
            <td class="table-cell">Период пр-ва</td>
        </tr>
    </thead>
    <tbody class="table-body">
    <?php foreach ($models as $k => $model) {?>
        <tr class="table-row bottom-line">
            <td class="table-cell">
                <a href="/<?php echo $hrefPrefix . $model->type . '/' . $model->mark . '/' . $model->country_short_name . '/' . $model->directory?>">
                    <?php echo $model->model ?>
                </a>
            </td>
            <td class="table-cell"><?php echo $model->serial ?></td>
            <td class="table-cell">
                <?php echo substr($model->from_date, 8, 2).'.'.substr($model->from_date, 5, 2).'.'.substr($model->from_date, 0, 4) ?>
                <?php echo ' - '.(!$model->to_date ? 'по н.в.' : substr($model->to_date, 8, 2).'.'.substr($model->to_date, 5, 2).'.'.substr($model->to_date, 0, 4)) ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
