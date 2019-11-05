<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
</head>
<body>

<!--Крошки-->
<?php if ($breadcrumbs) { ?>
    <div class="breadcrumbs">
        <?php foreach ($breadcrumbs as $index => $breadcrumb) {
            if ($index != (count($breadcrumbs)-1)) {
                if ($index > 0) {
                    $breadcrumbUrl = "{$hrefPrefix}/";
                    $i = 1;
                    while ($i < ($index+1)) {
                        $breadcrumbUrl .= $breadcrumbs[$i]->url."/";
                        $i++;
                    }
                    $breadcrumbUrl = preg_replace("/\/$/", "", $breadcrumbUrl);
                    $breadcrumbUrl = preg_replace("/^\/\//", "/", $breadcrumbUrl); ?>
                    <a href="<?php echo $breadcrumbUrl ?>"><?php echo $breadcrumb->name ?></a>
                <?php } else {
                    $breadcrumbUrl = "{$hrefPrefix}/" . preg_replace("/^\//", "", $breadcrumb->url); ?>
                    <a href="<?php echo $breadcrumbUrl ?>"><?php echo $breadcrumb->name ?></a>
                <?php }
            } elseif ($breadcrumb->name && !$group) { ?>
                <span class="breadcrumbs_current"><?php echo $breadcrumb->name ?></span>
            <?php } else { ?>
                <a href="../<?php echo $breadcrumb->url ?>"><?php echo $breadcrumb->name ?></a>
            <?php }
        } ?>
    </div>
<?php } ?>
<!--Крошки-->

<div class="a2d--model">
    <span class="a2d--model_image">
        <?php if ($model->img) { ?>
            <img src="<?php echo $model->img ?>">
        <?php } else { ?>
            <img src="https://storage.yandexcloud.net/acat/public/images/avtodiler.png">
        <?php } ?>
    </span>
    <span class="a2d--model_info" style='vertical-align: top; margin: 0 24px;'>
        <ul>
            <li>Модель: <b><?php echo $model->name ?></b></li>
            <?php if ($modification->name) { ?>
                <li>Модификации: <b><?php echo $modification->name ?></b></li>
            <?php } ?>
            <?php if ($modification->year) { ?>
                <li>Модификации: <b><?php echo $modification->year ?></b></li>
            <?php } ?>
            <?php if ($modification->region) { ?>
                <li>Модификации: <b><?php echo $modification->region ?></b></li>
            <?php } ?>
            <?php if ($modification->steering) { ?>
                <li><b><?php echo $modification->steering ?></b></li>
            <?php } ?>
        </ul>
    </span>
    <?php if ($modification->description) { ?>
    <span class="a2d--model_info" style='vertical-align: top; margin: 0 24px;'>
        <span style='line-height: 26px;'>
            <?php echo preg_replace('/\n/', '<br>', $modification->description) ?>
        </span>
    </span>
    <?php } ?>
</div>

<div class="fiat_units">
    <?php foreach ($groups as $gr) {
        $url = (!$group ? ('./' . $breadcrumbs[4]->url . '/' . $gr->id) : ( !$gr->hasSubgroups ? ( ('./' . $gr->parentId . '/' . $gr->id) ) : './' . $gr->id)) . ($criteria ? ('?criteria='.$criteria) : '');
        ?>
        <a href="<?php echo $url ?>">
            <span class="fiat_unit">
                <div class="fiat_units_image">
                    <?php if ($gr->img) { ?>
                        <img src="<?php echo $gr->img ?>" style="max-height: 135px;">
                    <?php } elseif($gr->hasSubgroups) { ?>
                        <img src="https://storage.yandexcloud.net/acat/public/images/folder.jpg">
                    <?php } else { ?>
                        <img src="https://storage.yandexcloud.net/acat/public/images/avtodiler.png">
                    <?php } ?>
                </div>
                <div class="fiat_units_name"><?php echo $gr->name ?></div>
            </span>
        </a>
    <?php } ?>
</div>
</body>
</html>
