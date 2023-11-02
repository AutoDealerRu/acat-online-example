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
<?php require __DIR__ . '/../breadcrumbs.php'; ?>

    <form class="catalog_search" method='GET' action='<?php echo "/{$hrefPrefix}{$breadcrumbs[1]->url}/{$breadcrumbs[2]->url}/search" ?>'>
        <input required class="search_vin" id="number" type='text' name='number' placeholder=' ' style="width: 50%;">
        <label class="form__label" for='search_vin'>Поиск по номеру (артикулу) детали</label>
        <input class="button button--green" type='submit' value="Найти">
    </form>

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
