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

<?php require __DIR__ . '/breadcrumbs.php'; ?>

<div class="a2d--model">
    <span class="a2d--model_image">
        <?php if ($model->image) { ?>
            <img src="<?php echo $model->image ?>">
        <?php } else { ?>
            <img src="https://acat.online/catalog-images/avtodiler.png">
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
    <?php
    $folderImagePath = 'https://storage.yandexcloud.net/acat/public/images/folder.jpg';
    $otherImagePath = 'https://acat.online/catalog-images/avtodiler.png';
    foreach ($groups as $index => $gr) {
        $url = "{$hrefPrefix}/{$type->id}/{$mark->id}/{$model->id}";
        if ($modification) $url .= "/{$modification->id}";
        if ($gr->hasSubgroups) {
            $url .= "/{$gr->id}";
        } else if ($gr->hasParts) {
            $url .= "/{$gr->parentId}/{$gr->id}";
        }
        if ($criteria64) $url .= '?criteria64='.$criteria64;
        ?>
        <div class="fiat_units-block">
            <a href="<?php echo $url ?>">
                <span class="fiat_unit m-0">
                    <div class="fiat_units_image">
                        <?php if ($gr->image) { ?>
                            <img src="<?php echo $gr->image ?>" style="max-height: 135px;" onerror="this.src = '<?php echo $gr->hasSubgroups ? $folderImagePath : $otherImagePath?>'">
                        <?php } elseif($gr->hasSubgroups) { ?>
                            <img src="<?php echo $folderImagePath ?>">
                        <?php } else { ?>
                            <img src="<?php echo $otherImagePath ?>">
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
