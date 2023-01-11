<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>

<?php foreach ($models as $k => $model) { ?>
    <a href="<?php echo "./{$breadcrumbs[2]->url}/{$model->id}" ?>">
        <span class="catalog--mark drop-down">
            <div class="fiat--mark_image">
                <?php if ($model->img) { ?>
                    <img src="<?php echo $model->img ?>" onerror="this.src='https://storage.yandexcloud.net/acat/public/images/avtodiler.png'">
                <?php } else { ?>
                    <img src="https://storage.yandexcloud.net/acat/public/images/avtodiler.png">
                <?php } ?>
            </div>
            <div class="catalog--mark_name"><?php echo $model->name ?></div>
        </span>
    </a>
<?php } ?>
</body>
</html>
