<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="/js/jquery.arcticmodal-0.3.min.js"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.js-modal-init', function (e) {
                var modalName = $(this).data('modal');
                var modelYear = $(this).data('year');
                var modelOption = $(this).data('option');
                e.preventDefault();
                $('.slider-arrow-wrap__container div').remove();

                if (modalName == 'year' && modelYear) {
                    console.log(modelYear);
                    $("div").find("[data-modal_year='" + modelYear + "']").arcticmodal();
                } else if (modalName == 'option' && modelOption) {
                    $("div").find("[data-modal_option='" + modelOption + "']").arcticmodal();
                } else {
                    $("#" + modalName + "-modal").arcticmodal();
                }
                return false;
            });
            $('form .to-group').click(function (event) {
                event.preventDefault();
                var option = $('.arcticmodal-container input.option-value:checked').val();
                var date = $(this).data('value');
                if (date) {
                    window.location = option + '?date=' + date;
                } else {
                    window.location = option;
                }
            });
            $('form .button-to-groups').click(function (event) {
                event.preventDefault();
                window.location = $('.arcticmodal-container input.option-value:checked').val();
            });
            $('form .button-to-option ').click(function (event) {
                event.preventDefault();
                $('.arcticmodal-container form.options').show();
                $('.arcticmodal-container form.model-year-month').hide();
            });
            $('form .button-option').click(function (event) {
                event.preventDefault();
                $('.arcticmodal-container form.options').hide();
                $('.arcticmodal-container form.model-year-month').show();
            });
        });
    </script>
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>
<div class="bmw-block-body">
    <?php foreach ($categories as $key1 => $category) { ?>
        <div class="block-row">
        <span class="block-image">
            <?php if ($category->image) { ?>
                <img src="<?php echo $category->image ?>">
            <?php } else { ?>
                <img src="https://212709.selcdn.ru/autocatalog-online/public/images/avtodiler.png">
            <?php } ?>
            <div class="block-name"><?php echo $category->name ?></div>
        </span>
        <span class="block-lines">
            <?php foreach ($category->markets as $key2 => $market) { ?>
                <div class="block-line" style="<?php echo $key2 === 0 ? 'min-height: 130px;':'' ?>">
                    <div class="block-name"><?php echo $market->name ?></div>
                    <div class="block-options">
                    <?php foreach ($market->models as $key3 => $model) { ?>
                        <span class="block-option js-modal-init" data-modal='option' data-option="<?php echo "{$key1}-{$key2}-{$key3}"?>"><?php echo $model->name ?></span>
                        <div class="hidden">
                            <div class="modal-pin box-modal" id="option-modal" data-modal_option="<?php echo "{$key1}-{$key2}-{$key3}"?>">
                                <div class="box-modal_close arcticmodal-close"></div>
                                <div class="modal-option">
                                    <form class="options" id="options" action="" method="post">
                                        <h2 class="title title--center" style="font-size: 22px;">Выберите опцию</h2>
                                        <?php foreach ($model->options as $key4 => $option) { ?>
                                        <div class="option">
                                            <input class="option-value" <?php echo $key4 === 0 ? 'checked' : '' ?> id="option<?php echo "{$key1}-{$key2}-{$key3}-{$key4}" ?>"  name="option" type="radio" value="<?php echo "/{$hrefPrefix}{$breadcrumbs[1]->url}/{$breadcrumbs[2]->url}/{$model->series_short_name}/{$model->short_name}/{$option->rule_position}/{$option->transmissions[0]}"?>"/>
                                            <label for="option<?php echo "{$key1}-{$key2}-{$key3}-{$key4}" ?>" style="padding-left: 10px;">
                                                <?php echo ($option->rule_position === 'LEFT' ? 'Левый руль' : 'Правый руль').' / '.($option->transmissions[0] === 'AUTO' ? 'АКПП' : 'МКПП') ?>
                                            </label>
                                        </div>
                                        <?php } ?>
                                        <div class="button button--center button--green-border button-option">Выбрать</div>
                                    </form>
                                    <form class="model-year-month">
                                        <h2 class="title title--center" style="font-size: 22px;">Выберите дату производства</h2>
                                        <?php
                                            $start = (int) substr($model->date_start, 0, 4); //YYYY
                                            $startM = (int) substr($model->date_start, 5, 2); //MM
                                            $end = (int) substr($model->date_end, 0, 4); //YYYY
                                            $endM = (int) substr($model->date_end, 5, 2); //
                                            $y = $start;
                                        ?>
                                        <div class="years">
                                            <?php while ($y <= $end) { ?>
                                                <div class="year-line">
                                                    <span class="year to-group" data-value="<?php echo $y ?>"><?php echo $y ?></span>
                                                    <span class="months">
                                                        <?php
                                                        if ($y == $start) $m = (int) $startM;
                                                        else $m = 1;
                                                        if ($y == $end) $mn = $endM;
                                                        else $mn = 12;
                                                        while ($m <= $mn) { ?>
                                                            <span class="month to-group" data-value="<?php echo "{$y}"?>"><?php echo $m < 10 ? '0'.$m : $m ?></span>
                                                        <?php $m++;}?>
                                                    </span>
                                                </div>
                                            <?php $y++;} ?>
                                        </div>
                                        <div class="buttons">
                                            <span class="button button--green-border button-to-option">к опциям</span>
                                            <span class="button button--green-border button-to-option">не важно</span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </span>
    <?php } ?>
</div>
</body>
</html>
