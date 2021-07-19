<?php
use Slim\Http\Request;
use Slim\Http\Response;
use GuzzleHttp\Client;

$client = new Client();
$response = $client->request('GET', 'https://acat.online/api/public/types');
$response = $rr = json_decode($response->getBody()->getContents()); // available types & marks for each catalog

/* Middleware */
$app->add(function (Request $request, Response $response, $next) {
    $settings = Helper::getJSON($this->get('settings')['api']);
    $token = null;
    $bodyToken = false;
    if ($request->getCookieParam('acat_api_token')) {
        $token = $request->getCookieParam('acat_api_token');
    } else {
        $body = $request->getParsedBody();
        if (is_array($body) && array_key_exists('token', $body) && !empty($body['token'])) {
            $bodyToken = true;
            $token = $body['token'];
        }
    }

    if (!$bodyToken && (!empty($settings->token) || $token)) {
        return $next($request, $response);
    } elseif ($bodyToken && !empty($token)) {
        setcookie('acat_api_token', $token, time()+60*60*24, '/');
        return $response->withRedirect('/', 302);
    } else {
        return $this->renderer->render($response, 'auth.php', ['error' => 'Не верный API token<br>Проверьте правильность']);
    }
});


$app->get('/', function (Request $request, Response $response) {
    $settings = $this->get('settings')['api'];
    if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
        $settings['token'] = $request->getCookieParam('acat_api_token');
    $settings = Helper::getJSON($settings);
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
    $error = '';

    if ($types instanceof stdClass && property_exists($types, 'status') && $types->code === 401) {
        setcookie('acat_api_token', '', time()-60*60*24, '/');
        return $this->renderer->render($response, 'auth.php', ['error' => 'Не верный API token<br>Проверьте правильность']);
    }
    if ($types instanceof stdClass && property_exists($types, 'code') && $types->code === 403) {
        $error = $types->message;
    }

    return $this->renderer->render($response, 'index.php', [
        'hrefPrefix' => $settings->urlBeforeCatalog,
        'types' => $types,
        'error' => $error
    ]);
});

// Поиск
$app->get('/search', function (Request $request, Response $response, array $args) use ($rr) {
    $settings = $this->get('settings')['api'];
    if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
        $settings['token'] = $request->getCookieParam('acat_api_token');
    $settings = Helper::getJSON($settings);

    $data = Helper::getData($settings, true,"/search2?text={$request->getQueryParams()['text']}");

    if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
        setcookie('acat_api_token', '', time()-60*60*24, '/');
        return $this->renderer->render($response, 'auth.php', ['error' => 'Не верный API token<br>Проверьте правильность']);
    }
    $data['hrefPrefix'] = $settings->urlBeforeCatalog;
    $data['searchValue'] = $request->getQueryParams()['text'];
    if (isset($data) && is_array($data) && array_key_exists('error', $data)) {
        return $this->renderer->render($response, 'search/index.php', $data);
    }
    if ((array_key_exists('vins', $data) && count($data['vins']) === 1) || (array_key_exists('frames', $data) && count($data['frames']) === 1)) {
        $vin = count($data['vins']) === 1 ? $data['vins'][0] : $data['frames'][0];
        switch (property_exists($vin, 'mark')) {
            case (in_array($vin->mark, ['FIAT', 'LANCIA', 'ALFA_ROMEO', 'ABARTH'])):
                $url = "/{$vin->type}/{$vin->mark}/{$vin->model_short_name}/{$vin->modification_short_name}";
                return $response->withRedirect($url, 301);
                break;
            case (in_array($vin->mark, $rr->parts->marks)):
                $criteria = urlencode($vin->criteria);
                $url = "/{$vin->type}/{$vin->mark}/{$vin->model}/{$vin->modification}?criteria={$criteria}";
                return $response->withRedirect($url, 301);
                break;
            case (in_array($vin->mark, $rr->a2d->marks)):
                $url = "/{$vin->type}/{$vin->mark}/{$vin->model_short_name}/{$vin->modification_short_name}";
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
        $settings = $this->get('settings')['api'];
        if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
            $settings['token'] = $request->getCookieParam('acat_api_token');
        $settings = Helper::getJSON($settings);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");

        if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
            setcookie('acat_api_token', '', time()-60*60*24, '/');
            return $this->renderer->render(
                $response,
                'auth.php',
                [ 'error' => 'Не верный API token<br>Проверьте правильность' ]
            );
        }
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'parts/models.php', $data);
    });
    // модели
    $this->get('/{model}', function (Request $request, Response $response, array $args) {
        $settings = $this->get('settings')['api'];
        if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
            $settings['token'] = $request->getCookieParam('acat_api_token');
        $settings = Helper::getJSON($settings);
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

        if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
            setcookie('acat_api_token', '', time()-60*60*24, '/');
            return $this->renderer->render(
                $response,
                'auth.php',
                [ 'error' => 'Не верный API token<br>Проверьте правильность' ]
            );
        }
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'parts/modifications.php', $data);
    });
    // группы
    $this->get('/{model}/{modification}[/{group}]', function (Request $request, Response $response, array $args) {
        $settings = $this->get('settings')['api'];
        if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
            $settings['token'] = $request->getCookieParam('acat_api_token');
        $settings = Helper::getJSON($settings);
        $url = "/{$args['type']}/{$args['mark']}/{$args['model']}/${args['modification']}";
        if (isset($args['group']) && !empty($args['group'])) {
            $url .= "/{$args['group']}";
        }
        if ($request->getQueryParam('criteria')) {
            $url .= '?criteria='.urlencode($request->getQueryParam('criteria'));
        }
        $data = Helper::getData($settings, true, $url);

        if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
            setcookie('acat_api_token', '', time()-60*60*24, '/');
            return $this->renderer->render(
                $response,
                'auth.php',
                [ 'error' => 'Не верный API token<br>Проверьте правильность' ]
            );
        }
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        if ($request->getQueryParam('criteria')) {
            $data['criteria'] = $request->getQueryParam('criteria');
        }

        return $this->renderer->render($response, 'parts/groups.php', $data);
    });
    // номера
    $this->get('/{model}/{modification}/{group}/{subgroup}', function (Request $request, Response $response, array $args) {
        $settings = $this->get('settings')['api'];
        if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
            $settings['token'] = $request->getCookieParam('acat_api_token');
        $settings = Helper::getJSON($settings);
        $url = "/{$args['type']}/{$args['mark']}/{$args['model']}/${args['modification']}/${args['group']}/${args['subgroup']}";
        if ($request->getQueryParam('criteria')) {
            $url .= '?criteria='.$request->getQueryParam('criteria');
        }
        $data = Helper::getData($settings, true, $url);

        if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
            setcookie('acat_api_token', '', time()-60*60*24, '/');
            return $this->renderer->render(
                $response,
                'auth.php',
                [ 'error' => 'Не верный API token<br>Проверьте правильность' ]
            );
        }
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'parts/numbers.php', $data);
    });
});

//a2d
$app->group('/{type:'.implode('|', $response->a2d->types).'}/{mark:'.implode('|', $response->a2d->marks).'}', function () {

    // поиск но номеру(артикулу)
    $this->get('/search', function (Request $request, Response $response, array $args) {
        $settings = $this->get('settings')['api'];
        if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
            $settings['token'] = $request->getCookieParam('acat_api_token');
        $settings = Helper::getJSON($settings);
        $search = $request->getQueryParam('number');
        $data['numbers'] = Helper::getData($settings, true,"/search2?type={$args['type']}&mark={$args['mark']}&number={$search}");

        if ($data['numbers'] instanceof stdClass && property_exists($data['numbers'], 'status') && $data['numbers']->code === 401) {
            setcookie('acat_api_token', '', time()-60*60*24, '/');
            return $this->renderer->render(
                $response,
                'auth.php',
                [ 'error' => 'Не верный API token<br>Проверьте правильность' ]
            );
        }
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'a2d/search.php', $data);
    });

    // модели
    $this->get('', function (Request $request, Response $response, array $args) {
        $settings = $this->get('settings')['api'];
        if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
            $settings['token'] = $request->getCookieParam('acat_api_token');
        $settings = Helper::getJSON($settings);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}");

        if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
            setcookie('acat_api_token', '', time()-60*60*24, '/');
            return $this->renderer->render(
                $response,
                'auth.php',
                [ 'error' => 'Не верный API token<br>Проверьте правильность' ]
            );
        }
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;
        $data['isSKD'] = stripos($args['mark'], '_SKD') > 0;
        return $this->renderer->render($response, 'a2d/models.php', $data);
    });

    // группы
    $this->get('/{modelId}', function (Request $request, Response $response, array $args) {
        $settings = $this->get('settings')['api'];
        if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
            $settings['token'] = $request->getCookieParam('acat_api_token');
        $settings = Helper::getJSON($settings);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['modelId']}");

        if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
            setcookie('acat_api_token', '', time()-60*60*24, '/');
            return $this->renderer->render(
                $response,
                'auth.php',
                [ 'error' => 'Не верный API token<br>Проверьте правильность' ]
            );
        }
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'a2d/groups.php', $data);
    });

    // номера (артикулы) запчастей
    $this->get('/{modelId}/{groupId}', function (Request $request, Response $response, array $args) {
        $settings = $this->get('settings')['api'];
        if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
            $settings['token'] = $request->getCookieParam('acat_api_token');
        $settings = Helper::getJSON($settings);

        $data = Helper::getData($settings, true,"/{$args['type']}/{$args['mark']}/{$args['modelId']}/{$args['groupId']}");

        if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
            setcookie('acat_api_token', '', time()-60*60*24, '/');
            return $this->renderer->render(
                $response,
                'auth.php',
                [ 'error' => 'Не верный API token<br>Проверьте правильность' ]
            );
        }
        $data['hrefPrefix'] = $settings->urlBeforeCatalog;

        return $this->renderer->render($response, 'a2d/numbers.php', $data);
    });

    //изображение
    $this->get('/{modelId}/{groupId}/image', function (Request $request, Response $response, array $args) {
        $settings = $this->get('settings')['api'];
        if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
            $settings['token'] = $request->getCookieParam('acat_api_token');
        $settings = Helper::getJSON($settings);

        $data = Helper::getImage($settings, "/{$args['type']}/{$args['mark']}/{$args['modelId']}/{$args['groupId']}/image");

        if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
            setcookie('acat_api_token', '', time()-60*60*24, '/');
            return $this->renderer->render(
                $response,
                'auth.php',
                [ 'error' => 'Не верный API token<br>Проверьте правильность' ]
            );
        }
        $response->write($data);

        return $response->withHeader('Content-Type', FILEINFO_MIME_TYPE);
    });
});