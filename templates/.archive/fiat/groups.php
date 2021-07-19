<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>
<div class="fiat_units">
    <?php foreach ($units as $group) { ?>
        <a href="<?php echo "/{$hrefPrefix}{$breadcrumbs[1]->url}/{$breadcrumbs[2]->url}/{$breadcrumbs[3]->url}/{$breadcrumbs[4]->url}/{$group->short_name}" ?>">
            <span class="fiat_unit">
                <div class="fiat_units_image">
                    <?php if ($group->image) { ?>
                        <img src="<?php echo $group->image ?>">
                    <?php } else { ?>
                        <img src="https://storage.yandexcloud.net/acat/public/images/avtodiler.png">
                    <?php } ?>
                </div>
                <div class="fiat_units_name"><?php echo $group->full_name ?></div>
            </span>
        </a>
    <?php } ?>
</div>
</body>
</html>
