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
            $('.href').on('click', function() {
                window.location.pathname = $(this).attr('data-href');
            });
            $('.etka_select_complectations').on('click', function() {
                $(this).closest('.modal-year').find('.etka_year').hide();
                $(this).next().show();
            });
            $('.etka_select_year').on('click', function() {
                $(this).closest('.modal-year').find('.etka_year').show();
                $(this).closest('.modal-year').find('.etka_complectations').hide();
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
            <a class="country <?php echo $country->country_short_name == $currentCountry ? 'active' : ''?>" href="/<?php echo $hrefPrefix . $country->type . '/' . $country->mark . '/' . $country->country_short_name ?>">
                <?php echo $country->full_name ?>
            </a>
        <?php } ?>
    </div>
    <table class="table active" data-countryid="<?php echo $currentCountry ?>">
        <thead class="table-head">
        <tr class="table-row bottom-line">
            <td class="table-cell">Модель</td>
            <td class="table-cell">Код модели</td>
            <td class="table-cell">Период</td>
            <td class="table-cell">Производство</td>
        </tr>
        </thead>
        <tbody class="table-body">
        <?php $categories = [];
        foreach($models as $model) {
            $categories[$model->full_name][] = $model;
        }
        ?>
        <?php foreach ($categories as $index => $model) { ?>
            <?php if (count($model) > 1) { ?>
                <tr class="table-row bottom-line model_year js-modal-init" data-modal='year' data-year="<?php echo $index ?>" data-country="<?php echo $currentCountry ?>">
                    <td class="table-cell">
                        <?php echo $index ?>
                    </td>
                    <td class="table-cell">
                        <?php echo $model[0]->name ?>
                    </td>
                    <td class="table-cell">
                        <?php echo substr($model[0]->date_start, 0, 4) ?>
                        <?php echo ' - '.(!$model[0]->date_end ? 'по н.в.' : substr($model[0]->date_end, 0, 4)) ?>
                    </td>
                    <td class="table-cell">
                        <?php echo $model[0]->production ?>
                    </td>
                </tr>
                <div class="hidden">
                    <div class="modal-pin box-modal" id="year-modal" data-modal_year="<?php echo $index ?>">
                        <div class="box-modal_close arcticmodal-close"></div>
                        <div class="modal-year">
                            <h2 class="title title--center" style='font-size: 22px;'>Выберите год производства</h2>
                            <?php $years = [];
                            foreach($model as $item) {
                                $years[$item->year][] = $item;
                            }
                            foreach($years as $yearIndex => $year) { ?>
                                <?php if (count($year) === 1) { ?>
                                    <a href="<?php echo "/{$hrefPrefix}{$model[0]->type}/{$model[0]->mark}/{$year[0]->country_short_name}/{$year[0]->name}/{$year[0]->year}/{$year[0]->catalog_code}/{$year[0]->dir}" ?>">
                                        <span class="etka_year"><?php echo $yearIndex ?></span>
                                    </a>
                                <?php } elseif (count($year) > 1) { ?>
                                    <span class="etka_year etka_select_complectations"><?php echo $yearIndex ?></span>
                                    <span class="etka_complectations">
                                        <?php foreach($year as $complectation) { ?>
                                            <span class="etka_complectation">
                                                <a href="<?php echo "/{$hrefPrefix}{$complectation->type}/{$complectation->mark}/{$complectation->country_short_name}/{$complectation->name}/{$complectation->year}/{$complectation->catalog_code}/{$complectation->dir}" ?>">
                                                    <span class="etka_year_complectation"><?php echo $complectation->number_chassis ? $complectation->number_chassis : 'неизвестный' ?></span>
                                                </a>
                                            </span>
                                        <?php } ?>
                                        <span class="etka_select_year button button--green" style='margin: 20px auto 0px auto;'>Назад</span>
                                    </span>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <tr class="table-row bottom-line href" data-href="<?php echo "/{$hrefPrefix}{$model[0]->type}/{$model[0]->mark}/{$model[0]->country_short_name}/{$model[0]->name}/{$model[0]->year}/{$model[0]->catalog_code}/{$model[0]->dir}" ?>">
                    <td class="table-cell" style="background: #2ca02c">
                        <?php echo $index ?>
                    </td>
                    <td class="table-cell">
                        <?php echo $model[0]->name ?>
                    </td>
                    <td class="table-cell">
                        <?php echo substr($model[0]->date_start, 0, 4) ?>
                        <?php echo ' - '.(!$model[0]->date_end ? 'по н.в.' : substr($model[0]->date_end, 0, 4)) ?>
                    </td>
                    <td class="table-cell">
                        <?php echo $model[0]->production ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>
