<?php
use Slim\Http\Request;
use Slim\Http\Response;

$errorText = 'Не верный API token<br>Проверьте правильность';

/* Middleware */
$app->add(function (Request $request, Response $response, $next) use ($errorText) {
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
        return $this->renderer->render($response, 'auth.php', ['error' => $errorText]);
    }
});

// Поиск VIN/Frame(кузов), марка и модель
$app->get('/parts-search', function (Request $request, Response $response) use ($errorText) {
    $settings = $this->get('settings')['api'];
    if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
        $settings['token'] = $request->getCookieParam('acat_api_token');
    $settings = Helper::getJSON($settings);

    $queryParams = array_merge($request->getQueryParams(), ['lang' => $settings->lang]);
    $renderData = [];
    $data = Helper::getData($settings, false, '/searchParts2', $queryParams);

    if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
        setcookie('acat_api_token', '', time()-60*60*24, '/');
        return $this->renderer->render($response, 'auth.php', ['error' => $errorText]);
    }
    $page = $queryParams['page'] ? $queryParams['page'] : 1;
    $renderData['totalCount'] = $data->itemsCount ? $data->itemsCount : 0;
    $renderData['page'] = $page;
    $renderData['hasNextPage'] = ((int) $page + 1) * 25 < $renderData['totalCount'];
    $renderData['numbers'] = $data->items;
    $renderData['hrefPrefix'] = $settings->urlBeforeCatalog;
    $renderData['qp'] = $request->getQueryParams();

    return $this->renderer->render($response, 'parts-search.php', $renderData);
});
// Поиск но названию детали / номеру
$app->get('/search', function (Request $request, Response $response) use ($errorText) {
    $settings = $this->get('settings')['api'];
    if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
        $settings['token'] = $request->getCookieParam('acat_api_token');
    $settings = Helper::getJSON($settings);

    $queryParams = array_merge(['text' => $request->getQueryParam('text')], ['lang' => $settings->lang]);

    $data = Helper::getData($settings, true, '/search', $queryParams);

    if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
        setcookie('acat_api_token', '', time()-60*60*24, '/');
        return $this->renderer->render($response, 'auth.php', ['error' => $errorText]);
    }
    $data['hrefPrefix'] = $settings->urlBeforeCatalog;
    $data['searchValue'] = $request->getQueryParams()['text'];
    if (isset($data) && is_array($data) && array_key_exists('error', $data)) {
        return $this->renderer->render($response, 'search/index.php', $data);
    }
    if ((array_key_exists('vins', $data) && is_array($data['vins']) && count($data['vins']) === 1)) {
        $vin = $data['vins'][0];
        $url = $settings->urlBeforeCatalog . "/$vin->type/$vin->mark/$vin->model/$vin->modification?criteria=$vin->criteriaURI";
        return $response->withRedirect($url, 302);
    }

    return $this->renderer->render($response, 'search.php', $data);
});
// типы и марки
$app->get('/[{type}]', function (Request $request, Response $response, array $args) use ($errorText) {
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
    $types = Helper::getData($settings, false, '', ['lang' => $settings->lang]);
    if ($args['type'] && is_array($types)) {
        foreach ($types as $type) {
            if ($type->id === $args['type']) $type->active = true;
            else $type->active = false;
        }
    }
    $error = '';

    if ($types instanceof stdClass && property_exists($types, 'status') && $types->code === 401) {
        setcookie('acat_api_token', '', time()-60*60*24, '/');
        return $this->renderer->render($response, 'auth.php', ['error' => $errorText]);
    }
    if ($types instanceof stdClass && property_exists($types, 'code') && $types->code === 403) {
        $error = $types->message;
    }

    return $this->renderer->render($response, 'index.php', [
        'hrefPrefix' => $settings->urlBeforeCatalog,
        'types' => $types,
        'activeType' => $args['type'] ?: null,
        'error' => $error
    ]);
});

// модели
$app->get('/{type}/{mark}', function (Request $request, Response $response, array $args) use ($errorText) {
    $settings = $this->get('settings')['api'];
    if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
        $settings['token'] = $request->getCookieParam('acat_api_token');
    $settings = Helper::getJSON($settings);

    $queryParams = array_merge($args, ['lang' => $settings->lang]);

    $data = Helper::getData($settings, true,'/models', $queryParams);

    if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
        setcookie('acat_api_token', '', time()-60*60*24, '/');
        return $this->renderer->render(
            $response,
            'auth.php',
            [ 'error' => $errorText ]
        );
    }
    $data['hrefPrefix'] = $settings->urlBeforeCatalog;

    return $this->renderer->render($response, 'models.php', $data);
});

// модификации
$app->get('/{type}/{mark}/{model}', function (Request $request, Response $response, array $args) use ($errorText) {
    $settings = $this->get('settings')['api'];
    if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
        $settings['token'] = $request->getCookieParam('acat_api_token');
    $settings = Helper::getJSON($settings);
    $queryParams = array_merge($args, ['lang' => $settings->lang]);
    if (count($request->getQueryParams()) > 0) {
        foreach ($request->getQueryParams() as $k => $v) {
            if (strlen($request->getQueryParam($k)) > 0) {
                $queryParams[$k] = $request->getQueryParam($k);
            }
        }
    }

    $data = Helper::getData($settings, true, '/modifications', $queryParams);

    if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
        setcookie('acat_api_token', '', time()-60*60*24, '/');
        return $this->renderer->render(
            $response,
            'auth.php',
            [ 'error' => $errorText ]
        );
    }
    $data['hrefPrefix'] = $settings->urlBeforeCatalog;

    return $this->renderer->render($response, 'modifications.php', $data);
});

// группы
$app->get('/{type}/{mark}/{model}/{modification}[/{group}]', function (Request $request, Response $response, array $args) use ($errorText) {
    $settings = $this->get('settings')['api'];

    if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
        $settings['token'] = $request->getCookieParam('acat_api_token');
    $settings = Helper::getJSON($settings);

    $queryParams = array_merge($args, ['lang' => $settings->lang]);
    if ($request->getQueryParam('criteria')) {
        $queryParams['criteria'] = $request->getQueryParam('criteria');
    }

    $data = Helper::getData($settings, true, '/groups', $queryParams);

    if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
        setcookie('acat_api_token', '', time()-60*60*24, '/');
        return $this->renderer->render(
            $response,
            'auth.php',
            [ 'error' => $errorText ]
        );
    }
    $data['hrefPrefix'] = $settings->urlBeforeCatalog;
    if ($request->getQueryParam('criteria')) {
        $data['criteria'] = $request->getQueryParam('criteria');
    }
    if (count($data['groups'][0]->subGroups) > 0) {
        return $this->renderer->render($response, 'groups_loaded.php', $data);
    } else {
        return $this->renderer->render($response, 'groups_load.php', $data);
    }
});

// схема и номера
$app->get('/{type}/{mark}/{model}/{modification}/{parentGroup}/{group}', function (Request $request, Response $response, array $args) use ($errorText) {
    $settings = $this->get('settings')['api'];
    if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
        $settings['token'] = $request->getCookieParam('acat_api_token');
    $settings = Helper::getJSON($settings);

    $queryParams = array_merge($args, ['lang' => $settings->lang]);
    if ($request->getQueryParam('criteria')) {
        $queryParams['criteria'] = $request->getQueryParam('criteria');
    }
    $data = Helper::getData($settings, true, '/parts', $queryParams);

    if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
        setcookie('acat_api_token', '', time()-60*60*24, '/');
        return $this->renderer->render(
            $response,
            'auth.php',
            [ 'error' => $errorText ]
        );
    }
    $data['hrefPrefix'] = $settings->urlBeforeCatalog;
    if ($request->getQueryParam('criteria')) {
        $data['criteria'] = $request->getQueryParam('criteria');
    }
    $data['image'] = $settings->urlBeforeCatalog.'/'.join('/', $args).'/scheme';

    return $this->renderer->render($response, 'numbers.php', $data);
});

//изображение
$app->get('/{type}/{mark}/{model}/{modification}/{parentGroup}/{group}/scheme', function (Request $request, Response $response, array $args) use ($errorText) {
    $settings = $this->get('settings')['api'];
    if (empty($settings['token']) && $request->getCookieParam('acat_api_token'))
        $settings['token'] = $request->getCookieParam('acat_api_token');
    $settings = Helper::getJSON($settings);
    $data = Helper::getImage($settings, '/scheme', $args);
    if ($data instanceof stdClass && property_exists($data, 'status') && $data->code === 401) {
        setcookie('acat_api_token', '', time()-60*60*24, '/');
        return $this->renderer->render($response, 'auth.php', [ 'error' => $errorText ]);
    }
    $response->write($data);

    return $response->withHeader('Content-Type', FILEINFO_MIME_TYPE);
});