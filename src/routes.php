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
        'types' => $types,
        'error' => null
    ]);
});

// Поиск
$app->get('/search', function (Request $request, Response $response, array $args) use ($rr) {
    $settings = Helper::getJSON($this->get('settings')['api']);

    $data = Helper::getData($settings, true,"/search2?text={$request->getQueryParams()['text']}");
    $data['hrefPrefix'] = $settings->urlBeforeCatalog;
    $data['searchValue'] = $request->getQueryParams()['text'];
    if (isset($data) && is_array($data) && array_key_exists('error', $data)) {
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
        //dd($data);
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