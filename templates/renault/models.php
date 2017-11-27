<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>

    <form class="catalog_search" method='GET' action='<?php echo "/{$hrefPrefix}{$breadcrumbs[1]->url}/{$breadcrumbs[2]->url}/search" ?>'>
        <input required class="search_vim" id="number" type='text' name='number' placeholder=' ' style="width: 50%;">
        <label class="form__label" for='search_vim'>Поиск по номеру (артикулу) детали</label>
        <input class="button button--green" type='submit' value="Найти">
    </form>

    <div class="block-body">
        <div class="block-row">
            <div class="block-options renault">
                <?php foreach ($models as $model) {
                    $url = "/{$hrefPrefix}{$model->type}/{$model->mark_short_name}/{$model->short_name}"; ?>
                    <div class="block-option">
                        <a class="block-name" href="<?php echo $url ?>"><?php echo $model->name ?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</body>
</html>
