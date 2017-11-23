<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <h1 class="title"><?php echo $group->name ?> для <?php echo $model->mark ?> <?php echo $model->name ?></h1>
    <div class="etka_groups">
        <?php foreach ($subgroups as $item) { ?>
            <a href="<?php echo "/{$hrefPrefix}{$item->type}/{$item->mark}/{$item->country_short_name}/{$item->model}/{$item->year}/{$item->catalog_code}/{$item->dir}/group/{$item->group}/{$item->subgroup}/{$item->detail}"?>">
                <span class="catalog--mark drop-down">
                    <div class="catalog--mark_image">
                        <?php if ($item->image) { ?>
                            <img src="<?php echo $item->image ?>">
                        <?php } else { ?>
                            <img src="https://212709.selcdn.ru/autocatalog-online/public/images/avtodiler.png">
                        <?php } ?>
                    </div>
                    <div class="catalog--mark_description">
                        <div class="catalog--mark_name"><?php echo $item->name ?></div>
                        <?php if ($item->options) { ?>
                            <div class="catalog--mark_modif"><?php echo $item->options ?> </div>
                        <?php } ?>
                    </div>
                </span>
            </a>
        <?php } ?>
    </div>
</body>
</html>
