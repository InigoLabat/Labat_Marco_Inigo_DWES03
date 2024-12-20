<?php

require_once __DIR__ . '/../config/routes.php';
require_once __DIR__ . '/../app/controllers/AthleteController.php';
require_once __DIR__ . '/../app/controllers/ClubController.php';
require_once __DIR__ . '/../app/controllers/FederationController.php';

$url = $_SERVER['QUERY_STRING'];

$urlParams = explode('/', $url);

$urlArray = array(
    'HTTP'=>$_SERVER['REQUEST_METHOD'],
    'path'=>$url,
    'controller'=>'',
    'action'=>'',
    'params'=>''
);

//Front controller
if(!empty($urlParams[2])){
    $urlArray['controller'] = ucwords($urlParams[2]);
    if(!empty($urlParams[3])){
        $urlArray['action'] = $urlParams[3];
        if(!empty($urlParams[4])){
            $urlArray['params'] = $urlParams[4];
        }
    }else{
        $urlArray['action'] = 'index';
    }
} else {
    $urlArray['controller'] = 'Home';
    $urlArray['action'] = 'index';
}

$method = $_SERVER['REQUEST_METHOD'];

$params = [];

if ($method === 'GET') {

    $params[] = intval($urlArray['params']) ?? null;

} elseif ($method === 'POST') {

    $json = file_get_contents('php://input');
    $params[] = json_decode($json, true);

} elseif ($method === 'PUT') {

    $id = intval($urlArray['params']) ?? null;
    $json = file_get_contents('php://input');
    $params[] = $id;
    $params[] = json_decode($json, true);

} elseif ($method === 'DELETE') {
    $params[] = intval($urlArray['params']) ?? null;
}

if ($router->matchRoutes($urlArray)) {
    $controller = $router->getParams()['controller'];
    $action = $router->getParams()['action'];
    $controller = new $controller();
    if (method_exists($controller, $action)) {
        call_user_func_array([$controller, $action], $params);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Método no existe"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["error" => "Ruta no encontrada"]);
}
