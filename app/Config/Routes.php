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
//User งานจองห้อง
$routes->get('Booking', 'ConUserBooking::BookingMain');
$routes->get('Booking/Select', 'ConUserBooking::BookingSelect');
$routes->get('Booking/Add/(:any)', 'ConUserBooking::BookingAdd/$1');
$routes->get('Booking/View/(:any)', 'ConUserBooking::BookingView/$1');
$routes->get('Booking/Edit/(:any)', 'ConUserBooking::BookingEdit/$1');
$routes->get('Booking/Approve/Admin', 'ConUserBooking::BookingViewApproveAdmin');
$routes->get('Booking/Approve/Executive', 'ConUserBooking::BookingViewApproveExecutive');
$routes->match(['get', 'post'],'Booking/DB/Insert', 'ConUserBooking::BookingInsert');
$routes->match(['get', 'post'],'Booking/DB/Update', 'ConUserBooking::BookingUpdate');
$routes->match(['get', 'post'],'Booking/DB/Cancel', 'ConUserBooking::BookingCancel');
$routes->match(['get', 'post'],'Booking/DB/ShowTimeBooking', 'ConUserBooking::ShowTimeBooking');
$routes->match(['get', 'post'],'Booking/DB/CheckDateBooking', 'ConUserBooking::CheckDateBooking');
$routes->match(['get', 'post'],'Booking/DB/CheckTimeBooking', 'ConUserBooking::CheckTimeBooking');
$routes->match(['get', 'post'],'User/Dictation/ShowData', 'ConUserWorkSaraban::DictationShowData');
$routes->match(['get', 'post'],'Booking/DB/DataTable/Approve/Admin', 'ConUserBooking::BookingDataTableApproveAdmin');
$routes->match(['get', 'post'],'Booking/DB/DataTable/Approve/Executive', 'ConUserBooking::BookingDataTableApproveExecutive');
$routes->match(['get', 'post'],'Booking/DB/BookingApproveAdmin', 'ConUserBooking::BookingCheckApproveAdmin');
$routes->match(['get', 'post'],'Booking/DB/BookingNoApproveAdmin', 'ConUserBooking::BookingNoApproveAdmin');


// User แจ้งซ่อม
$routes->get('Repair', 'ConUserRepair::RepairMain');
$routes->get('Repair/Add', 'ConUserRepair::RepairAdd');
$routes->match(['get', 'post'],'Repair/DB/CheckPosiUser', 'ConUserRepair::CheckPosiUser');
$routes->match(['get', 'post'],'Repair/DB/Insert', 'ConUserRepair::RepairInsert');
$routes->match(['get', 'post'],'Repair/DataTable/ShowRepari', 'ConUserRepair::DataTableShowRepari');
$routes->match(['get', 'post'],'Repair/DB/CheckRepairFullDetail', 'ConUserRepair::CheckRepairFullDetail');
$routes->match(['get', 'post'],'Repair/DB/UpdateWork', 'ConUserRepair::RepairUpdateWork');
$routes->get('Repair/PrintOrder/(:any)', 'ConUserRepair::PrintOrder/$1');

$routes->get('/LoginOfficerGeneral', 'ConLogin::LoginOfficerGeneral');
//$routes->get('/LoginEoffice', 'ConUserHome::LoginEoffice');
$routes->get('/LogoutOfficerGeneral', 'ConLogin::LogoutOfficerGeneral');

//Admin
$routes->get('Admin/Home', 'ConAdminHome::index');
$routes->get('Admin/LocationRoom/LocationRoomMain', 'ConAdminLocationRoom::LocationRoomMain');

$routes->post('Admin/LocationRoom/Insert', 'ConAdminLocationRoom::LocationRoomInsert');
$routes->match(['get', 'post'],'Admin/LocationRoom/Delete', 'ConAdminLocationRoom::LocationRoomDelete');
$routes->match(['get', 'post'],'Admin/LocationRoom/ShowData', 'ConAdminLocationRoom::LocationRoomShowData');

$routes->get('Admin/Rloes/Setting', 'ConAdminRoles::index');
$routes->match(['get', 'post'],'Admin/Rloes/RloesSettingManager', 'ConAdminRoles::RloesSettingManager');

//Admin Person
$routes->get('Admin/WorkPerson/Personnel', 'ConAdminWorkPerson::index');
$routes->get('Admin/WorkPerson/Personnel/Add', 'ConAdminWorkPerson::FormAdd');
$routes->get('Admin/WorkPerson/Personnel/Group/(:any)', 'ConAdminWorkPerson::PersonneViewGroup/$1');
$routes->get('Admin/WorkPerson/Personnel/Update/(:any)', 'ConAdminWorkPerson::FormPersonneUpdate/$1');
$routes->match(['get', 'post'],'Admin/WorkPerson/Personnel/DB/SortableTeacher', 'ConAdminWorkPerson::SortableTeacher');
$routes->match(['get', 'post'],'Admin/WorkPerson/Personnel/DB/Insert', 'ConAdminWorkPerson::PersonnelInsert');
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
