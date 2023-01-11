<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>
<h1 class="title"><?php echo $breadcrumbs[2]->name . ' ' . $breadcrumbs[5]->name . ' ' . $breadcrumbs[6]->name ?></h1>
<div class="fiat_units">
<?php foreach ($groups as $group) { ?>
    <a href='<?php echo "/{$hrefPrefix}{$group->type}/{$group->mark}/{$group->country_short}/{$group->family}/{$group->model}/{$group->modification}/{$group->group}" ?>'>
        <span class="fiat_unit">
            <div class="fiat_units_image">
                <img src="<?php echo $group->image ?>" onerror="this.src='https://acat.online/catalog-images/avtodiler.png'">
            </div>
            <div class="fiat_units_name"><?php echo $group->name ?></div>
        </span>
    </a>
<?php } ?>
</div>
</body>
</html>
