<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<?php require __DIR__ . '/breadcrumbs.php'; ?>
<?php if ($mark->searchParts) { ?>
<form class="catalog_search" method='GET' action='<?php echo "$hrefPrefix/parts-search" ?>'>
    <input type="hidden" name="type" value="<?php echo $type->id ?>">
    <input type="hidden" name="mark" value="<?php echo $mark->id ?>">
    <input required class="search_vin" id="number" type='text' name='search' placeholder=' ' style="width: 50%;">
    <label class="form__label" for='search_vin'>Поиск по номеру (артикулу) или названию</label>
    <input class="button button--green" type='submit' value="Найти">
</form>
<?php } foreach ($models as $k => $model) { ?>
    <?php $modelUrl = $hrefPrefix . '/'. $type->id . '/' . $mark->id . '/' . $model->id; ?>
    <?php if (!$model->hasModifications) { $modelUrl .= '/null'; } ?>
    <a href="<?php echo $modelUrl ?>">
        <span class="catalog--mark drop-down">
            <div class="catalog--mark_image">
                <?php if ($model->image) { ?>
                    <img src="<?php echo $model->image ?>">
                <?php } else { ?>
                    <img src="https://acat.online/catalog-images/avtodiler.png">
                <?php } ?>
            </div>
            <div class="catalog--mark_description">
                <div class="catalog--mark_name"><?php echo $model->name?></div>
                <div class="catalog--mark_relevance"><?php echo $model->relevance ? 'Актуальность: ' . $model->relevance : ''?></div>
                <?php if ($model->modification) { ?>
                    <div class="catalog--mark_modif"><?php echo $model->modification ?></div>
                 <?php } ?>
            </div>
        </span>
    </a>
<?php } ?>
</body>
</html>
