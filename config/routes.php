<?php
require_once __DIR__ . '/../core/Router.php';

$router = new Router();

// Cramos las url de atletas

$router->add('/public/atleta/get', array(
    'controller' => 'AthleteController',
    'action' => 'getAll'
));

$router->add('/public/atleta/get/{id}', array(
    'controller' => 'AthleteController',
    'action' => 'getAthleteById'
));

$router->add('/public/atleta/create', array(
    'controller' => 'AthleteController',
    'action' => 'create'
));

$router->add('/public/atleta/update/{id}', array(
    'controller' => 'AthleteController',
    'action' => 'updateAthlete'
));

$router->add('/public/atleta/delete/{id}', array(
    'controller' => 'AthleteController',
    'action' => 'deleteAthlete'
));

// Direcciones para clubes

$router->add('/public/club/get', array(
    'controller' => 'ClubController',
    'action' => 'getAll'
));

$router->add('/public/club/get/{id}', array(
    'controller' => 'ClubController',
    'action' => 'getClubById'
));

$router->add('/public/club/create', array(
    'controller' => 'ClubController',
    'action' => 'create'
));

$router->add('/public/club/update/{id}', array(
    'controller' => 'ClubController',
    'action' => 'updateClub'
));

$router->add('/public/club/delete/{id}', array(
    'controller' => 'ClubController',
    'action' => 'deleteClub'
));

// Direcciones para las federaciones
$router->add('/public/federacion/get', array(
    'controller' => 'FederationController',
    'action' => 'getAll'
));

$router->add('/public/federacion/get/{id}', array(
    'controller' => 'FederationController',
    'action' => 'getFederationById'
));

$router->add('/public/federacion/create', array(
    'controller' => 'FederationController',
    'action' => 'create'
));

$router->add('/public/federacion/update/{id}', array(
    'controller' => 'FederationController',
    'action' => 'updateFederation'
));

$router->add('/public/federacion/delete/{id}', array(
    'controller' => 'FederationController',
    'action' => 'deleteFederation'
));

return $router;