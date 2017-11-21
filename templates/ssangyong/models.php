<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php foreach ($models as $k => $model) {?>
    <span class="tile-block">
        <a href="/<?php echo "{$hrefPrefix}{$model->type}/SSANGYONG/{$model->short_name}" ?>">
            <div class="tile-block-image">
                <?php if ($model->image) { ?>
                    <img src="<?php echo $model->image ?>">
                <?php } else { ?>
                    <img src="https://212709.selcdn.ru/autocatalog-online/public/images/avtodiler.png">
                <?php } ?>
            </div>
            <div class="tile-block-name"><?php echo $model->name ?></div>
        </a>
    </span>
<?php } ?>
</body>
</html>
