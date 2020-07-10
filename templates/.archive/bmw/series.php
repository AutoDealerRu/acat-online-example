<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>

<form class="catalog_search" method='GET' action='<?php echo "/{$hrefPrefix}{$breadcrumbs[1]->url}/{$breadcrumbs[2]->url}/search" ?>'>
    <input required class="search_vim" id="number" type='text' name='number' placeholder=' ' style="width: 50%;">
    <label class="form__label" for='search_vim'>Поиск по номеру (артикулу) детали</label>
    <input class="button button--green" type='submit' value="Найти">
</form>

<?php foreach ($series as $k => $seria) {?>
    <span class="tile-block">
        <a href="/<?php echo "{$hrefPrefix}{$seria->type}/{$seria->mark_short_name}/{$seria->short_name}" ?>">
            <div class="tile-block-image">
                <?php if ($seria->image) { ?>
                    <img src="<?php echo $seria->image ?>">
                <?php } else { ?>
                    <img src="https://storage.yandexcloud.net/acat/public/images/avtodiler.png">
                <?php } ?>
            </div>
            <div class="tile-block-name" style="min-height: 75px;"><?php echo $seria->name ?></div>
            <div class="tile-block-option" style="<?php echo $seria->catalog_type == 'VT' ? 'background: white;' : '' ?>">
                <span><?php echo $seria->catalog_type == 'VT' ? '' : 'Живая традиция' ?></span>
            </div>
        </a>
    </span>
<?php } ?>
</body>
</html>
