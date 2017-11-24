<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<h1 class="title">Основные подгруппы деталей для <?php echo "{$breadcrumbs[2]->name} {$breadcrumbs[3]->name} {$breadcrumbs[4]->name} ({$breadcrumbs[5]->name})" ?></h1>
<div class="etka_groups">
    <?php foreach ($subgroups as $subgroup) { ?>
        <a href="<?php echo "/{$hrefPrefix}{$breadcrumbs[1]->url}/{$breadcrumbs[2]->url}/{$breadcrumbs[3]->url}/{$breadcrumbs[4]->url}/{$breadcrumbs[5]->url}/{$subgroup->short_name}".($queryDate ? "?date={$queryDate}" : '')?>">
            <span class="bmw_group">
                <div class="bmw_group-image">
                    <?php if ($subgroup->image) { ?>
                        <img src="<?php echo $subgroup->image ?>">
                    <?php } else { ?>
                        <img src="https://212709.selcdn.ru/autocatalog-online/public/images/avtodiler.png">
                    <?php } ?>
                </div>
                <div class="bmw_group-name"><?php echo $subgroup->name ?></div>
            </span>
        </a>
    <?php } ?>
</div>
</body>
</html>
