<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>
<div class="block-body">
    <div class="block-row">
        <div class="block-options renault">
            <?php foreach ($modifications as $modification) {
                $url = "/{$hrefPrefix}{$breadcrumbs[1]->url}/{$modification->mark_short_name}/{$modification->model_short_name}/{$modification->short_name}"; ?>
                <div class="block-option">
                    <a class="block-name" href="<?php echo $url ?>"><?php echo $modification->name ?></a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>
