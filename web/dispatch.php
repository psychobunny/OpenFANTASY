<?php
session_start();

header("Access-Control-Allow-Origin: *"); 

require_once '../core/API/Autoloader.php';
require_once '../config.inc.php';


if ((!isset($_REQUEST['appKey']) || !isset($_REQUEST['appSecret'])) && (!isset($_SESSION['appKey']) || !isset($_SESSION['appSecret'])))
{
	die('Invalid appKey or appSecret.');
}

if (isset($_REQUEST['appKey']) && isset($_REQUEST['appSecret'])) //dev
{
	$appKey = $_REQUEST['appKey'];
	$appSecret = $_REQUEST['appSecret'];

	$_SESSION['appKey'] = $appKey;
	$_SESSION['appSecret'] = $appSecret;
}
else
{
    $appKey = $_SESSION['appKey'];
    $appSecret = $_SESSION['appSecret'];
}


$namespace = $appKey . $appSecret;

$manifest = json_decode(file_get_contents("../apps/$namespace/manifest.json"), true);

$modulesToLoad = array();
foreach ($manifest['modules'] as $module) {
    array_push($modulesToLoad, "../apps/$namespace/" . $module . '/*.php');
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
