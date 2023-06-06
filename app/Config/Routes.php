<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'ConUserHome::index');
$routes->get('User/WorkSaraban/InstructionMain', 'ConUserWorkSaraban::InstructionMain');

$routes->get('/LoginEoffice', 'ConUserHome::LoginEoffice');
$routes->get('/LogOutEoffice', 'ConUserHome::LogOutEoffice');

//Admin
//งานสารบรรณ
$routes->get('Admin/Home', 'ConAdminHome::index');
$routes->get('Admin/WorkSaraban/InstructionMain', 'ConAdminWorkSaraban::InstructionMain');

$routes->post('Admin/Dictation/Insert', 'ConAdminWorkSaraban::DictationInsert');
$routes->match(['get', 'post'],'Admin/Dictation/ShowData', 'ConAdminWorkSaraban::DictationShowData');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
