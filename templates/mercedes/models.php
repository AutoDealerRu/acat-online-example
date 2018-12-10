<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>
<table class="table">
    <thead class="table-head">
    <tr class="table-row bottom-line">
        <td class="table-cell">Модель (Код модели)</td>
        <td class="table-cell">Описание</td>
        <td class="table-cell">Период пр-ва</td>
    </tr>
    </thead>
    <tbody class="table-body">
    <?php foreach ($models as $k => $model) {?>
        <tr class="table-row bottom-line">
            <td class="table-cell">
                <a href="/<?php echo "{$hrefPrefix}{$model->type}/{$model->mark}/{$model->country}/{$model->aggregation}/{$model->model}/{$model->catalog}" ?>">
                    <?php echo "{$model->modification} ({$model->model_formatted})" ?>
                </a>
            </td>
            <td class="table-cell table-cell--name"><?php echo $model->name ?></td>
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
