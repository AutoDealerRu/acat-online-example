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
    <input required class="search_vim" id="search_vim" type='text' name='text' placeholder=' ' value="<?php echo isset($searchValue) ? $searchValue : '' ?>">
    <label class="form__label" for='search_vim'>Поиск по VIN, кузову, марке или модели</label>
    <input class="button button--green" type='submit' value="Найти">
    <input type='hidden' name='redirect' value='1'>
</form>
<?php if (isset($error) && $error) { ?>
    <h1 style="color: red;"><?php echo $error ?></h1>
<?php } elseif ((isset($vins) && is_array($vins) && count($vins) > 0) || (isset($frames) && is_array($frames) && count($frames) > 0)) {
    $itemsList = is_array($vins) && count($vins) > 0 ? $vins : (is_array($frames) && count($frames) > 0 ? $frames : []);
    if (isset($catalog) && is_string($catalog) && $catalog === 'PARTS' && count($itemsList) > 0) {
        $paramKeys = [];
        foreach ($itemsList as $vin) {
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
            <?php foreach ($itemsList as $index => $vin) { $url = "/{$hrefPrefix}{$vin->type}/{$vin->mark}/{$vin->model}/{$vin->modification}?criteria=".urlencode($vin->criteria); ?>
                <tr class="table-row">
                    <td class="table-cell">
                        <a href="<?php echo $url?>"><?php echo $vin->title ?></a>
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
        <?php
    } else {
        foreach ($itemsList as $index => $vin) {
            switch (property_exists($vin, 'mark')) {
                case (in_array($vin->mark, ['INFINITI', 'NISSAN'])):
                    $countryList = [
                        'EL' => 'Европа (лев)',
                        'ER' => 'Европа (пр)',
                        'AR' => 'Австралия',
                        'GL' => 'Азия (лев)',
                        'GR' => 'Азия (пр)',
                        'CA' => 'Канада',
                        'US' => 'США',
                        'JP' => 'Япония'
                    ];
                    $url = "/{$hrefPrefix}{$vin->type}/{$vin->mark}/{$vin->country_short_name}/{$vin->directory}/{$vin->modification}";
                    $name = "{$vin->mark} {$vin->model_name} ({$countryList[$vin->country_short_name]})";
                    ?><a href="<?php echo $url ?>"><div><span><?php echo $index+1 ?>. </span><?php echo $name ?></div></a><?php
                    break;
                case (in_array($vin->mark, ['MERCEDES_BENZ', 'SMART', 'MERCEDES_BENZ_PS'])):
                    $url = "/{$hrefPrefix}{$vin->type}/{$vin->mark}/{$vin->country}/{$vin->aggregation}/{$vin->model}/{$vin->catalog}";
                    $name = "{$vin->mark} {$vin->modification} {$vin->country} ({$vin->name})";
                    ?><a href="<?php echo $url ?>"><div><span><?php echo $index+1 ?>. </span><?php echo $name ?></div></a><?php
                    break;
                case (in_array($vin->mark, ['FIAT', 'LANCIA', 'ALFA_ROMEO', 'ABARTH'])):
                    $url = "/{$hrefPrefix}{$vin->type}/{$vin->mark}/{$vin->model_short_name}/{$vin->modification_short_name}";
                    $name = "{$vin->mark} {$vin->modification_name}";
                    ?><a href="<?php echo $url ?>"><div><span><?php echo $index+1 ?>. </span><?php echo $name ?></div></a><?php
                    break;
                case (in_array($vin->mark, ['BMW', 'ROLLS-ROYCE', 'MINI'])):
                    $url = "/{$hrefPrefix}{$vin->type}/{$vin->mark}/{$vin->series_short_name}/{$vin->model_short_name}/{$vin->rule_position}/{$vin->transmission}";
                    $name = "{$vin->mark} {$vin->series_name} ({$vin->name})";
                    ?><a href="<?php echo $url ?>"><div><span><?php echo $index+1 ?>. </span><?php echo $name ?></div></a><?php
                    break;
                case (in_array($vin->mark, ['KIA', 'HYUNDAI'])):
                    $countryList = [
                        'GEN' => 'Корея',
                        'AUS' => 'Австралия',
                        'EUR' => 'Европа',
                        'CAN' => 'Канада',
                        'USA' => 'США',
                        'MES' => 'Ближний Восток',
                        'CIS' => 'СНГ',
                        'HMI' => 'Индия',
                        'PUT' => 'Пуэрто-Рико'
                    ];
                    $url = "/{$hrefPrefix}{$vin->type}/{$vin->mark}/{$vin->country_short}/{$vin->family}/{$vin->model}/{$vin->modification}";
                    $name = "{$vin->mark} {$vin->model_name} {$countryList[$vin->country_short]} ";
                    ?><a href="<?php echo $url ?>"><div><span><?php echo $index+1 ?>. </span><?php echo $name ?></div></a><?php
                    break;
                case (in_array($vin->mark, ['TOYOTA', 'LEXUS'])):
                    $countryList = ['EU' => 'Европа', 'JP' => 'Япония', 'GR' => 'Ближний восток', 'US' => 'США'];
                    $url = "/{$hrefPrefix}{$vin->type}/{$vin->mark}/{$vin->country_short_name}/{$vin->catalog_code}/{$vin->model_code}/{$vin->sysopt}/{$vin->complectation_code}";
                    $name = "{$vin->mark} {$vin->model_name} ({$countryList[$vin->country_short_name]})";
                    ?><a href="<?php echo $url ?>"><div><span><?php echo $index+1 ?>. </span><?php echo $name ?></div></a><?php
                    break;
                case (in_array($vin->mark, ['AUDI', 'SEAT', 'SKODA', 'VOLKSWAGEN'])):
                    $i = 1;
                    foreach ($vin->models as $vinModel) {
                        foreach ($vinModel->countries as $vinCountry) {
                            $url = "/{$hrefPrefix}{$vin->type}/{$vin->mark}/{$vinCountry->short_name}/{$vinModel->name}/{$vin->model_year}/{$vin->complectation->catalog_code}/{$vin->complectation->dir}";
                            $name = "{$vinModel->full_name} ({$vinCountry->full_name})";
                            ?><a href="<?php echo $url ?>"><div><span><?php echo $i ?>. </span><?php echo $name ?></div></a><?php
                            $i = $i + 1;
                        }
                    }
                    break;
                case (in_array($vin->mark, ['GAZ_ENGINE', 'ANDORIA_ENGINE', 'AVIA', 'BALKANCAR_ENGINE', 'BALKANCAR', 'BAW', 'BEARFORD_ENGINE', 'BEIFANG_BENCHI', 'BYD', 'CAMC', 'CASE', 'CATERPILLAR', 'CF_MOTO', 'CHENGGONG', 'CHEVROLET', 'CHEVROLET_SKD', 'CHRYSLER_ENGINE', 'CITROEN_SKD', 'CNHTC_SINOTRUK', 'CNHTC_SINOTRUK_ARCHIVE', 'CUMMINS_ENGINE', 'CUMMINS_ENGINE', 'DAEWOO', 'DAEWOO_SKD', 'DAEWOO_ARCHIVE', 'DAF', 'DERWAYS', 'DETVA', 'DEUTZ_ENGINE', 'DONGFENG_ENGINE', 'DONGFENG', 'DONGFENG', 'DOOSAN', 'EAGLE-WING', 'FAW_ARCHIVE', 'FAW', 'FORD_SKD', 'FORTSCHRITT', 'FOTON', 'FOTON', 'GEELY', 'GOLDEN_DRAGON', 'HAFEI', 'HANWOO', 'HBXG', 'HIDROMEK_ARCHIVE', 'HIDROMEK', 'HIGER', 'HONDA_SKD', 'HONDA_SKD', 'HONEY_BEE', 'IKARUS', 'IRAN_KHODRO', 'ISUZU_ENGINE', 'ISUZU_SKD', 'IVECO_ENGINE', 'IVECO', 'JAC', 'JAGUAR_SKD', 'JAWA', 'JCB', 'JEEP_SKD', 'JIANSHE', 'JMC', 'KING_LONG', 'KOMAT\'SU_ENGINE', 'KOMAT\'SU', 'LAND_ROVER_SKD', 'LIFAN', 'LIUGONG', 'LOCUST', 'MACDON', 'MADARA', 'MADARA', 'MAHINDRA', 'MAN_SKD', 'MAN', 'MAZDA_SKD', 'MECANICA_CEAHLAU', 'MERCEDES_BENZ_SKD', 'MERCEDES_BENZ_SKD', 'METAL-FACH_ARCHIVE', 'METAL-FACH', 'MITSUBER', 'MITSUBISHI_SKD', 'NEW_HOLLAND', 'NISSAN_ENGINE', 'OPEL_SKD', 'PEUGEOT_SKD', 'PORSCHE_SKD', 'RENAULT_SKD', 'RENAULT', 'ROVER_SKD', 'SAAB', 'SAAB_SKD', 'SARKANA_ZVAIGZNE', 'SCANIA_SKD', 'SDLG', 'SHAANXI', 'SHAANXI_FAST_GEAR', 'SHANTUI', 'SSANGYONG_SKD', 'SUBARU_SKD', 'SUZUKI', 'SUZUKI_SKD', 'SUZUKI_SKD', 'TATA', 'TATRA', 'TEREX', 'THERMO_KING', 'TIGARBO', 'TRACOM', 'VERSATILE', 'VOLVO', 'VOLVO', 'VOLVO_SKD', 'VOLVO_SKD', 'XCMG', 'XIAMEN', 'YANMAR_ENGINE', 'YUCHAI_ENGINE', 'YUTONG_ARCHIVE', 'YUTONG', 'ZETOR_ENGINE', 'ZF', 'ZONGSHEN', 'AVTOKRAN', 'AGRO', 'AZLK', 'ALTAJ', 'AMZ_ENGINE', 'AMKODOR_ARCHIVE', 'AMKODOR', 'ATZ', 'BARNAULTRANSMASH_ARCHIVE_ENGINE', 'BARNAULTRANSMASH_ENGINE', 'BELAZ_ARCHIVE', 'BELAZ', 'BELAZ', 'BELOVEZH_ARCHIVE', 'BELOVEZH', 'BELOCERKOVMAZ', 'BOBRUJSKAGROMASH_ARCHIVE', 'BOBRUJSKAGROMASH', 'BOBRUJSKSELMASH', 'BOGDAN', 'BRYANSKIJ_ARSENAL_ARCHIVE', 'BRYANSKIJ_ARSENAL', 'BRYANSKIJ_ARSENAL', 'BEHMZ', 'VAZ_ARCHIVE', 'VAZ', 'VGTZ', 'VSM', 'VTZ_ARCHIVE_ENGINE', 'VTZ_ENGINE', 'VTZ', 'VEHKS', 'GAZ_ARCHIVE', 'GAZ', 'GAZ_ARCHIVE', 'GAZ', 'GAZPROM-KRAN', 'GAKZ', 'GEOMASH', 'GIDROMASH', 'GOMSELMASH', 'GOMSELMASH_ARCHIVE', 'DKZ', 'DONEHKS', 'DORMASH', 'ELAZ', 'ZAZ_ARCHIVE', 'ZAZ', 'ZZGT_ARCHIVE', 'ZZGT', 'ZID', 'ZID', 'ZIK', 'ZIL', 'ZIL_ARCHIVE', 'ZIL_ARCHIVE', 'ZIL', 'ZLATEHKS', 'ZMZ_ARCHIVE_ENGINE', 'ZMZ_ENGINE', 'IZH', 'IZH', 'IZH_ARCHIVE', 'IZHNEFTEMASH', 'IZHORSKIE_ZAVODY', 'IMZ', 'KAVZ', 'KAZ', 'KAMAZ_ENGINE', 'KAMAZ_ARCHIVE', 'KAMAZ_ARCHIVE', 'KAMAZ_ARCHIVE_ENGINE', 'KAMAZ', 'KAMAZ', 'KANASH', 'KZK_ARCHIVE', 'KZK', 'KZKT', 'KLEVER_ARCHIVE', 'KLEVER', 'KMZ', 'KMZ_1_MAYA', 'KOVROVEC', 'KRAZ_ARCHIVE', 'KRAZ', 'KREDMASH', 'KEHZ', 'LAZ', 'LZA', 'LIAZ', 'LIAZ_ARCHIVE', 'LIDAGROPROMMASH', 'LIDSELMASH', 'LTZ', 'LUAZ', 'MAZ_ARCHIVE', 'MAZ', 'MAZ', 'MAZ_ARCHIVE', 'MAZ', 'MASHTEKHREMONT', 'MZKM_ARCHIVE', 'MZKM', 'MZKT', 'MMZ', 'MMZ_ARCHIVE_ENGINE', 'MMZ_ENGINE', 'MOAZ', 'MOAZ', 'MOAZ_ARCHIVE', 'MOLDAGROTEKHNIKA', 'MRMZ', 'MTZ_ARCHIVE', 'MTZ', 'MTM', 'MTM', 'NEFAZ_ARCHIVE', 'NEFAZ_ARCHIVE', 'NEFAZ', 'NEFAZ', 'NEFAZ', 'NKMZ', 'OREL-POGRUZCHIK', 'OSTA', 'OTZ', 'PAZ', 'PAZ_ARCHIVE', 'PENZADIZELMASH_ENGINE', 'PROMTRAKTOR', 'PTZ', 'RASKAT', 'RAF', 'RMZ', 'ROSTSELMASH_ARCHIVE', 'ROSTSELMASH', 'RUSSKAYA_MEKHANIKA', 'RUSSKAYA_MEKHANIKA_ARCHIVE', 'SAZ', 'SALSKSELMASH', 'SAREHKS', 'SZAP_ARCHIVE', 'SZAP', 'SIBSELMASH', 'SINERGIYA', 'SMD_ENGINE', 'STROJDORMASH', 'STROMNEFTEMASH', 'TVEHKS_ARCHIVE', 'TVEHKS', 'TEPLOSTAR_ENGINE', 'TZA', 'TKZ', 'TMZ_ARCHIVE_ENGINE', 'TMZ_ENGINE', 'TMZ', 'TONAR_ARCHIVE', 'TONAR', 'TORFMASH', 'UAZ_ARCHIVE', 'UAZ', 'UVZ', 'UVZ_ARCHIVE', 'UMZ_ARCHIVE_ENGINE', 'UMZ_ENGINE', 'UMZ_-2', 'UMPO', 'UMPO', 'UNISIBMASH', 'URAL', 'URAL_ARCHIVE', 'URAL', 'URALMASH', 'HZTSSH', 'HTZ_ARCHIVE', 'HTZ', 'CHERVONA_ZIRKA', 'CHZTS', 'CHMZ', 'CHSDM', 'CHTZ', 'SHAAZ', 'EHKSKO', 'EHKSMASH', 'EHLTRA_ENGINE', 'YUMZ', 'YURMASH', 'YAMZ_ARCHIVE_ENGINE', 'YAMZ_ENGINE'])):
                    $url = "/{$hrefPrefix}{$vin->type}/{$vin->mark}/{$vin->model_short_name}/{$vin->modification_short_name}";
                    $name = "{$vin->mark} {$vin->country_short_name} {$vin->modification_name}";
                    ?><a href="<?php echo $url ?>"><div><span><?php echo $index+1 ?>. </span><?php echo $name ?></div></a><?php
                    break;
            }
        }
    }
} elseif  (isset($marks) && is_array($marks) && count($marks) > 0) { ?>
    <?php foreach ($marks as $ind => $mark) {
        $url = "/{$hrefPrefix}";
        $name = ""; ?>
        <?php foreach ($mark->breadcrumbs as $key => $item) {
            $url .= $item->url;
            if ($key < (count($mark->breadcrumbs) - 1)) {
                $url .= '/';
            }
            $name .= $item->name . ' ';
        }
        ?>
        <a href="<?php echo $url ?>">
            <div><span><?php echo $ind+1 ?>. </span><?php echo $name ?></div>
        </a>
    <?php }
} else { ?>
    <div>По вашему запросу ничего не найдено</div>
<?php } ?>
</body>
</html>
