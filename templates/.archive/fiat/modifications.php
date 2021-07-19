<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>
<div class="block-list">
    <p class="fiat-row" style="position: relative; display: block; height: auto;">
        <?php foreach ($modifications as $modification) { ?>
            <a href="<?php echo "/{$hrefPrefix}{$breadcrumbs[1]->url}/{$breadcrumbs[2]->url}/{$modification->model_short_name}/{$modification->short_name}" ?>">
                <span class="list-item"><?php echo $modification->full_name ?></span>
            </a>
        <?php } ?>
    </p>
</div>
</body>
</html>
