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
        <input required class="search_vin" id="number" type='text' name='number' placeholder=' ' style="width: 50%;">
        <label class="form__label" for='search_vin'>Поиск по номеру (артикулу) детали</label>
        <input class="button button--green" type='submit' value="Найти">
    </form>

    <?php foreach ($models as $k => $model) {?>
        <span class="tile-block">
            <a href="/<?php echo "{$hrefPrefix}{$model->type}/SSANGYONG/{$model->short_name}" ?>">
                <div class="tile-block-image">
                    <?php if ($model->image) { ?>
                        <img src="<?php echo $model->image ?>">
                    <?php } else { ?>
                        <img src="https://acat.online/catalog-images/avtodiler.png">
                    <?php } ?>
                </div>
                <div class="tile-block-name"><?php echo $model->name ?></div>
            </a>
        </span>
    <?php } ?>

</body>
</html>
