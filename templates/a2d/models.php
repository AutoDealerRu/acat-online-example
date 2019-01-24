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
    <label class="form__label" for='search_vim'>Поиск по номеру (артикулу)</label>
    <input class="button button--green" type='submit' value="Найти">
</form>
<?php if (!$isSKD) { foreach ($models as $k => $model) {?>
    <a href="/<?php echo $hrefPrefix . $mark->type . '/' . $mark->short_name . '/' . $model->short_name ?>">
        <span class="catalog--mark drop-down">
            <div class="catalog--mark_image">
                <?php if ($model->image) { ?>
                    <img src="<?php echo $model->image ?>">
                <?php } else { ?>
                    <img src="https://212709.selcdn.ru/autocatalog-online/public/images/avtodiler.png">
                <?php } ?>
            </div>
            <div class="catalog--mark_description">
                <div class="catalog--mark_name"><?php echo $model->name_with_mark?></div>
                <div class="catalog--mark_relevance"><?php echo $model->relevance ? 'Актуальность: ' . substr($model->relevance, 5, 2).'.'.substr($model->relevance, 0, 4) : ''?></div>
                <?php if ($model->modification) { ?>
                    <div class="catalog--mark_modif"><?php echo $model->modification ?></div>
                 <?php } ?>
            </div>
        </span>
    </a>
<?php } ?>
<?php } else { ?>
    <table class="table table-search active">
        <thead class="table-head">
            <tr class="table-row bottom-line">
                <td class="table-cell">Название</td>
                <td class="table-cell">Описание</td>
                <td class="table-cell">Период пр-ва</td>
                <td class="table-cell">Актуальность</td>
            </tr>
        </thead>
        <tbody class="table-body">
            <?php foreach ($models as $k => $model) { ?>
                <tr class="table-row bottom-line">
                    <td class="table-cell">
                        <a href="/<?php echo $hrefPrefix . $mark->type . '/' . $mark->short_name . '/' . $model->short_name ?>"><?php echo $model->name?></a>
                    </td>
                    <td class="table-cell"><?php echo $model->modification ?></td>
                    <td class="table-cell"><?php echo $model->years ?></td>
                    <td class="table-cell">
                        <?php if ($model->relevance) {
                            echo substr($model->relevance, 5, 2).'.'.substr($model->relevance, 0, 4);
                        } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
</body>
</html>
