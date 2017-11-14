<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php foreach ($models as $k => $model) {?>
    <a href="/<?php echo $hrefPrefix . $mark->type . '/' . $mark->short_name . '/' . $model->short_name ?>">
        <span class="catalog--mark drop-down">
            <div class="catalog--mark_image">
                <?php if ($model->image) { ?>
                    <img src="<?php echo $model->image ?>">
                <?php } else { ?>
                    <img src="https://212709.selcdn.ru/autocatalog-online/public/images/avtodiler.png">
                <?php } ?>
            </div>
            <div class="catalog--mark_description">
                <div class="catalog--mark_name"><?php echo $model->name_with_mark?></div>
                <div class="catalog--mark_relevance"><?php echo $model->relevance ? 'Актуальность: ' . substr($model->relevance, 5, 2).'.'.substr($model->relevance, 0, 4) : ''?></div>
                <?php if ($model->modification) { ?>
                    <div class="catalog--mark_modif"><?php echo $model->modification ?></div>
                 <?php } ?>
            </div>
        </span>
    </a>
<?php } ?>
</body>
</html>
