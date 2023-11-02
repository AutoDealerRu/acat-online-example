<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo isset($hrefPrefix) ? $hrefPrefix : '' ?>/styles.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.7.2.min.js"></script>
    <style>
        span.modal-vin-info-close {
            position: absolute;
            right: 15px;
            top: 15px;
            z-index: 10;
            cursor: pointer;
            height: 16px;
            width: 16px;
            background-image: url(https://storage.yandexcloud.net/acat/public/images/info-close.png);
            background-size: 16px 16px;
        }
    </style>
</head>
<body>
<div class="breadcrumbs"><a href="<?php echo $hrefPrefix ?: '/'?>">Каталог</a></div>
<h1 class="title">Результаты поиска</h1>
<form class="catalog_search" method='GET' action='<?php echo "/{$hrefPrefix}search" ?>'>
    <input class="hidden" id='search-info' type="checkbox">
    <label class="search-info-icon" for='search-info'>i</label>
    <div class="search-info modal-number-info">
        <span class="modal-vin-info-close"></span>
        <div class="number-info">
            <p>Поиск по марке: цифры, латиница/кириллица. Поиск иномарок на кириллице (бмв, хендай и др.)</p>
            <p>Поиск по модели: цифры, латиница/кириллица</p>
            <p>Поиск по VIN/кузову: марки Abarth, Alfa-Romeo, Fiat, Lancia, Audi, Skoda, Seat, Volkswagen, Bmw, Mini, Rolls-Royce, Kia, Hyundai, Nissan, Infinity, Toyota, Lexus</p>
        </div>
    </div>
    <input required class="search_vin" id="search_vin" type='text' name='text' placeholder=' ' value="<?php echo isset($searchValue) ? $searchValue : '' ?>">
    <label class="form__label" for='search_vin'>Поиск по VIN, кузову, марке или модели</label>
    <input class="button button--green" type='submit' value="Найти">
</form>
<?php if (isset($error) && $error) { ?>
    <h1 style="color: red;"><?php echo $error ?></h1>
<?php } elseif (isset($vins) && is_array($vins) && count($vins) > 0) {
    $paramKeys = [];
    foreach ($vins as $vin) {
        if (property_exists($vin, 'parameters') && count($vin->parameters) > 0) {
            foreach ($vin->parameters as $p) {
                if ($p->key === 'modification') continue;
                $pp = null;
                foreach($paramKeys as $pr) {
                    if ($pr->key === $p->key) {
                        $pp = $pr;
                        break;
                    }
                }
                if (!$pp) {
                    $tt = new stdClass();
                    $tt->key = $p->key;
                    switch ($p->name) {
                        case 'Рулевое управление': $tt->name = 'Рул. упр.';break;
                        case 'Тип коробки передач': $tt->name = 'ТИП КП';break;
                        default: $tt->name = $p->name;
                    }
                    $paramKeys[] = $tt;
                }
                $pKey = $p->key;
                $pValue = $p->value;
                $vin->$pKey = $pValue;
            }
        }
    }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.number-info-cell label').click(function () {
                var top = $(this).offset().top - $(document).scrollTop();
                var bottom = $(window).height() - top - $(this).height();
                $('.modal-number-info').hide();

                var info = $(this).parent().find('.modal-number-info');
                if (top < bottom) {
                    info.removeClass('top').addClass('bottom').find('.number-info-cell').css('max-height', bottom - 10);
                } else {
                    info.removeClass('bottom').addClass('top').find('.number-info-cell').css('max-height', top - 10);
                }
                info.show();
            });


            $(document).mouseup(function(e) {
                var container = $(".number-info-cell .modal-number-info");
                if (!container.is(e.target) && container.has(e.target).length === 0) container.hide();
            });

            $('.modal-number-info-close').click(function () {
                $(this).closest('.modal-number-info').hide();
            });
        });
    </script>
    <table class="table">
        <thead class="table-head">
            <tr class="table-row">
                <td class="table-cell">Обозначение модели</td>
                <?php foreach ($paramKeys as $param) { ?>
                <td class="table-cell"><?php echo $param->name?></td>
                <?php } ?>
            </tr>
        </thead>
        <tbody class="table-body">
        <?php foreach ($vins as $index => $vin) {
            $url = "{$hrefPrefix}/{$vin->type}/{$vin->mark}/{$vin->model}/{$vin->modification}?criteria=$vin->criteriaURI"; ?>
            <tr class="table-row">
                <td class="table-cell">
                    <a href="<?php echo $url?>"><?php echo $vin->modelName ?></a>
                    <?php if (property_exists($vin, 'optionCodes') && count($vin->optionCodes) > 0) { ?>
                    <div class="number-info-cell" data-number-info="<?php echo $index ?>" style='display: inline-block; margin-left: 16px; vertical-align: middle;'>
                        <input id='input<?php echo $index ?>' type="checkbox"/>
                        <label for='input<?php echo $index ?>'></label>
                        <div class="modal-number-info">
                            <span class="modal-number-info-close"></span>
                            <div class="number-info" style='max-height: 300px; overflow-y: auto;'>
                                <?php foreach ($vin->optionCodes as $c) { ?>
                                    <div class="number-info-params"><?php echo $c->code.': '?>
                                        <b><?php echo $c->description?></b>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="ico"><svg width="20" height="10"><polyline points="0,0 10,10 20,0" stroke="#278ece" fill="white"></polyline></svg></div>
                        </div>
                    </div>
                    <?php } ?>
                </td>
                <?php foreach ($paramKeys as $param) { ?>
                <td class="table-cell">
                    <?php $pKey = $param->key; if (property_exists($vin, $pKey)) {
                        echo $vin->$pKey;
                    } ?>
                </td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } elseif  (isset($marks) && is_array($marks) && count($marks) > 0) { ?>
    <?php

    $otherImagePath = 'https://acat.online/catalog-images/avtodiler.png';
    foreach ($marks as $i => $item) {
        $url = "{$hrefPrefix}/{$item->type->id}/{$item->mark->id}/{$item->model->id}";
        if (!$item->model->hasModifications) $url .= '/null';
    ?>
    <a href="<?php echo $url ?>">
        <span class="catalog--mark drop-down">
            <div class="catalog--mark_image">
                <?php if ($item->model->image) { ?>
                    <img src="<?php echo $item->model->image ?>" >
                <?php } else { ?>
                    <img src="<?php echo $otherImagePath?>">
                <?php } ?>
            </div>
            <div class="catalog--mark_description">
                <div class="catalog--mark_name"><?php echo $item->model->name?></div>
                <div class="catalog--mark_relevance"><?php echo $item->model->relevance ? 'Актуальность: ' . $item->model->relevance : ''?></div>
                <?php if ($item->model->modification) { ?>
                    <div class="catalog--mark_modif"><?php echo $item->model->modification ?></div>
                <?php } ?>
            </div>
        </span>
    </a>
    <?php }
} else { ?>
    <div>По вашему запросу ничего не найдено</div>
<?php } ?>
</body>
</html>
