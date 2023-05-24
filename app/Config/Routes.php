<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
* --------------------------------------------------------------------
* Router Setup
* --------------------------------------------------------------------
*/
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Users');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
* --------------------------------------------------------------------
* Route Definitions
* --------------------------------------------------------------------
*/

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Users::index');
$routes->group('home', ['filter' => 'auth'], function($routes)
{
	$routes->get('/', 'Users::home');
	$routes->match(['get', 'post'],'add-user', 'Users::save_user', ["as" => "add-user"]);
	$routes->match(['get', 'post'], 'extension-officers', 'Users::view_ext_officers');
	$routes->match(['get', 'post'], 'activities', 'Users::addActivities');
	$routes->post('activities_json', 'Users::addActivitiesJSON');
	$routes->get('activities/remove-constraint/(:any)', 'Users::removeConstraint/$1');
	$routes->post('activities/delete', 'Users::deleteActivity');
	$routes->match(['get', 'post'], 'sms-farmers', 'Users::smsUsers', ["as" => "smsfarmers"]);
	$routes->get('sms-farmers/trash/(:segment)', 'Users::removeSmsUser/$1');
	$routes->post('extension-officers/delete', 'Users::deleteUser');
});

// $routes->get('/user-profile', 'Users::profile', ['filter' => 'auth']);

$routes->get('/login', 'Users::index');
$routes->get('forecast', 'WeatherCron::index');
$routes->get('forecast2', 'WeatherCron::index2');
$routes->get('send-sms', 'SendSms::index');
$routes->match(['get', 'post'], '/login/auth', 'Users::auth');
$routes->get('/user-logout', 'Users::logout');
$routes->match(['get', 'post'], '/forgotpasword', 'Users::passwordForgot');
$routes->post('import-csv', 'SendSms::addSMSUsers');
$routes->get('app', 'Users::getApp');

$routes->group("ajax", function ($routes) {
	$routes->post("save-user", "Serveajax::saveUser");
});

$routes->group("api", function ($routes) {
	
	$routes->get("wards-list", "ApiController::getWards");
	$routes->get("get-weather/(:segment)", "ApiController::getWeather/$1");
	$routes->get("get-weather2/(:segment)", "ApiController::getWeather2/$1");

	$routes->post("check-pro", "ApiController::checkIfPro");
	$routes->post("submit-pro", "ApiController::submitPro");
	$routes->post("reset-pro", "Api::resetPro");
	$routes->get("parcels-to-receive/(:segment)", "Api::getParcelsToReceive/$1");
	$routes->get("parcels-to-send/(:segment)", "Api::getParcelsToSend/$1");
	$routes->post("detect-product", "Api::detectProduct");
});

$routes->environment('development', function($routes)
{
    $routes->get('migrate', 'Migrate::index');
    $routes->get('seed', 'Seed::index');
});

/*
* --------------------------------------------------------------------
* Additional Routing
* --------------------------------------------------------------------
*
* There will often be times that you need additional routing and you
* need it to be able to override any defaults in this file. Environment
* based routes is one such time. require() additional route files here
* to make that happen.
*
* You will have access to the $routes object within that file without
* needing to reload it.
*/
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}