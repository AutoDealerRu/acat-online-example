<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>
<?php foreach ($models as $model) { ?>
<a href='<?php echo "/{$hrefPrefix}{$model->type}/{$model->mark}/{$model->country_short}/{$model->family}/{$model->model}" ?>'>
    <span class="catalog--mark drop-down">
        <div class="catalog--mark_image">
            <img src="<?php echo $model->image ?>" onerror="this.src='https://212709.selcdn.ru/autocatalog-online/public/images/avtodiler.png'">
        </div>
        <div class="catalog--mark_description">
            <div class="catalog--mark_name"><?php echo $model->model_name ?></div>
            <div class="catalog--mark_relevance">Актуальность:
                <?php echo substr($model->from_date, 8, 2).'.'.substr($model->from_date, 5, 2).'.'.substr($model->from_date, 0, 4);
                if (property_exists($model,'to_date')) echo ' - ';
                if (property_exists($model,'to_date')) echo (!$model->to_date ? 'по н.в.' : substr($model->to_date, 8, 2).'.'.substr($model->to_date, 5, 2).'.'.substr($model->to_date, 0, 4)); ?>
            </div>
        </div>
    </span>
</a>
<?php } ?>
</body>
</html>
