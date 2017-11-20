<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<div class="block-body">
    <div class="block-row">
        <div class="block-options renault">
            <?php foreach ($models as $model) {
                $url = "/{$hrefPrefix}{$model->type}/{$model->mark_short_name}/{$model->short_name}"; ?>
                <div class="block-option">
                    <a class="block-name" href="<?php echo $url ?>"><?php echo $model->name ?></a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>
