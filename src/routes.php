<?php
use Slim\Http\Request;
use Slim\Http\Response;
use GuzzleHttp\Client;

$client = new Client();
$response = $client->request('GET', 'https://acat.online/api/public/types');
$response = $rr = json_decode($response->getBody()->getContents()); // available types & marks for each catalog

$app->get('/', function (Request $request, Response $response) {
    $settings = Helper::getJSON($this->get('settings')['api']);
    if (
        !property_exists($settings,'token') ||
        property_exists($settings,'token') && strlen($settings->token) === 0
    ) {
        return $this->renderer->render($response, 'index.php', [
            'hrefPrefix' => $settings->urlBeforeCatalog,
            'error' => 'Укажите ваш API Token в файле src/settings.php:11'
        ]);
    }
    $types = Helper::getData($settings, false);

    return $this->renderer->render($response, 'index.php', [
        'hrefPrefix' => $settings->urlBeforeCatalog,
        'types' => $types
    ]);
});

// Поиск
$app->get('/search', function (Request $request, Response $response, array $args) use ($rr) {
    $settings = Helper::getJSON($this->get('settings')['api']);

    $data = Helper::getData($settings, true,"/search?text={$request->getQueryParams()['text']}");
    $data['hrefPrefix'] = $settings->urlBeforeCatalog;
    $data['searchValue'] = $request->getQueryParams()['text'];
    if ($data && $data['error']) {
        return $this->renderer->render($response, 'search/index.php', $data);
    }
    if ((array_key_exists('vins', $data) && count($data['vins']) === 1) || (array_key_exists('frames', $data) && count($data['frames']) === 1)) {
        $vin = count($data['vins']) === 1 ? $data['vins'][0] : $data['frames'][0];
        switch (property_exists($vin, 'mark')) {
            case (in_array($vin->mark, ['INFINITI', 'NISSAN'])):
                $url = "/{$vin->type}/{$vin->mark}/{$vin->country_short_name}/{$vin->directory}/{$vin->modification}";
                return $response->withRedirect($url, 301);
                break;
            case (in_array($vin->mark, ['MERCEDES_BENZ', 'SMART', 'MERCEDES_BENZ_PS'])):
                $url = "/{$vin->type}/{$vin->mark}/{$vin->country}/{$vin->aggregation}/{$vin->model}/{$vin->catalog}";
                return $response->withRedirect($url, 301);
                break;
            case (in_array($vin->mark, ['FIAT', 'LANCIA', 'ALFA_ROMEO', 'ABARTH'])):
                $url = "/{$vin->type}/{$vin->mark}/{$vin->model_short_name}/{$vin->modification_short_name}";
                return $response->withRedirect($url, 301);
                break;
            case (in_array($vin->mark, ['BMW', 'ROLLS-ROYCE', 'MINI'])):
                $url = "/{$vin->type}/{$vin->mark}/{$vin->series_short_name}/{$vin->model_short_name}/{$vin->rule_position}/{$vin->transmission}";
                return $response->withRedirect($url, 301);
                break;
            case (in_array($vin->mark, ['KIA', 'HYUNDAI'])):
                $url = "/{$vin->type}/{$vin->mark}/{$vin->country_short}/{$vin->family}/{$vin->model}/{$vin->modification}";
                return $response->withRedirect($url, 301);
                break;
            case (in_array($vin->mark, ['TOYOTA', 'LEXUS'])):
                $url = "/{$vin->type}/{$vin->mark}/{$vin->country_short_name}/{$vin->catalog_code}/{$vin->model_code}/{$vin->sysopt}/{$vin->complectation_code}";
                return $response->withRedirect($url, 301);
                break;
            case (in_array($vin->mark, ['WEICHAI_ENGINE', 'CVS_FERRARI', 'FRESIA', 'SCHOPF', 'DELTA', 'BZST', 'BZTM', 'BOLSHAYA_ZEMLYA', 'DZAK', 'ZLATMASH', 'OMSKTRANSMASH', 'PERVOMAJSKHIMMASH', 'SMOLTRA', 'SPECBURMASH', 'SEK', 'TDA_ENGINE', 'CHELEKS', 'YAVT', 'CSM', 'SDEC_ENGINE', 'VOLGABUS', 'VZS', 'GATCHINSELMASH', 'DORELECTROMASH', 'TMZV', 'GAZ_ENGINE', 'ANDORIA_ENGINE', 'AVIA', 'BALKANCAR_ENGINE', 'BALKANCAR', 'BAW', 'BEARFORD_ENGINE', 'BEIFANG_BENCHI', 'BYD', 'CAMC', 'CASE', 'CATERPILLAR', 'CF_MOTO', 'CHENGGONG', 'CHEVROLET', 'CHEVROLET_SKD', 'CHRYSLER_ENGINE', 'CITROEN_SKD', 'CNHTC_SINOTRUK', 'CNHTC_SINOTRUK_ARCHIVE', 'CUMMINS_ENGINE', 'CUMMINS_ENGINE', 'DAEWOO', 'DAEWOO_SKD', 'DAEWOO_ARCHIVE', 'DAF', 'DERWAYS', 'DETVA', 'DEUTZ_ENGINE', 'DONGFENG_ENGINE', 'DONGFENG', 'DONGFENG', 'DOOSAN', 'EAGLE-WING', 'FAW_ARCHIVE', 'FAW', 'FORD_SKD', 'FORTSCHRITT', 'FOTON', 'FOTON', 'GEELY', 'GOLDEN_DRAGON', 'HAFEI', 'HANWOO', 'HBXG', 'HIDROMEK_ARCHIVE', 'HIDROMEK', 'HIGER', 'HONDA_SKD', 'HONDA_SKD', 'HONEY_BEE', 'IKARUS', 'IRAN_KHODRO', 'ISUZU_ENGINE', 'ISUZU_SKD', 'IVECO_ENGINE', 'IVECO', 'JAC', 'JAGUAR_SKD', 'JAWA', 'JCB', 'JEEP_SKD', 'JIANSHE', 'JMC', 'KING_LONG', 'KOMAT\'SU_ENGINE', 'KOMAT\'SU', 'LAND_ROVER_SKD', 'LIFAN', 'LIUGONG', 'LOCUST', 'MACDON', 'MADARA', 'MADARA', 'MAHINDRA', 'MAN_SKD', 'MAN', 'MAZDA_SKD', 'MECANICA_CEAHLAU', 'MERCEDES_BENZ_SKD', 'MERCEDES_BENZ_SKD', 'METAL-FACH_ARCHIVE', 'METAL-FACH', 'MITSUBER', 'MITSUBISHI_SKD', 'NEW_HOLLAND', 'NISSAN_ENGINE', 'OPEL_SKD', 'PEUGEOT_SKD', 'PORSCHE_SKD', 'RENAULT_SKD', 'RENAULT', 'ROVER_SKD', 'SAAB', 'SAAB_SKD', 'SARKANA_ZVAIGZNE', 'SCANIA_SKD', 'SDLG', 'SHAANXI', 'SHAANXI_FAST_GEAR', 'SHANTUI', 'SSANGYONG_SKD', 'SUBARU_SKD', 'SUZUKI', 'SUZUKI_SKD', 'SUZUKI_SKD', 'TATA', 'TATRA', 'TEREX', 'THERMO_KING', 'TIGARBO', 'TRACOM', 'VERSATILE', 'VOLVO', 'VOLVO', 'VOLVO_SKD', 'VOLVO_SKD', 'XCMG', 'XIAMEN', 'YANMAR_ENGINE', 'YUCHAI_ENGINE', 'YUTONG_ARCHIVE', 'YUTONG', 'ZETOR_ENGINE', 'ZF', 'ZONGSHEN', 'AVTOKRAN', 'AGRO', 'AZLK', 'ALTAJ', 'AMZ_ENGINE', 'AMKODOR_ARCHIVE', 'AMKODOR', 'ATZ', 'BARNAULTRANSMASH_ARCHIVE_ENGINE', 'BARNAULTRANSMASH_ENGINE', 'BELAZ_ARCHIVE', 'BELAZ', 'BELAZ', 'BELOVEZH_ARCHIVE', 'BELOVEZH', 'BELOCERKOVMAZ', 'BOBRUJSKAGROMASH_ARCHIVE', 'BOBRUJSKAGROMASH', 'BOBRUJSKSELMASH', 'BOGDAN', 'BRYANSKIJ_ARSENAL_ARCHIVE', 'BRYANSKIJ_ARSENAL', 'BRYANSKIJ_ARSENAL', 'BEHMZ', 'VAZ_ARCHIVE', 'VAZ', 'VGTZ', 'VSM', 'VTZ_ARCHIVE_ENGINE', 'VTZ_ENGINE', 'VTZ', 'VEHKS', 'GAZ_ARCHIVE', 'GAZ', 'GAZ_ARCHIVE', 'GAZ', 'GAZPROM-KRAN', 'GAKZ', 'GEOMASH', 'GIDROMASH', 'GOMSELMASH', 'GOMSELMASH_ARCHIVE', 'DKZ', 'DONEHKS', 'DORMASH', 'ELAZ', 'ZAZ_ARCHIVE', 'ZAZ', 'ZZGT_ARCHIVE', 'ZZGT', 'ZID', 'ZID', 'ZIK', 'ZIL', 'ZIL_ARCHIVE', 'ZIL_ARCHIVE', 'ZIL', 'ZLATEHKS', 'ZMZ_ARCHIVE_ENGINE', 'ZMZ_ENGINE', 'IZH', 'IZH', 'IZH_ARCHIVE', 'IZHNEFTEMASH', 'IZHORSKIE_ZAVODY', 'IMZ', 'KAVZ', 'KAZ', 'KAMAZ_ENGINE', 'KAMAZ_ARCHIVE', 'KAMAZ_ARCHIVE', 'KAMAZ_ARCHIVE_ENGINE', 'KAMAZ', 'KAMAZ', 'KANASH', 'KZK_ARCHIVE', 'KZK', 'KZKT', 'KLEVER_ARCHIVE', 'KLEVER', 'KMZ', 'KMZ_1_MAYA', 'KOVROVEC', 'KRAZ_ARCHIVE', 'KRAZ', 'KREDMASH', 'KEHZ', 'LAZ', 'LZA', 'LIAZ', 'LIAZ_ARCHIVE', 'LIDAGROPROMMASH', 'LIDSELMASH', 'LTZ', 'LUAZ', 'MAZ_ARCHIVE', 'MAZ', 'MAZ', 'MAZ_ARCHIVE', 'MAZ', 'MASHTEKHREMONT', 'MZKM_ARCHIVE', 'MZKM', 'MZKT', 'MMZ', 'MMZ_ARCHIVE_ENGINE', 'MMZ_ENGINE', 'MOAZ', 'MOAZ', 'MOAZ_ARCHIVE', 'MOLDAGROTEKHNIKA', 'MRMZ', 'MTZ_ARCHIVE', 'MTZ', 'MTM', 'MTM', 'NEFAZ_ARCHIVE', 'NEFAZ_ARCHIVE', 'NEFAZ', 'NEFAZ', 'NEFAZ', 'NKMZ', 'OREL-POGRUZCHIK', 'OSTA', 'OTZ', 'PAZ', 'PAZ_ARCHIVE', 'PENZADIZELMASH_ENGINE', 'PROMTRAKTOR', 'PTZ', 'RASKAT', 'RAF', 'RMZ', 'ROSTSELMASH_ARCHIVE', 'ROSTSELMASH', 'RUSSKAYA_MEKHANIKA', 'RUSSKAYA_MEKHANIKA_ARCHIVE', 'SAZ', 'SALSKSELMASH', 'SAREHKS', 'SZAP_ARCHIVE', 'SZAP', 'SIBSELMASH', 'SINERGIYA', 'SMD_ENGINE', 'STROJDORMASH', 'STROMNEFTEMASH', 'TVEHKS_ARCHIVE', 'TVEHKS', 'TEPLOSTAR_ENGINE', 'TZA', 'TKZ', 'TMZ_ARCHIVE_ENGINE', 'TMZ_ENGINE', 'TMZ', 'TONAR_ARCHIVE', 'TONAR', 'TORFMASH', 'UAZ_ARCHIVE', 'UAZ', 'UVZ', 'UVZ_ARCHIVE', 'UMZ_ARCHIVE_ENGINE', 'UMZ_ENGINE', 'UMZ_-2', 'UMPO', 'UMPO', 'UNISIBMASH', 'URAL', 'URAL_ARCHIVE', 'URAL', 'URALMASH', 'HZTSSH', 'HTZ_ARCHIVE', 'HTZ', 'CHERVONA_ZIRKA', 'CHZTS', 'CHMZ', 'CHSDM', 'CHTZ', 'SHAAZ', 'EHKSKO', 'EHKSMASH', 'EHLTRA_ENGINE', 'YUMZ', 'YURMASH', 'YAMZ_ARCHIVE_ENGINE', 'YAMZ_ENGINE'])):
                $url = "/{$vin->type}/{$vin->mark}/{$vin->model_short_name}/{$vin->modification_short_name}";
                return $response->withRedirect($url, 301);
                break;
            case (in_array($vin->mark, $rr->parts->marks)):
                $criteria = urlencode($vin->criteria);
                $url = "/{$vin->type}/{$vin->mark}/{$vin->model}/{$vin->modification}?criteria={$criteria}";
                return $response->withRedirect($url, 301);
                break;
            default:
                return $this->renderer->render($response, 'search/index.php', $data);
                break;
        }
    }
    return $this->renderer->render($response, 'search/index.php', $data);
});

$app->get('/{type}', function (Request $request, Response $response, array $args) {
    return $response->withRedirect('/', 301);
});

// parts (полный список типов и марок: https://acat.online/api/public/types -> parts)
$app->group('/{type:'.implode('|', $response->parts->types).'}/{mark:'.implode('|', $response->parts->marks).'}', function () {
    // модели
    $this->get('', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'parts/models.php', $data);
    });
    // модели
    $this->get('/{model}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $url = "/{$args['type']}/{$args['mark']}/{$args['model']}";
        $params = [];
        if (count($request->getQueryParams()) > 0) {
            foreach ($request->getQueryParams() as $k => $v) {
                $params[] = $k. '='. $request->getQueryParam($k);
            }
        }
        if (count($params) > 0) {
            $url .= '?' . join('&', $params);
        }
        $data = Helper::getData($settings, true, $url);
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'parts/modifications.php', $data);
    });
    // группы
    $this->get('/{model}/{modification}[/{group}]', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $url = "/{$args['type']}/{$args['mark']}/{$args['model']}/${args['modification']}";
        if (isset($args['group']) && !empty($args['group'])) {
            $url .= "/{$args['group']}";
        }
        if ($request->getQueryParam('criteria')) {
            $url .= '?criteria='.$request->getQueryParam('criteria');
        }
        $data = Helper::getData($settings, true, $url);
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        if ($request->getQueryParam('criteria')) {
            $data['criteria'] = $request->getQueryParam('criteria');
        }

        return $this->renderer->render($response, 'parts/groups.php', $data);
    });
    // номера
    $this->get('/{model}/{modification}/{group}/{subgroup}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $url = "/{$args['type']}/{$args['mark']}/{$args['model']}/${args['modification']}/${args['group']}/${args['subgroup']}";
        if ($request->getQueryParam('criteria')) {
            $url .= '?criteria='.$request->getQueryParam('criteria');
        }
        $data = Helper::getData($settings, true, $url);
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'parts/numbers.php', $data);
    });
});

// Infiniti | Nissan
$app->group('/{type:CARS_FOREIGN}/{mark:INFINITI|NISSAN}', function () {

    // поиск но номеру(артикулу)
    $this->get('/search', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $search = $request->getQueryParam('number');
        $data['numbers'] = Helper::getData($settings, true,"/search?type={$args['type']}&mark={$args['mark']}&number={$search}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'nissan/search.php', $data);
    });

    // страны и модели
    $this->get('[/{country:EL|ER|AR|GL|GR|CA|US|JP}]', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $args['country'] = isset($args['country']) ? $args['country'] : 'EL';

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");
        $data['models'] = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}")['models'];
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['currentCountry'] = $args['country'];

        return $this->renderer->render($response, 'nissan/models.php', $data);
    });

    // модификации
    $this->get('/{country:EL|ER|AR|GL|GR|CA|US|JP}/{directory:[\d]{3}}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['directory']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'nissan/modifications.php', $data);
    });

    // группы
    $this->get('/{country:EL|ER|AR|GL|GR|CA|US|JP}/{directory:[\d]{3}}/{modification:[\d]+}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['directory']}/{$args['modification']}");
        $data['labels'] = [];
        $added = [];
        foreach ($data['groups'] as $group) {
            if ($group->coordinate) {
                $index = $group->group_short ? $group->group_short : $group->group_name;
                $coordinateIndex = $group->coordinate->bottom->x.$group->coordinate->bottom->y.$group->coordinate->top->x.$group->coordinate->top->y;
                if (!in_array($coordinateIndex, $added)) {
                    $added[] = $coordinateIndex;
                    $data['labels'][] = json_decode(json_encode([
                        'index' => $index,
                        'title' => $group->group_name,
                        'bottomX' => $group->coordinate->bottom->x,
                        'bottomY' => $group->coordinate->bottom->y,
                        'topX' => $group->coordinate->top->x,
                        'topY' => $group->coordinate->top->y
                    ]));
                }
            }
        }
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'nissan/groups.php', $data);
    });

    // подгруппы
    $this->get('/{country:EL|ER|AR|GL|GR|CA|US|JP}/{directory:[\d]{3}}/{modification:[\d]+}/{group}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['directory']}/{$args['modification']}/{$args['group']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'nissan/subgroups.php', $data);
    });

    // номера (артикулы) запчастей
    $this->get('/{country:EL|ER|AR|GL|GR|CA|US|JP}/{directory:[\d]{3}}/{modification:[\d]+}/{group}/{subgroup}[/{figure}/{section}]', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        if (!isset($args['figure'])) $urlParams = "/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['directory']}/{$args['modification']}/{$args['group']}/{$args['subgroup']}";
        else $urlParams = "/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['directory']}/{$args['modification']}/{$args['group']}/{$args['subgroup']}/{$args['figure']}/{$args['section']}";
        $data = Helper::getData($settings, true, $urlParams);
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'nissan/numbers.php', $data);
    });

});

// Renault | Dacia
$app->group('/{type:CARS_FOREIGN}/{mark:RENAULT|DACIA}', function () {

    // поиск но номеру(артикулу)
    $this->get('/search', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $search = $request->getQueryParam('number');
        $data['numbers'] = Helper::getData($settings, true,"/search?type={$args['type']}&mark={$args['mark']}&number={$search}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['src'] = $search;

        return $this->renderer->render($response, 'renault/search.php', $data);
    });

    //models
    $this->get('', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'renault/models.php', $data);
    });

    //modifications
    $this->get('/{model}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['model']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'renault/modifications.php', $data);
    });

    //groups
    $this->get('/{model}/{modification}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['model']}/{$args['modification']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'renault/groups.php', $data);
    });

    //subgroups
    $this->get('/{model}/{modification}/{group}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['model']}/{$args['modification']}/{$args['group']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['labels'] = [];
        $added = [];
        foreach ($data['unit']->groups as $group) {
            if ($group->coordinates && is_array($group->coordinates)) {
                foreach ($group->coordinates as $coordinate) {
                    $index = $group->name ? $group->name : '';
                    $coordinateIndex = $coordinate->bottom->x.$coordinate->bottom->y.$coordinate->top->x.$coordinate->top->y;
                    if (!in_array($coordinateIndex, $added)) {
                        $added[] = $coordinateIndex;
                        $data['labels'][] = json_decode(json_encode([
                            'index' => $index,
                            'title' => $index,
                            'bottomX' => $coordinate->bottom->x,
                            'bottomY' => $coordinate->bottom->y,
                            'topX' => $coordinate->top->x,
                            'topY' => $coordinate->top->y
                        ]));
                    }
                }
            }
        }


        return $this->renderer->render($response, 'renault/subgroups.php', $data);
    });

    //numbers
    $this->get('/{model}/{modification}/{group}/{subgroup}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['model']}/{$args['modification']}/{$args['group']}/{$args['subgroup']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['labels'] = [];
        $added = [];
        foreach ($data['positions'] as $position) {
            if ($position->coordinates && is_array($position->coordinates)) {
                foreach ($position->coordinates as $coordinate) {
                    $coordinateIndex = $coordinate->bottom->x.$coordinate->bottom->y.$coordinate->top->x.$coordinate->top->y;
                    if (!in_array($coordinateIndex, $added)) {
                        $added[] = $coordinateIndex;
                        $data['labels'][] = json_decode(json_encode([
                            'index' => $position->index,
                            'title' => "{$position->name} ({$position->number})",
                            'bottomX' => $coordinate->bottom->x,
                            'bottomY' => $coordinate->bottom->y,
                            'topX' => $coordinate->top->x,
                            'topY' => $coordinate->top->y
                        ]));
                    }
                }
            }
        }

        $prev = $data['prev'];
        $next = $data['next'];
        $data['prevUrl'] = $prev ? "/{$settings->urlBeforeCatalog}{$prev->type}/{$prev->mark}/{$prev->model_short_name}/{$prev->modification_short_name}/{$prev->category_short_name}/{$prev->short_name}" : null;
        $data['nextUrl'] = $next ? "/{$settings->urlBeforeCatalog}{$next->type}/{$next->mark}/{$next->model_short_name}/{$next->modification_short_name}/{$next->category_short_name}/{$next->short_name}" : null;
        $data['title'] = $data['breadcrumbs'][6]->name;

        return $this->renderer->render($response, 'renault/numbers.php', $data);
    });

    //subNumbers
    $this->get('/{model}/{modification}/{group}/{subgroup}/{subNumber}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['model']}/{$args['modification']}/{$args['group']}/{$args['subgroup']}/{$args['subNumber']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['labels'] = [];
        $added = [];
        if ($data['positions'] && is_array($data['positions']) && count($data['positions']) > 0) {
            foreach ($data['positions'] as $position) {
                if ($position->coordinates && is_array($position->coordinates)) {
                    foreach ($position->coordinates as $coordinate) {
                        $coordinateIndex = $coordinate->bottom->x.$coordinate->bottom->y.$coordinate->top->x.$coordinate->top->y;
                        if (!in_array($coordinateIndex, $added)) {
                            $added[] = $coordinateIndex;
                            $data['labels'][] = json_decode(json_encode([
                                'index' => $position->index,
                                'title' => "{$position->name} ({$position->number})",
                                'bottomX' => $coordinate->bottom->x,
                                'bottomY' => $coordinate->bottom->y,
                                'topX' => $coordinate->top->x,
                                'topY' => $coordinate->top->y
                            ]));
                        }
                    }
                }
            }
        }

        $prev = $data['prev'];
        $next = $data['next'];
        $data['prevUrl'] = $prev ? "/{$settings->urlBeforeCatalog}{$prev->type}/{$prev->mark}/{$prev->model_short_name}/{$prev->modification_short_name}/{$prev->category_short_name}/{$prev->short_name}" : null;
        $data['nextUrl'] = $next ? "/{$settings->urlBeforeCatalog}{$next->type}/{$next->mark}/{$next->model_short_name}/{$next->modification_short_name}/{$next->category_short_name}/{$next->short_name}" : null;
        $data['title'] = $data['breadcrumbs'][6]->name;
        unset($data['parent']->breadcrumbs);

        return $this->renderer->render($response, 'renault/subnumbers.php', $data);
    });

});

//Mercedes | Smart
$app->group('/{type:CARS_FOREIGN|BUS|SPECIAL_TECH_FOREIGN|ENGINE|TRUCKS_FOREIGN}/{mark:MERCEDES_BENZ|SMART|MERCEDES_BENZ_PS}', function () {

    // поиск но номеру(артикулу)
    $this->get('/search', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $search = $request->getQueryParam('number');
        $data['numbers'] = Helper::getData($settings, true,"/search?type={$args['type']}&mark={$args['mark']}&number={$search}");
        $data['searchNumber'] = $search;
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'mercedes/search.php', $data);
    });
    
    //countries
    $this->get('', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'mercedes/countries.php', $data);
    });

    //models
    $this->get('/{country}/{aggregation}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['aggregation']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'mercedes/models.php', $data);
    });

    //groups
    $this->get('/{country}/{aggregation}/{model}/{catalog}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['aggregation']}/{$args['model']}/{$args['catalog']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'mercedes/groups.php', $data);
    });

    //numbers
    $this->get('/{country}/{aggregation}/{model}/{catalog}/{group}/{subgroup}[/{position}]', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['aggregation']}/{$args['model']}/{$args['catalog']}/{$args['group']}/{$args['subgroup']}".($args['position'] ? "/{$args['position']}" : ''));
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['mainImageUrl'] = $data['image'];
        $data['labels'] = [];
        $added = [];
        foreach ($data['images'] as $item) {
            if (property_exists($item,'current') && $item->current && property_exists($item,'points') && is_array($item->points) && count($item->points) > 0) {
                foreach ($item->points as $coordinate) {
                    $coordinateIndex = $coordinate->coordinate->bottom->x.$coordinate->coordinate->bottom->y.$coordinate->coordinate->top->x.$coordinate->coordinate->top->y;
                    if (!in_array($coordinateIndex, $added)) {
                        $added[] = $coordinateIndex;
                        $data['labels'][] = json_decode(json_encode([
                            'index' => $coordinate->label ? $coordinate->label : '',
                            'title' => $coordinate->description,
                            'bottomX' => $coordinate->coordinate->bottom->x,
                            'bottomY' => $coordinate->coordinate->bottom->y,
                            'topX' => $coordinate->coordinate->top->x,
                            'topY' => $coordinate->coordinate->top->y
                        ]));
                    }
                }
            }
        }

        $prev = $data['previousGroup'];
        $next = $data['nextGroup'];
        $data['prevUrl'] = $prev ? "/{$settings->urlBeforeCatalog}{$prev->type}/{$prev->mark}/{$prev->country}/{$prev->aggregation}/{$prev->model}/{$prev->catalog}/{$prev->group}/{$prev->subgroup}".(property_exists($prev,'sa') ? "/{$prev->sa}/{$prev->stroke}" : '') : null;
        $data['nextUrl'] = $next ? "/{$settings->urlBeforeCatalog}{$next->type}/{$next->mark}/{$next->country}/{$next->aggregation}/{$next->model}/{$next->catalog}/{$next->group}/{$next->subgroup}".(property_exists($next,'sa') ? "/{$next->sa}/{$next->stroke}" : '') : null;
        $data['title'] = $data['subgroup']->name;

        return $this->renderer->render($response, 'mercedes/numbers.php', $data);
    });

    //sa numbers
    $this->get('/{country}/{aggregation}/{model}/{catalog}/{group}/{subgroup}/{sa}/{stroke}[/{position}]', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['aggregation']}/{$args['model']}/{$args['catalog']}/{$args['group']}/{$args['subgroup']}/{$args['sa']}/{$args['stroke']}".($args['position'] ? "/{$args['position']}" : ''));
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['mainImageUrl'] = $data['image'];
        $data['labels'] = [];
        $added = [];
        foreach ($data['images'] as $item) {
            if (property_exists($item,'current') && $item->current && property_exists($item,'points') && is_array($item->points) && count($item->points) > 0) {
                foreach ($item->points as $coordinate) {
                    $coordinateIndex = $coordinate->coordinate->bottom->x.$coordinate->coordinate->bottom->y.$coordinate->coordinate->top->x.$coordinate->coordinate->top->y;
                    if (!in_array($coordinateIndex, $added)) {
                        $added[] = $coordinateIndex;
                        $data['labels'][] = json_decode(json_encode([
                            'index' => $coordinate->label ? $coordinate->label : '',
                            'title' => $coordinate->description,
                            'bottomX' => $coordinate->coordinate->bottom->x,
                            'bottomY' => $coordinate->coordinate->bottom->y,
                            'topX' => $coordinate->coordinate->top->x,
                            'topY' => $coordinate->coordinate->top->y
                        ]));
                    }
                }
            }
        }

        $prev = $data['previousGroup'];
        $next = $data['nextGroup'];
        $data['prevUrl'] = $prev ? "/{$settings->urlBeforeCatalog}{$prev->type}/{$prev->mark}/{$prev->country}/{$prev->aggregation}/{$prev->model}/{$prev->catalog}/{$prev->group}/{$prev->subgroup}".(property_exists($prev,'sa') ? "/{$prev->sa}/{$prev->stroke}" : '') : null;
        $data['nextUrl'] = $next ? "/{$settings->urlBeforeCatalog}{$next->type}/{$next->mark}/{$next->country}/{$next->aggregation}/{$next->model}/{$next->catalog}/{$next->group}/{$next->subgroup}".(property_exists($next,'sa') ? "/{$next->sa}/{$next->stroke}" : '') : null;
        $data['title'] = $data['subgroup']->name;

        return $this->renderer->render($response, 'mercedes/numbers.php', $data);
    });

});

//a2d
$app->group('/{type:'.implode('|', $response->a2d->types).'}/{mark:'.implode('|', $response->a2d->marks).'}', function () {

    // поиск но номеру(артикулу)
    $this->get('/search', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $search = $request->getQueryParam('number');
        $data['numbers'] = Helper::getData($settings, true,"/search?type={$args['type']}&mark={$args['mark']}&number={$search}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'a2d/search.php', $data);
    });

    // модели
    $this->get('', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['isSKD'] = stripos($args['mark'], '_SKD') > 0;
        return $this->renderer->render($response, 'a2d/models.php', $data);
    });

    // группы
    $this->get('/{modelId}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['modelId']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'a2d/groups.php', $data);
    });

    // номера (артикулы) запчастей
    $this->get('/{modelId}/{groupId}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['modelId']}/{$args['groupId']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'a2d/numbers.php', $data);
    });

    //изображение
    $this->get('/{modelId}/{groupId}/image', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getImage($settings, "/{$args['type']}/{$args['mark']}/{$args['modelId']}/{$args['groupId']}/image");
        $response->write($data);

        return $response->withHeader('Content-Type', FILEINFO_MIME_TYPE);
    });
});

//Abarth | Alfa Romeo | Lancia | Fiat
$app->group('/{type:CARS_FOREIGN}/{mark:ABARTH|ALFA_ROMEO|LANCIA|FIAT}', function () {

    // поиск но номеру(артикулу)
    $this->get('/search', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $search = $request->getQueryParam('number');
        $data['numbers'] = Helper::getData($settings, true,"/search?type={$args['type']}&mark={$args['mark']}&number={$search}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'fiat/search.php', $data);
    });

    // модели
    $this->get('', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'fiat/models.php', $data);
    });

    // модели
    $this->get('/{model}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['model']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'fiat/modifications.php', $data);
    });

    // groups
    $this->get('/{model}/{modification}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['model']}/{$args['modification']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'fiat/groups.php', $data);
    });

    // subgroups
    $this->get('/{model}/{modification}/{group}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['model']}/{$args['modification']}/{$args['group']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'fiat/subgroups.php', $data);
    });

    // numbers
    $this->get('/{model}/{modification}/{group}/{subgroup}/{variant}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['model']}/{$args['modification']}/{$args['group']}/". urlencode($args['subgroup']) . "/{$args['variant']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['labels'] = [];
        $added = [];
        if ($data['numbers'] && is_array($data['numbers'])) {
            foreach ($data['numbers'] as $item) {
                if (property_exists($item,'coordinate') && $item->coordinate) {
                    $coordinateIndex = $item->coordinate->bottom->x.$item->coordinate->bottom->y.$item->coordinate->top->x.$item->coordinate->top->y;
                    if (!in_array($coordinateIndex, $added)) {
                        $added[] = $coordinateIndex;
                        $data['labels'][] = json_decode(json_encode([
                            'index' => $item->index ? $item->index : ( $item->number ? $item->number : $item->description),
                            'title' => "{$item->description} ({$item->number})",
                            'bottomX' => $item->coordinate->bottom->x,
                            'bottomY' => $item->coordinate->bottom->y,
                            'topX' => $item->coordinate->top->x,
                            'topY' => $item->coordinate->top->y
                        ]));
                    }
                }
            }
        }

        $prev = $data['previousGroup'];
        $next = $data['nextGroup'];
        $data['prevUrl'] = $prev ? "/{$settings->urlBeforeCatalog}{$prev->type}/{$prev->mark}/{$prev->model}/{$prev->modification}/{$prev->unit}/{$prev->subgroup_id}/{$prev->variant}" : null;
        $data['nextUrl'] = $next ? "/{$settings->urlBeforeCatalog}{$next->type}/{$next->mark}/{$next->model}/{$next->modification}/{$next->unit}/{$next->subgroup_id}/{$next->variant}" : null;
        $data['title'] = "{$data['breadcrumbs'][5]->name} {$data['description']}";

        return $this->renderer->render($response, 'fiat/numbers.php', $data);
    });

});

//BMW | Rolls-Royce | Mini
$app->group('/{type:CARS_FOREIGN|MOTORCYCLE}/{mark:BMW|ROLLS-ROYCE|MINI}',function (){

    // поиск но номеру(артикулу)
    $this->get('/search', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $search = $request->getQueryParam('number');
        $data['numbers'] = Helper::getData($settings, true,"/search?type={$args['type']}&mark={$args['mark']}&number={$search}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'bmw/search.php', $data);
    });

    // series
    $this->get('', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'bmw/series.php', $data);
    });

    // models
    $this->get('/{series}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['series']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'bmw/models.php', $data);
    });

    // groups
    $this->get('/{series}/{model}/{rule}/{transmission}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['series']}/{$args['model']}/{$args['rule']}/{$args['transmission']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        if ($request->getQueryParams()['date']) $data['queryDate'] = $request->getQueryParams()['date'];

        return $this->renderer->render($response, 'bmw/groups.php', $data);
    });

    // subgroups
    $this->get('/{series}/{model}/{rule}/{transmission}/{group}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['series']}/{$args['model']}/{$args['rule']}/{$args['transmission']}/{$args['group']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        if ($request->getQueryParams()['date']) $data['queryDate'] = $request->getQueryParams()['date'];

        return $this->renderer->render($response, 'bmw/subgroups.php', $data);
    });

    // numbers
    $this->get('/{series}/{model}/{rule}/{transmission}/{group}/{subgroup}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['series']}/{$args['model']}/{$args['rule']}/{$args['transmission']}/{$args['group']}/{$args['subgroup']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['labels'] = [];
        $added = [];
        if ($data['numbers'] && is_array($data['numbers'])) {
            foreach ($data['numbers'] as $item) {
                if (property_exists($item,'coordinate') && $item->coordinate) {
                    $coordinateIndex = $item->coordinate->bottom->x.$item->coordinate->bottom->y.$item->coordinate->top->x.$item->coordinate->top->y;
                    if (!in_array($coordinateIndex, $added)) {
                        $added[] = $coordinateIndex;
                        $data['labels'][] = json_decode(json_encode([
                            'index' => strlen($item->group_number) > 0 ? $item->group_number : strlen($item->number) > 0 ? $item->number : $item->full_name,
                            'title' => "{$item->full_name} ({$item->number})",
                            'bottomX' => $item->coordinate->bottom->x,
                            'bottomY' => $item->coordinate->bottom->y,
                            'topX' => $item->coordinate->top->x,
                            'topY' => $item->coordinate->top->y
                        ]));
                    }
                }
            }
        }

        $prev = $data['previousGroups'];
        $next = $data['nextGroup'];
        $data['prevUrl'] = $prev ? "/{$settings->urlBeforeCatalog}{$prev->type}/{$prev->mark}/{$prev->series}/{$prev->model}/{$prev->rule}/{$prev->transmission}/{$prev->group}/{$prev->short_name}".($request->getQueryParams()['date'] ? "?date={$request->getQueryParams()['date']}" : '') : null;
        $data['nextUrl'] = $next ? "/{$settings->urlBeforeCatalog}{$next->type}/{$next->mark}/{$next->series}/{$next->model}/{$next->rule}/{$next->transmission}/{$next->group}/{$next->short_name}".($request->getQueryParams()['date'] ? "?date={$request->getQueryParams()['date']}" : '') : null;
        $data['title'] = $data['breadcrumbs'][6]->name;

        return $this->renderer->render($response, 'bmw/numbers.php', $data);
    });

});

// SSANGYONG
$app->group('/{type:CARS_FOREIGN}/{mark:SSANGYONG}', function () {

    // поиск но номеру(артикулу)
    $this->get('/search', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $search = $request->getQueryParam('number');
        $data['numbers'] = Helper::getData($settings, true,"/search?type={$args['type']}&mark={$args['mark']}&number={$search}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'ssangyong/search.php', $data);
    });
    
    // модели
    $this->get('', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");

        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'ssangyong/models.php', $data);
    });

    // группы
    $this->get('/{modelId}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['modelId']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'ssangyong/groups.php', $data);
    });

    // номера (артикулы) запчастей
    $this->get('/{modelId}/{groupId}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['modelId']}/{$args['groupId']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'ssangyong/numbers.php', $data);
    });
});

// ETKA
$app->group('/{type:CARS_FOREIGN}/{mark:AUDI|SEAT|SKODA|VOLKSWAGEN}', function () {

    // поиск но номеру(артикулу)
    $this->get('/search', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $search = $request->getQueryParam('number');
        $data['numbers'] = Helper::getData($settings, true,"/search?type={$args['type']}&mark={$args['mark']}&number={$search}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'etka/search.php', $data);
    });

    // страны и модели
    $this->get('[/{country:BR|CA|CN|CZ|E|MEX|RA|RDW|SVW|USA|ZA}]', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        if (!empty($args['country'])) {
            $args['country'] = $args['country'];
        } elseif ($args['mark'] == 'SKODA') {
            $args['country'] = 'SVW';
        } elseif ($args['mark'] == 'SEAT') {
            $args['country'] = 'E';
        } else {
            $args['country'] = 'RDW';
        };

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");
        $data['models'] = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}")['models'];
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['currentCountry'] = $args['country'];

        return $this->renderer->render($response, 'etka/models.php', $data);
    });

    // группы и сервисные группы
    $this->get('/{country}/{model}/{year}/{catalog_code}/{dir}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['model']}/{$args['year']}/{$args['catalog_code']}/{$args['dir']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'etka/groups.php', $data);
    });

    // подгруппы
    $this->get('/{country}/{model}/{year}/{catalog_code}/{dir}/group/{group}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['model']}/{$args['year']}/{$args['catalog_code']}/{$args['dir']}/group/{$args['group']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'etka/subgroups.php', $data);
    });

    // сервисные подгруппы
    $this->get('/{country}/{model}/{year}/{catalog_code}/{dir}/service/{service}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['model']}/{$args['year']}/{$args['catalog_code']}/{$args['dir']}/service/{$args['service']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'etka/subservices.php', $data);
    });

    // номера (артикулы) запчастей
    $this->get('/{country}/{model}/{year}/{catalog_code}/{dir}/group/{group}/{subgroup}/{detail}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['model']}/{$args['year']}/{$args['catalog_code']}/{$args['dir']}/group/{$args['group']}/{$args['subgroup']}/{$args['detail']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'etka/numbers.php', $data);
    });

    // сервисные номера (артикулы) запчастей
    $this->get('/{country}/{model}/{year}/{catalog_code}/{dir}/service/{service}/{subservice}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['model']}/{$args['year']}/{$args['catalog_code']}/{$args['dir']}/service/{$args['service']}/{$args['subservice']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'etka/servicenumbers.php', $data);
    });

});

// TOYOTA | LEXUS
$app->group('/{type:CARS_FOREIGN}/{mark:TOYOTA|LEXUS}', function () {

    // поиск но номеру(артикулу)
    $this->get('/search', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $search = $request->getQueryParam('number');
        $country = $request->getQueryParam('country');
        $model = $request->getQueryParam('model');
        $data['numbers'] = Helper::getData($settings, true,"/search?type={$args['type']}&mark={$args['mark']}&number={$search}&country={$country}&model={$model}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'toyota/search.php', $data);
    });

    // страны и модели
    $this->get('[/{country:EU|JP|GR|US}]', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $args['country'] = isset($args['country']) ? $args['country'] : 'EU';

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");
        $data['models'] = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}")['models'];
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['currentCountry'] = $args['country'];

        return $this->renderer->render($response, 'toyota/models.php', $data);
    });

    // комплектации
    $this->get('/{country}/{catalog_code}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['catalog_code']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'toyota/complectations.php', $data);
    });

    // группы
    $this->get('/{country}/{catalog_code}/{model_code}/{sysopt}/{compl_code}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['catalog_code']}/{$args['model_code']}/{$args['sysopt']}/{$args['compl_code']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'toyota/groups.php', $data);
    });

    // Илюстрация и номера (артикулы) запчастей (первые)
    $this->get('/{country}/{catalog_code}/{model_code}/{sysopt}/{compl_code}/{group}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['catalog_code']}/{$args['model_code']}/{$args['sysopt']}/{$args['compl_code']}/{$args['group']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'toyota/numbers.php', $data);
    });

    // Илюстрация и номера (артикулы) запчастей
    $this->get('/{country}/{catalog_code}/{model_code}/{sysopt}/{compl_code}/{group}/{illustration}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['catalog_code']}/{$args['model_code']}/{$args['sysopt']}/{$args['compl_code']}/{$args['group']}/{$args['illustration']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'toyota/numbers.php', $data);
    });
});

// KIA | HYUNDAI
$app->group('/{type:BUS|CARS_FOREIGN|TRUCKS_FOREIGN}/{mark:KIA|HYUNDAI}', function () {

    // поиск но номеру(артикулу)
    $this->get('/search', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $search = $request->getQueryParam('number');
        $data['numbers'] = Helper::getData($settings, true,"/search?type={$args['type']}&mark={$args['mark']}&number={$search}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'kia/search.php', $data);
    });

    // страны и семейства
    $this->get('[/{country}]', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);
        $args['country'] = isset($args['country']) ? $args['country'] : 'EUR';

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");
        $data['families'] = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}")['families'];
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['currentCountry'] = $args['country'];

        return $this->renderer->render($response, 'kia/families.php', $data);
    });

    // модели
    $this->get('/{country}/{families}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['families']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'kia/models.php', $data);
    });

    // модификации
    $this->get('/{country}/{families}/{model}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['families']}/{$args['model']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'kia/modifications.php', $data);
    });

    // группы
    $this->get('/{country}/{families}/{model}/{modification}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['families']}/{$args['model']}/{$args['modification']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'kia/groups.php', $data);
    });

    // подгруппы
    $this->get('/{country}/{families}/{model}/{modification}/{group}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['families']}/{$args['model']}/{$args['modification']}/{$args['group']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'kia/subgroups.php', $data);
    });

    // номера (артикулы) запчастей
    $this->get('/{country}/{families}/{model}/{modification}/{group}/{subgroup}', function (Request $request, Response $response, array $args) {
        $settings = Helper::getJSON($this->get('settings')['api']);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['country']}/{$args['families']}/{$args['model']}/{$args['modification']}/{$args['group']}/{$args['subgroup']}");
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'kia/numbers.php', $data);
    });
});