<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.7.2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.main_catalog--types').on('click', '.main_catalog--type', function() {
                $('.main_catalog--marks.on').removeClass('on');
                $(this).addClass('on').siblings().removeClass('on').removeClass('noborder');
                $(this).closest('.main_catalog').find('.main_catalog--marks').eq($(this).index()).addClass('on');
                $('.main_catalog--type.on').prev().addClass('noborder');
            });
        });
    </script>
</head>
<body>
<svg style="display: none;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <symbol id="icon-vin" viewBox="0 0 404.308 404.309"><path d="M 404.31868,285.87875 118.42975,-0.01017852 l 285.88752,0.006 10e-4,285.88326852 z"></path></symbol>
</svg>
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
    <input required class="search_vim" id="search_vim" type='text' name='text' placeholder=' '>
    <label class="form__label" for='search_vim'>Поиск по VIN, кузову, марке или модели</label>
    <input class="button button--green" type='submit' value="Найти">
</form>

<?php if ($error && strlen($error) > 0) { ?>
    <h1 style="color: red;"><?php echo $error ?></h1>
<?php } else { ?>
    <ul class="main_catalog">
        <li class="main_catalog--types">
            <?php foreach ($types as $k => $type) { ?>
                <div class="main_catalog--type <?php echo ($activeType && $type->id === $activeType) || (!$activeType && $k === 0) ? 'on' : ''?>" data-type="<?php echo $type->id?>">
                    <div class="main_catalog--type_name">
                        <div class="main_catalog--type_title">
                            <?php if ($type->image) { ?>
                                <img src="<?php echo $type->image ?>" alt="<?php echo $type->name ?>">
                            <?php } ?>
                            <span><?php echo $type->name?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </li>
        <li class="main_catalog--marks_all">
            <?php foreach ($types as $k => $type) { ?>
                <div class="main_catalog--marks <?php echo ($activeType && $type->id === $activeType) || (!$activeType && $k === 0) ? 'on' : '' ?>">
                    <div class="marks-inline">
                        <?php foreach ($type->marks as $mark) {?>
                            <a href="<?php echo $hrefPrefix . $type->id . '/' . $mark->id ?>">
                            <span class="main_catalog--mark">
                                <?php if ($mark->vin) {?>
                                    <div class="mark-vin" title="Можно искать по VIN">
                                        <svg width="80" height="80"><use xlink:href="#icon-vin"></use></svg>
                                        <span>VIN</span>
                                    </div>
                                <?php } ?>
                                <div class="main_catalog--mark_image">
                                    <img src="<?php echo $mark->image?>" alt="<?php $mark->name ?>"/>
                                </div>
                                <div class="main_catalog--mark_name">
                                    <?php echo $mark->name.(($mark->archival === true) ? ' (архивный)' : '') ?>
                                    <?php echo $mark->engine === true ? ' (двигатель)' : ''; ?>
                                </div>
                            </span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </li>
    </ul>
<?php } ?>
</body>
</html>
