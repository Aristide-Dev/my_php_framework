<?php
session_start();

use Router\Router;
use App\Exceptions\NotFoundException;

require("../vendor/autoload.php");




define('AJAX', ".." . DIRECTORY_SEPARATOR . 'ajax' . DIRECTORY_SEPARATOR);
define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define("SCRIPTS", dirname($_SERVER["SCRIPT_NAME"]) . DIRECTORY_SEPARATOR);
define("PHOTO", dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public'. DIRECTORY_SEPARATOR."assets". DIRECTORY_SEPARATOR."photo".DIRECTORY_SEPARATOR);

$router = new Router();


// home rooutes
$router->get('/', "App\Controllers\HomeController@welcome");
$router->get('/welcome', "App\Controllers\HomeController@welcome");



$router->get('/login', "App\Controllers\AuthController@login");
$router->post('/auth', "App\Controllers\AuthController@loginAuth");
$router->post('/auth-first-login', "App\Controllers\AuthController@first_login");
$router->get('/logout', "App\Controllers\AuthController@logout");


$router->get('/qrcode', "App\Controllers\QrcodeController@index");

// **************************************************************************************
// ADMIN routes
$router->get('/admin', "App\Controllers\Admin\AdminController@index");

$router->get('/admin/membre', "App\Controllers\Admin\AdminMembreController@index");
$router->get('/admin/membre/details/:id', "App\Controllers\Admin\AdminMembreController@show");
$router->post('/admin/membre/ajouter', "App\Controllers\Admin\AdminMembreController@store");
$router->post('/admin/membre/updatepi/:id', "App\Controllers\Admin\AdminMembreController@updatePersonalInformation");
$router->post('/admin/membre/updatepw/:id', "App\Controllers\Admin\AdminMembreController@updatePassword");
$router->post('/admin/membre/setMembrePermission', "App\Controllers\Admin\AdminMembreController@setMembrePermission");

$router->get("/admin/groupe", "App\Controllers\Admin\AdminGroupeController@index");
$router->get('/admin/groupe/details/:id', "App\Controllers\Admin\AdminGroupeController@show");

// ***************************************************************************************
// **************************************************************************************
// MANAGER index routes

$router->get('/manager', "App\Controllers\Manager\ManagerController@index");

// ***************************************************************************************
// **************************************************************************************
// GESTIONNAIRE index routes

$router->get('/gestionnaire', "App\Controllers\Gestionnaire\GestionnaireController@index");

// ***************************************************************************************
// **************************************************************************************
// COMPTABLE index routes

$router->get('/comptable', "App\Controllers\Comptable\ComptableController@index");









try {
	$router->run();
} catch (NotFoundException $e) {
	return $e->error404();
}
