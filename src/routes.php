<?php
use Slim\Http\Request;
use Slim\Http\Response;

//$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//    $this->logger->info("Slim-Skeleton '/' route");
//    return $this->renderer->render($response, 'layout.php', $args);
//});
//$newResponse = $response->withHeader('Content-type', 'image/png');
//$newResponse->withStatus(404, 'Image not found');
//$request->getAttribute('host');

$app->get('/', function (Request $request, Response $response) {
    $settings = Helper::getJSON($this->get('settings')['api']);
    $types = Helper::getData($settings, '/catalogs');
//    dd($types);
    return $this->renderer->render($response, 'index.php', [
        'hrefPrefix' => $settings->urlBeforeCatalog,
        'types' => $types
    ]);
});
