<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="<?php echo $hrefPrefix ?>/styles.css" rel="stylesheet">
    <style>
        span.modal-vin-info-close {
            position: absolute;
            right: 15px;
            top: 15px;
            z-index: 10;
            cursor: pointer;
            height: 16px;
            width: 16px;
            background-image: url(https://212709.selcdn.ru/autocatalog-online/public/images/info-close.png);
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
    <input required class="search_vim" id="search_vim" type='text' name='text' placeholder=' ' value="<?php echo $searchValue ?>">
    <label class="form__label" for='search_vim'>Поиск по VIN, кузову, марке или модели</label>
    <input class="button button--green" type='submit' value="Найти">
    <input type='hidden' name='redirect' value='1'>
</form>
<?php
if (count($vins) > 0 || count($frames) > 0) {
    $itemsList = count($vins) > 0 ? $vins : (count($frames) > 0 ? $frames : []);
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
} elseif  (count($marks) > 0) { ?>
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
