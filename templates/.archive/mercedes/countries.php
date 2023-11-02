<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.7.2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.countries .country').click(function () {
                var $countryId = $(this).attr('data-country');
                $('.country.active').removeClass('active');
                $(this).addClass('active').siblings().removeClass('active');
                $(".tile-blocks.active").removeClass('active').addClass('hidden');
                $(".tile-blocks#"+$countryId).removeClass('hidden').addClass('active');
            });
        });
    </script>
</head>
<body>
<?php require __DIR__ . '/../breadcrumbs.php'; ?>

    <form class="catalog_search" method='GET' action='<?php echo "/{$hrefPrefix}{$breadcrumbs[1]->url}/{$breadcrumbs[2]->url}/search" ?>'>
        <input required class="search_vin" id="number" type='text' name='number' placeholder=' ' style="width: 50%;">
        <label class="form__label" for='search_vin'>Поиск по номеру (артикулу) детали</label>
        <input class="button button--green" type='submit' value="Найти">
    </form>

    <div class="countries">
        <?php foreach ($countries as $country) { ?>
            <span class="country <?php echo $country->current ? 'active' : ''?>" data-country='<?php echo $country->short ?>'>
                <?php echo $country->name ?>
            </span>
        <?php } ?>
    </div>

    <?php foreach ($countries as $index => $country) { ?>
        <div class="tile-blocks <?php echo $country->current ? 'active' : 'hidden'?>" id="<?php echo $country->short ?>">
            <?php foreach ($country->aggregations as $aggregate) {
                $url = "/{$hrefPrefix}{$country->type}/{$country->mark}/{$country->short}/{$aggregate->short}";?>
                <span class="tile-block">
                    <a href="<?php echo $url?>">
                        <div class="tile-block-image">
                            <?php if ($aggregate->image) { ?>
                                <img src="<?php echo $aggregate->image ?>">
                            <?php } else { ?>
                                <img src="https://acat.online/catalog-images/avtodiler.png">
                            <?php } ?>
                        </div>
                        <div class="tile-block-name"><?php echo $aggregate->name ?></div>
                    </a>
                </span>
            <?php } ?>
        </div>
    <?php } ?>

</body>
</html>
