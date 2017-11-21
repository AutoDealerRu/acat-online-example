<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php foreach ($models as $k => $model) { ?>
    <a href="<?php echo "/{$hrefPrefix}{$model->type}/{$model->brand_short_name}/{$model->short_name}" ?>">
        <span class="catalog--mark drop-down">
            <div class="fiat--mark_image">
                <?php if ($model->image) { ?>
                    <img src="<?php echo $model->image ?>">
                <?php } else { ?>
                    <img src="https://212709.selcdn.ru/autocatalog-online/public/images/avtodiler.png">
                <?php } ?>
            </div>
            <div class="catalog--mark_name"><?php echo $model->full_name ?></div>
        </span>
    </a>
<?php } ?>
</body>
</html>
