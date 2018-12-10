<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {
            $('.number-info-cell label').click(function (event) {
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

            $(".imageLayout").draggable({
                drag: function (event, ui) {
                    __dx = ui.position.left - ui.originalPosition.left;
                    __dy = ui.position.top - ui.originalPosition.top;
                    ui.position.left = ui.originalPosition.left + ( __dx);
                    ui.position.top = ui.originalPosition.top + ( __dy );
                    ui.position.left += __recoupLeft;
                    ui.position.top += __recoupTop;
                },
                start: function (event, ui) {
                    $(this).css('cursor', 'pointer');
                    var left = parseInt($(this).css('left'), 10);
                    left = isNaN(left) ? 0 : left;
                    var top = parseInt($(this).css('top'), 10);
                    top = isNaN(top) ? 0 : top;
                    __recoupLeft = left - ui.position.left;
                    __recoupTop = top - ui.position.top;
                },
                create: function (event, ui) {
                    $(this).attr('oriLeft', $(this).css('left'));
                    $(this).attr('oriTop', $(this).css('top'));
                }
            });

            function getIEVersion() {
                var agent = navigator.userAgent;
                var reg = /MSIE\s?(\d+)(?:\.(\d+))?/i;
                var matches = agent.match(reg);
                if (matches != null) {
                    return {major: matches[1], minor: matches[2]};
                }
                return {major: "-1", minor: "-1"};
            }

            var ie_version = getIEVersion();
            var is_ie10 = ie_version.major == 10;
            var is_ie11 = /Trident.*rv[ :]*11\./.test(navigator.userAgent);

            var isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
            var tmpImg = new Image();

            var $imgArea = $('.image-tab.active .main-image-area');
            var imgAreaWidth = parseInt($imgArea.width());
            var imgAreaHeight = parseInt($imgArea.height());

            tmpImg.onload = function () {
                var tmpImgWidth = parseInt(tmpImg.width);
                var tmpImgHeight = parseInt(tmpImg.height);

                var scaleX = imgAreaWidth / tmpImgWidth;
                var scaleY = imgAreaHeight / tmpImgHeight;

                var zoom = Math.min.apply(null, [scaleX, scaleY]) * 1;
                var origin = Math.min.apply(null, [scaleX, scaleY]) * 1;
                var left = (imgAreaWidth - tmpImgWidth) / 2;
                var top = (imgAreaHeight - tmpImgHeight) / 2;

                $('.imageArea-info-plus').click(function () {
                    if (zoom) {
                        zoom = zoom + 0.1;
                        if (zoom < 0.1) {
                            zoom = 0.1;
                        }
                        $('.image-tab.active .imageLayout').css({
                            'transform': 'scale(' + zoom + ', ' + zoom + ')'
                        });
                    }
                });

                $('.imageArea-info-minus').click(function () {
                    if (zoom) {
                        zoom = zoom - 0.1;
                        if (zoom < 0.1) {
                            zoom = 0.1;
                        }
                        $('.image-tab.active .imageLayout').css({
                            'transform': 'scale(' + zoom + ', ' + zoom + ')'
                        });
                    }
                });

                function stretch() {
                    zoom = Math.min.apply(null, [scaleX, scaleY]) * 1;
                    left = (imgAreaWidth - tmpImgWidth) / 2;
                    top = (imgAreaHeight - tmpImgHeight) / 2;
                    $('.image-tab .imageLayout').css({
                        'transform': 'scale(' + zoom + ', ' + zoom + ')',
                        'top': top,
                        'left': left
                    });
                }

                $('.imageArea-info-stretch').click(function () {
                    stretch();
                });

                if ($('.image-tab').length > 0) {
                    stretch();
                }
                var binds = isFirefox ? 'MozMousePixelScroll' : (is_ie10 || is_ie11) ? 'wheel' : 'mousewheel DOMMouseScroll wheel';
                $('.image-tab .main-image-area .imageArea').bind(binds, function (e) {
                    if (!origin)
                        origin = 1;
                    if (e.type === 'wheel') {
                        if (e.originalEvent.deltaY > 0) {
                            zoom = zoom - (origin * 0.01);
                        } else {
                            zoom = zoom * 1 + (origin * 0.01);
                        }
                    } else if (e.type === 'mousewheel') {
                        if (e.originalEvent.wheelDelta < 0) {
                            zoom = zoom - (origin * 0.01);
                        } else {
                            zoom = zoom * 1 + (origin * 0.01);
                        }
                    } else if (e.type === 'DOMMouseScroll' || e.type === 'MozMousePixelScroll') {
                        if (e.originalEvent.detail > 0) {
                            zoom = zoom - (origin * 0.01);
                        } else {
                            zoom = zoom * 1 + (origin * 0.01);
                        }
                    }
                    if (zoom) {
                        if (zoom < 0.01) {
                            zoom = 0.01;
                        }
                        e.preventDefault();
                        $('.image-tab.active .imageLayout').css({
                            'transform': 'scale(' + zoom + ', ' + zoom + ')'
                        });
                    }
                });
                $(".to-image")
                    .dblclick(function () {
                        var a = left - parseInt($('.image-tab.active .ladel.active').css('left').replace('px', '')) * zoom + ($('.image-tab.active .main-image-area .imageLayout').width() * zoom / 2)
                            ,
                            e = top - parseInt($('.image-tab.active .ladel.active').css('top').replace('px', '')) * zoom + ($('.image-tab.active .main-image-area .imageLayout').height() * zoom / 2)
                            , t = $(this)
                                .attr("data-index");
                        $(".image-tab.active .imageLayout")
                            .css({
                                left: a
                            })
                            .css({
                                top: e
                            }), $("html, body")
                            .animate({
                                scrollTop: $(".image-tab.active .main-image-area")
                                    .offset()
                                    .top - 70
                            }, 1e3), $(".image-tab.active")
                            .find("[data-index='" + t + "']")
                            .addClass("active")
                    });
            };
            tmpImg.src = $('.image-tab.active .imageLayout img').attr('src');

            $(".imageLayout .ladel")
                .click(function () {
                    var a = $(this)
                        .attr("data-index");
                    $(".imageArea-related .table-row")
                        .removeClass("active")
                        , $(".imageLayout .ladel")
                        .removeClass("active")
                        , a ? ($(".image-tab.active")
                            .find("[data-index='" + a + "']")
                            .addClass("active"), $(".table.imageArea-related")
                            .find("[data-index='" + a + "']")
                            .addClass("active")) :
                        $(this)
                            .addClass("active")
                }),

                $(".imageLayout .ladel")
                    .dblclick(function () {
                        var a = $(this)
                            .attr("data-index");
                        $("html, body")
                            .animate({
                                scrollTop: $(".imageArea-related")
                                    .find("[data-index='" + a + "']")
                                    .first()
                                    .offset()
                                    .top - 70
                            }, 1e3)
                    }), $(".to-image")
                .click(function () {
                    var a = $(this)
                        .attr("data-index");
                    $(".imageLayout .ladel")
                        .removeClass("active"), a && $(".image-tab.active")
                        .find("[data-index='" + a + "']")
                        .addClass("active")
                }), $(".imageArea-info-label")
                .click(function () {
                    $(this).hasClass("active") ? ($(this)
                        .removeClass("active"), $(".image-tab.active .imageArea-info-label span")
                        .hide(), $(".image-tab.active .imageArea .ladel")
                        .css("opacity", "")) : ($(this)
                        .addClass("active"), $(".image-tab.active .imageArea-info-label span")
                        .show(), $(".image-tab.active .imageArea .ladel")
                        .css("opacity", 0))
                }),
                $(".image-tab-nav:not(.href-tab)").click(function () {
                    var a = $(this).attr("data-subgroup");
                    $(".image-tab-nav.active").removeClass("active");
                    $(this).addClass("active");
                    $(".image-tab.active").removeClass("active").addClass("hidden");
                    $("#image-tab-" + a).removeClass("hidden").addClass("active");
                    $(".table-tab.active").removeClass("active").addClass("hidden");
                    $("#table-tab-" + a).removeClass("hidden").addClass("active");
                });
                $(".imageArea-info-icon").click(function () {
                    var a = $(".image-tab.active .imageArea-info");
                    a.hasClass("active") ? a.removeClass("active") : a.addClass("active")
                });
                $(document).mouseup(function (a) {
                    var e = $(".image-tab.active .imageArea-info-icon");
                    e.is(a.target) || 0 !== e.has(a.target)
                        .length || e.find(".imageArea-info")
                        .removeClass("active")
                });
        });
    </script>
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>
<?php
$prevUrl = $prev ? "/{$hrefPrefix}{$prev->type}/{$prev->mark}/{$prev->country}/{$prev->directory}/{$prev->modification}/{$prev->group}/{$prev->figure}" : null;
$nextUrl = $next ? "/{$hrefPrefix}{$next->type}/{$next->mark}/{$next->country}/{$next->directory}/{$next->modification}/{$next->group}/{$next->figure}" : null;
$title = $breadcrumbs[7]->name;
?>

<div class="list-group" style='text-align: center; position: relative;'>
    <?php if ($prev) { ?>
        <a class="group-prev" href="<?php echo $prevUrl ?>" title="<?php echo $prev->name ?>">
            <span class="list-group-prev"></span>
        </a>
    <?php } ?>
    <h1 class="title" style="margin: 0 50px; display: inline-block;"><?php echo $title ?></h1>
    <?php if ($next) { ?>
        <a class="group-next" href="<?php echo $nextUrl ?>" title="<?php echo $next->name ?>">
            <span class="list-group-next"></span>
        </a>
    <?php } ?>
</div>

<div class="image-tabs">
 <div class="image-tabs-nav">
     <?php if (count($images) > 1) foreach ($images as $index => $item) { ?>
             <a href="<?php echo "/{$hrefPrefix}{$item->type}/{$item->mark}/{$item->country_short_name}/{$item->directory}/{$item->modification}/{$item->group}/{$item->subgroup}/{$item->figure}/{$item->section}"?>">
                 <span class="image-tab-nav href-tab <?php echo property_exists($item,'current') ? 'active' : ''?>">
                     Вариант <?php echo $index + 1 ?>
                 </span>
             </a>
     <?php } ?>
 </div>
</div>

<div class="image-area" onselectstart="return false;">
    <?php
    $labels = [];
    $added = [];
    foreach ($numbers as $item) {
        $index = $item->number ? $item->number : $item->description;
        $coordinateIndex = $item->coordinate->bottom->x.$item->coordinate->bottom->y.$item->coordinate->top->x.$item->coordinate->top->y;
        if (!in_array($coordinateIndex, $added)) {
            $added[] = $coordinateIndex;
            $labels[] = json_decode(json_encode([
                'index' => $index,
                'title' => "{$item->description} ({$item->number})",
                'bottomX' => $item->coordinate->bottom->x,
                'bottomY' => $item->coordinate->bottom->y,
                'topX' => $item->coordinate->top->x,
                'topY' => $item->coordinate->top->y
            ]));
        }
    }?>
    <div class="image-tab active">
        <div class="main-image-area">
            <div class="imageArea-menu">
                <div class="imageArea-info-label">
                    <img class="eye_open" src="https://212709.selcdn.ru/autocatalog-online/public/images/eye_open.png">
                    <img class="eye_close"
                         src="https://212709.selcdn.ru/autocatalog-online/public/images/eye_close.png">
                </div>
                <span class="imageArea-info-plus">+</span>
                <span class="imageArea-info-minus">-</span>
                <span class="imageArea-info-stretch">
                    <img src="https://212709.selcdn.ru/autocatalog-online/public/images/arrows.png">
                </span>
                <div class="imageArea-info-icon"><img
                            src="https://212709.selcdn.ru/autocatalog-online/public/images/info.png">
                    <div class="imageArea-info">
                        <div class="info-block">
                            <span class="image">
                                <img class="eye_open"
                                     src="https://212709.selcdn.ru/autocatalog-online/public/images/eye_open.png"
                                     style="bottom: 0; margin: auto; display: block; margin-top: 10px;">
                            </span>
                            <span class="text">Показать или скрыть метки</span>
                        </div>
                        <div class="info-block">
                            <span class="image" style="height: 20px;">
                                <span class="imageArea-info-plus" style="bottom: 0; margin: auto; display: block;">+</span>
                            </span>
                            <span class="text">Увеличить изображение на 10%</span>
                        </div>
                        <div class="info-block">
                            <span class="image" style="height: 20px;">
                                <span class="imageArea-info-minus" style="bottom: 0; margin: auto; display: block;">-</span>
                            </span>
                            <span class="text">Уменьшить изображение на 10%</span>
                        </div>
                        <div class="info-block">
                            <span class="image">
                                <img style="margin: auto; display: block; margin-top: 10px;" src="https://212709.selcdn.ru/autocatalog-online/public/images/arrows.png">
                            </span>
                            <span class="text">По размеру окна</span>
                        </div>
                        <div class="info-block x2">
                            <span class="image">
                                <img src="https://212709.selcdn.ru/autocatalog-online/public/images/x2.png">
                            </span>
                            <span class="text">Выделение детали в таблице</span>
                        </div>
                        <div class="info-block x">
                            <span class="image">
                                <img src="https://212709.selcdn.ru/autocatalog-online/public/images/move.png">
                            </span>
                            <span class="text">Прокрутка картинки</span>
                        </div>
                        <div class="info-block z">
                            <span class="image">
                                <img src="https://212709.selcdn.ru/autocatalog-online/public/images/zoom.png">
                            </span>
                            <span class="text">Увеличить масштаб</span>
                        </div>
                        <div class="ico">
                            <svg width="20" height="10">
                                <polyline points="0,0 10,10 20,0" stroke="#278ece" fill="white"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-image imageArea">
                <span class="imageLayout">
                    <img src="<?php echo $image?>">
                    <?php if (count($labels) > 0) { ?>
                        <?php foreach ($labels as $coordinate) { ?>
                            <span class="ladel"
                                  data-left="<?php echo $coordinate->topX ?>"
                                  data-top="<?php echo $coordinate->topY ?>"
                                  title="<?php echo $coordinate->title ?>"
                                  data-index="<?php echo $coordinate->index ?>"
                                  style="position:absolute; padding:1px 5px;
                                          left: <?php echo $coordinate->topX ?>px;
                                          top: <?php echo $coordinate->topY ?>px;
                                          min-width: <?php echo $coordinate->bottomX - $coordinate->topX ?>px;
                                          min-height: <?php echo $coordinate->bottomY - $coordinate->topY ?>px;
                                          line-height:  <?php echo $coordinate->bottomY - $coordinate->topY ?>px;
                                          font-size:  <?php echo $coordinate->bottomY - $coordinate->topY - 2 ?>px;"></span>
                        <?php } ?>
                    <?php } ?>
                </span>
            </div>
        </div>
    </div>
</div>

<table class="table imageArea-related active">
    <thead class="table-head">
    <tr class="table-row bottom-line a2s-numbers_header">
        <td class="table-cell">№</td>
        <td class="table-cell">&nbsp;</td>
        <td class="table-cell">Номер</td>
        <td class="table-cell">Наименование</td>
    </tr>
    </thead>
    <tbody class="table-body">
    <?php foreach ($numbers as $key => $number) {
        switch ($number->number_type) {
            case 'SUBNUMBERS' : {
                if (property_exists($number,'items') && is_array($number->items)){
                    foreach ($number->items as $key2 => $subnumber) {
                        if ($key2 === 0 || ($key2 > 0 && $subnumber->number != $number->items[$key2 - 1]->number)) {?>
                            <tr class="table-row bottom-line to-image" data-index="<?php echo $number->number ?>">
                                <td class="table-cell"><?php echo $number->number?></td>
                                <td class="table-cell number-info-cell" data-number-info="<?php echo $key?>">
                                    <input id='input' type="checkbox">
                                    <label for='input'></label>
                                    <div class="modal-number-info">
                                        <span class="modal-number-info-close"></span>
                                        <div class="number-info">
                                            <div class="number-info-params">Автомобиль: <?php echo "{$breadcrumbs[2]->name} {$breadcrumbs[4]->name}" ?></div>
                                            <?php if (property_exists($subnumber,'from_date') || property_exists($subnumber,'to_date')) { ?>
                                                <div class="number-info-params">Дата пр-ва:
                                                    <?php echo substr($subnumber->from_date, 8, 2).'.'.substr($subnumber->from_date, 5, 2).'.'.substr($subnumber->from_date, 0, 4);
                                                    if (property_exists($subnumber,'to_date')) echo ' - ';
                                                    if (property_exists($subnumber,'to_date')) echo (!$subnumber->to_date ? 'по н.в.' : substr($subnumber->to_date, 8, 2).'.'.substr($subnumber->to_date, 5, 2).'.'.substr($subnumber->to_date, 0, 4)); ?>
                                                </div>
                                            <?php } ?>
                                            <?php if (property_exists($subnumber,'applicability')) { ?>
                                                <div class="number-info-params">Применяемость: <?php echo $subnumber->applicability ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-cell"><?php echo $subnumber->number?></td>
                                <td class="table-cell"><?php echo property_exists($number,'description') ? $number->description : 'Неизвестно' ?></td>
                            </tr>
                <?php }}}
                break;
            }
            case 'NUMBER': { ?>
                <tr class="table-row bottom-line to-image" data-index="<?php echo $number->number ?>">
                    <td class="table-cell"></td>
                    <td class="table-cell"></td>
                    <td class="table-cell"><?php echo $number->number?></td>
                    <td class="table-cell"><?php echo property_exists($number,'description') ? $number->description : 'Неизвестно' ?></td>
                </tr>
                <?php break;
            }
            case 'SECTION': {
                $url = "/{$hrefPrefix}{$number->type}/{$number->mark}/{$number->country_short_name}/{$number->directory}/{$number->modification}/{$number->group}/{$number->number}"; ?>
                <tr class="table-row bottom-line to-image" data-index="<?php echo $number->number ?>">
                    <td class="table-cell"><?php echo $number->number?></td>
                    <td class="table-cell"></td>
                    <td class="table-cell"></td>
                    <td class="table-cell">
                        <a href="<?php echo $url ?>"><?php echo property_exists($number,'description') ? $number->description : 'Неизвестно'?></a>
                    </td>
                </tr>
                <?php break;
            }
            case 'UNKNOWN': { ?>
                <tr class="table-row bottom-line to-image" data-index="<?php echo $number->number ? $number->number : $number->description ?>">
                    <td class="table-cell"></td>
                    <td class="table-cell"></td>
                    <td class="table-cell"><?php echo $number->number?></td>
                    <td class="table-cell"><?php echo property_exists($number,'description') ? $number->description : 'Неизвестно' ?></td>
                </tr>
                <?php break;
            }
        }
    }?>
    </tbody>
</table>

<?php if ($abbreviations) { ?>
    <table class="table table-search active">
        <thead class="table-head">
        <tr class="table-row bottom-line">
            <td class="table-cell">Сокращение</td>
            <td class="table-cell">Расшифровка</td>
        </tr>
        </thead>
        <tbody class="table-body">
        <?php foreach ($abbreviations as $abbreviation) {?>
            <tr class="table-row bottom-line">
                <td class="table-cell"><?php echo $abbreviation->abbreviation?></td>
                <td class="table-cell"><?php echo $abbreviation->description?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>

</body>
</html>
