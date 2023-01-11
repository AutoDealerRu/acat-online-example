<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.7.2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.number-info-cell label').click(function () {
                var top = $(this).offset().top - $(document).scrollTop();
                var bottom = $(window).height() - top - $(this).height();
                $('.modal-number-info').hide();

                var info = $(this).parent().find('.modal-number-info');
                info.parent().addClass('active');
                if (top < bottom) {
                    info.removeClass('top').addClass('bottom').find('.number-info-cell').css('max-height', bottom - 10);
                } else {
                    info.removeClass('bottom').addClass('top').find('.number-info-cell').css('max-height', top - 10);
                }
                info.show();
            });
            $(document).mouseup(function(e) {
                var container = $(".number-info-cell .modal-number-info");
                if (!container.is(e.target) && container.has(e.target).length === 0) container.hide().parent().removeClass('active');
            });
            $('.modal-number-info-close').click(function () {
                $(this).closest('.modal-number-info').hide().parent().removeClass('active');
            });
        });
    </script>
    <style>.number-info-cell.active {z-index: 3 !important;}</style>
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
                <li>Модификация: <b><?php echo $modification->name ?></b></li>
            <?php } ?>
            <?php if ($modification->year) { ?>
                <li>Год: <b><?php echo $modification->year ?></b></li>
            <?php } ?>
            <?php if ($modification->region) { ?>
                <li>Регион: <b><?php echo $modification->region ?></b></li>
            <?php } ?>
            <?php if ($modification->steering) { ?>
                <li><b><?php echo $modification->steering ?></b></li>
            <?php } ?>
        </ul>
    </span>
    <?php if ($modification->description) { ?>
    <span class="a2d--model_info" style='vertical-align: top; margin: 0 24px;'>
        <span style='line-height: 26px;'>
            <?php echo preg_replace('/\;[\s]{0,}/', '<br>', preg_replace('/(\n)/', '<br>', $modification->description)) ?>
        </span>
    </span>
    <?php } ?>
</div>

<div class="fiat_units">
    <?php foreach ($groups as $index => $gr) {
        $url = (!$group ? ('./' . $breadcrumbs[4]->url . '/' . $gr->id) : ( !$gr->hasSubgroups ? ( ('./' . $gr->parentId . '/' . $gr->id) ) : './' . $gr->id)) . ($criteria ? ('?criteria='.urlencode($criteria)) : '');
        ?>
        <div style="position: relative;display: inline-block; vertical-aligt: top;">
            <a href="<?php echo $url ?>" style="display: inline-block;margin: 13px">
                <span class="fiat_unit" style='margin: 0'>
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
            <?php if (property_exists($gr, 'description') && $gr->description) { ?>
                <div class="number-info-cell" data-number-info="<?php echo $index?>" style='position: absolute; right: 30px; top: 30px; z-index: 2;'>
                    <input id="input<?php echo $index?>" type="checkbox">
                    <label for="input<?php echo $index?>"></label>
                    <div class="modal-number-info" style='max-width: 350px;'>
                        <span class="modal-number-info-close"></span>
                        <div class="number-info" style='border-radius: 8px'>
                            <?php echo str_replace("\n", "<br>", $gr->description); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
</body>
</html>
