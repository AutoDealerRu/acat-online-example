<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>
    <?php require __DIR__ . '/../breadcrumbs.php'; ?>
    <h1 class="title">Основные группы деталей для <?php echo $model->name ?></h1>
    <div class="etka_groups">
        <?php foreach ($groups as $item) { ?>
            <a href="<?php echo "/{$hrefPrefix}{$item->type}/{$item->mark}/{$item->country_short_name}/{$item->model}/{$item->year}/{$item->catalog_code}/{$item->dir}/group/{$item->group}"?>">
                <span class="etka_group etka_group-model">
                    <div class="etka_group-image">
                        <?php if ($item->image) { ?>
                            <img src="<?php echo $item->image ?>">
                        <?php } else { ?>
                            <img src="https://acat.online/catalog-images/avtodiler.png">
                        <?php } ?>
                    </div>
                    <div class="etka_group-name"><?php echo $item->name ?></div>
                </span>
            </a>
        <?php } ?>
    </div>
    <h2 class="title" style='margin-top: 47px;'>Расходные материалы</h2>
    <div class="etka_groups">
        <?php foreach ($services as $service) { ?>
            <a href="<?php echo "/{$hrefPrefix}{$service->type}/{$service->mark}/{$service->country_short_name}/{$service->model}/{$service->year}/{$service->catalog_code}/{$service->dir}/service/{$service->service}"?>">
                <span class="etka_group etka_group-model">
                    <div class="etka_group-image">
                        <img src="https://acat.online/catalog-images/avtodiler.png">
                    </div>
                    <div class="etka_group-name"><?php echo $service->name ?></div>
                </span>
            </a>
        <?php } ?>
    </div>
</body>
</html>
