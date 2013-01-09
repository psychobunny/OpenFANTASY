<?php
session_start();

require_once '../core/API/Autoloader.php';
require_once '../config.inc.php';

//todo: create manifest file and load modules from there.
$config = array(
    'load' => array(
        '../*.php',
        '../core/Modules/User/*.php',
        '../core/Modules/User/Admin/*.php',
        '../core/Modules/Tools/*.php',
        '../core/Modules/HelloWorld/*.php',
        '../core/Modules/Social/*.php'
    )
);

$app = new API\Application($config);
$request = new API\Request();

try {

    $resource = $app->getResource($request);
    $response = $resource->exec();

} catch (API\NotFoundException $e) {
    $response = new API\Response(404, $e->getMessage());

} catch (API\UnauthorizedException $e) {
    $response = new API\Response(401, $e->getMessage());
    $response->wwwAuthenticate = 'Basic realm="My Realm"';

} catch (API\Exception $e) {
    $response = new API\Response($e->getCode(), $e->getMessage());
}

$response->output();
