<?php
session_start();

require_once '../core/API/Autoloader.php';
require_once '../config.inc.php';

$manifest = json_decode(file_get_contents('../manifest.json'), true);

$modulesToLoad = array();
foreach ($manifest['modules'] as $module) {
    array_push($modulesToLoad, '../core/Modules/' . $module . '/*.php');
}

$config = array(
    'load' => $modulesToLoad
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
