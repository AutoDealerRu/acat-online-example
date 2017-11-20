<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php foreach ($categories as $group) {
$url = "/{$hrefPrefix}{$breadcrumbs[1]->url}/{$group->mark_short_name}/{$group->model_short_name}/{$group->modification_short_name}/{$group->short_name}"; ?>
    <div class="tile-block">
        <a href="<?php echo $url ?>">
            <div class="tile-block-image">
                <?php if ($group->image) { ?>
                    <img src="<?php echo $group->image ?>">
                <?php } else { ?>
                    <img src="https://212709.selcdn.ru/autocatalog-online/public/images/avtodiler.png">
                <?php } ?>
            </div>
            <div class="tile-block-name"><?php echo $group->name ?></div>
        </a>
    </div>
<?php } ?>
</body>
</html>
