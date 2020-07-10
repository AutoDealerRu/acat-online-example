<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        .block-list {column-count: 3;}
        .block-list .list-item {width: 100%;}

    </style>
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>
    <h1 class="title"><?php echo $service->name ?> для <?php echo $model->mark ?> <?php echo $model->name ?></h1>
    <div class="block-list">
        <?php foreach ($subservices as $item) { ?>
            <a href="<?php echo "/{$hrefPrefix}{$item->type}/{$item->mark}/{$item->country_short_name}/{$item->model}/{$item->year}/{$item->catalog_code}/{$item->dir}/service/{$item->service}/{$item->subservice}"?>">
                <span class="list-item">
                    <span><?php echo $item->name ?></span>
                </span>
            </a>
        <?php } ?>
    </div>
</body>
</html>
