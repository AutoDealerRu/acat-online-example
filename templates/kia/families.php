<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
    <style>
        .block-list {column-count: 3;}
        .block-list .list-item {width: 100%;}

    </style>
</head>
<body>
<div class="countries">
    <?php foreach ($countries as $index => $country) { ?>
        <a class="country <?php echo $country->country_short == $currentCountry ? 'active' : ''?>" href="/<?php echo $hrefPrefix . $country->type . '/' . $country->mark . '/' . $country->country_short ?>">
            <?php echo $country->full_name ?>
        </a>
    <?php } ?>
</div>
<div class="block-list">
    <?php foreach ($families as $item) { ?>
        <a href="<?php echo "/{$hrefPrefix}{$item->type}/{$item->mark}/{$item->country_short}/{$item->family}"?>">
                <span class="list-item">
                    <span><?php echo $item->family ?></span>
                </span>
        </a>
    <?php } ?>
</div>
</body>
</html>
