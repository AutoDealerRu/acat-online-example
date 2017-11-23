<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
<h1 class="title"><?php echo "{$complectation->country_short_name} {$complectation->model_name} комплектация {$complectation->model_code}"?></h1>
<h2>Информация об автомобиле</h2>
<div class="model-row">
    <div class="model-row-info">
        <ul>
            <?php if (property_exists($complectation, 'model_name') || property_exists($complectation, 'modifications')) { ?>
                <li>Модель: <b><?php echo "{$complectation->model_name} {$complectation->modifications}"?></b></li>
            <?php } ?>
            <?php if (property_exists($complectation, 'model_code')) { ?>
                <li>Код модели: <b><?php echo "{$complectation->model_code}"?></b></li>
            <?php } ?>
            <?php if (property_exists($complectation, 'engine_name')) { ?>
                <li>Двигатель: <b><?php echo "{$complectation->engine_name}"?></b></li>
            <?php } ?>
            <?php if (property_exists($complectation, 'kpp_name')) { ?>
                <li>КПП: <b><?php echo "{$complectation->kpp_name}"?></b></li>
            <?php } ?>
            <?php if (property_exists($complectation, 'body_name')) { ?>
                <li>Кузов: <b><?php echo "{$complectation->body_name}"?></b></li>
            <?php } ?>
            <?php if (property_exists($complectation, 'grade_name')) { ?>
                <li>Класс: <b><?php echo "{$complectation->grade_name}"?></b></li>
            <?php } ?>
            <?php if (property_exists($complectation, 'prod_start') || property_exists($complectation, 'prod_end')) { ?>
                <li>Период выпуска: <b>
                    <?php echo substr($complectation->prod_start, 8, 2).'.'.substr($complectation->prod_start, 5, 2).'.'.substr($complectation->prod_start, 0, 4);
                        if (property_exists($complectation,'prod_end')) echo ' - ';
                        if (property_exists($complectation,'prod_end')) echo (!$complectation->prod_end ? 'по н.в.' : substr($complectation->prod_start, 8, 2).'.'.substr($complectation->prod_start, 5, 2).'.'.substr($complectation->prod_start, 0, 4)); ?>
                    </b>
                </li>
            <?php } ?>
            <?php if (property_exists($complectation, 'other_name')) { ?>
                <li>Другое: <b><?php echo "{$complectation->other_name}"?></b></li>
            <?php } ?>
        </ul>
    </div>
</div>

<?php foreach ($groups as $group) { ?>
<div class="group">
    <div class="group-name">
        <h2><?php echo $group->name ?></h2>
    <div class="group-tile">
        <?php foreach ($group->subgroups as $subgroup) { ?>
            <span class="tile-block">
                <a href='<?php echo "/{$hrefPrefix}{$subgroup->type}/{$subgroup->mark_short_name}/{$subgroup->country_short_name}/{$subgroup->catalog_code}/{$subgroup->model_code}/{$subgroup->sysopt}/{$subgroup->complectation_code}/{$subgroup->short_name}" ?>'>
                    <div class="tile-block-image">
                        <?php if (property_exists($subgroup, 'image')) { ?>
                            <img src="<?php echo $subgroup->image ?>" onError="this.src='https://212709.selcdn.ru/autocatalog-online/public/images/avtodiler130.png'">
                        <?php } else { ?>
                            <img src="https://212709.selcdn.ru/autocatalog-online/public/images/avtodiler130.png">
                        <?php } ?>
                    </div>
                    <span class="tile-block-name"><?php echo $subgroup->name ?></span>
                </a>
            </span>
        <?php } ?>
    </div>
    </div>
</div>
<?php } ?>

</body>
</html>
