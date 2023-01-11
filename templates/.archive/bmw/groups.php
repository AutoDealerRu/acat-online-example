<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>
<h1 class="title">Основные группы деталей для <?php echo "{$breadcrumbs[2]->name} {$breadcrumbs[3]->name} ({$breadcrumbs[4]->name})" ?></h1>
<div class="etka_groups">
    <?php foreach ($groups as $group) { ?>
        <a href="<?php echo "/{$hrefPrefix}{$breadcrumbs[1]->url}/{$breadcrumbs[2]->url}/{$breadcrumbs[3]->url}/{$breadcrumbs[4]->url}/{$group->number}".($queryDate ? "?date={$queryDate}" : '')?>">
            <span class="bmw_group">
                <div class="bmw_group-image">
                    <?php if ($group->image) { ?>
                        <img src="<?php echo $group->image ?>">
                    <?php } else { ?>
                        <img src="https://acat.online/catalog-images/avtodiler.png">
                    <?php } ?>
                </div>
                <div class="bmw_group-name"><?php echo $group->name ?></div>
            </span>
        </a>
    <?php } ?>
</div>
</body>
</html>
