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
    <?php foreach ($subgroups as $item) { ?>
        <a href='<?php echo "/{$hrefPrefix}{$item->type}/{$item->mark}/{$item->country_short}/{$item->family}/{$item->model}/{$item->modification}/{$item->group}/{$item->subgroup}" ?>'>
        <span class="fiat_unit">
            <div class="fiat_units_image">
                <img src="<?php echo $item->image ?>" onerror="this.src='https://acat.online/catalog-images/avtodiler.png'">
            </div>
            <div class="fiat_units_name"><?php echo $item->name ?></div>
        </span>
        </a>
    <?php } ?>
</div>
</body>
</html>
