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
$routes->get('manual/booking', 'ConUserManual::bookingSystemManual');
$routes->get('manual/car-booking', 'ConUserManual::carBookingSystemManual');
$routes->get('manual/repair', 'ConUserManual::repairSystemManual');

//User งานจองห้อง
$routes->get('Booking', 'ConUserBooking::BookingMain');

$routes->get('Booking/Add/(:any)', 'ConUserBooking::BookingAdd/$1');
$routes->get('Booking/View/(:any)', 'ConUserBooking::BookingView/$1');
$routes->get('Booking/Edit/(:any)', 'ConUserBooking::BookingEdit/$1');
$routes->get('Booking/Approve/Admin', 'ConUserBooking::BookingViewApproveAdmin');
$routes->get('Booking/Approve/Executive', 'ConUserBooking::BookingViewApproveExecutive');
$routes->get('Booking/Approve/File/Requestform/(:any)', 'ConUserBooking::BookingRequestform/$1');
$routes->match(['get', 'post'],'Booking/DB/Insert', 'ConUserBooking::BookingInsert');
$routes->match(['get', 'post'],'Booking/DB/Update', 'ConUserBooking::BookingUpdate');
$routes->match(['get', 'post'],'Booking/DB/Cancel', 'ConUserBooking::BookingCancel');
$routes->match(['get', 'post'],'Booking/DB/ShowTimeBooking', 'ConUserBooking::ShowTimeBooking');
$routes->match(['get', 'post'],'Booking/CheckDateBooking', 'ConUserBooking::CheckDateBooking');
$routes->match(['get', 'post'],'Booking/DB/CheckTimeBooking', 'ConUserBooking::CheckTimeBooking');
$routes->match(['get', 'post'],'User/Dictation/ShowData', 'ConUserWorkSaraban::DictationShowData');
$routes->match(['get', 'post'],'Booking/DB/DataTable/Approve/Admin', 'ConUserBooking::BookingDataTableApproveAdmin');
$routes->match(['get', 'post'],'Booking/DB/DataTable/Approve/Executive', 'ConUserBooking::BookingDataTableApproveExecutive');
$routes->match(['get', 'post'],'Booking/DB/BookingApproveAdmin', 'ConUserBooking::BookingCheckApproveAdmin');
$routes->match(['get', 'post'],'Booking/DB/BookingNoApproveAdmin', 'ConUserBooking::BookingNoApproveAdmin');
$routes->match(['get', 'post'],'Booking/DB/ResetAppoveBookingAdmin', 'ConUserBooking::BookingResetStatus');
$routes->match(['get', 'post'],'Booking/DB/BookingSignatureAdmin/Save', 'ConUserBooking::BookingSignatureAdminSave');
$routes->match(['get', 'post'],'Booking/DB/BookingSignatureAdmin/Show/(:any)', 'ConUserBooking::BookingSignatureAdminShow/$1');
$routes->match(['get', 'post'],'Booking/DB/BookingSignatureExecutive/Save', 'ConUserBooking::BookingSignatureExecutiveSave');
$routes->match(['get', 'post'],'Booking/DB/BookingSignatureExecutive/Show/(:any)', 'ConUserBooking::BookingSignatureExecutiveShow/$1');

$routes->match(['get', 'post'],'Booking/DB/BookingChart', 'ConUserBooking::BookingChart');
$routes->get('Booking/getBookingCalendarJson', 'ConUserBooking::getBookingCalendarJson');

//User งานจองยานพาหนะ
$routes->get('CarBooking', 'ConUserCarBooking::CarBookingMain');
$routes->get('CarBooking/View', 'ConUserCarBooking::CarBookingView');
$routes->get('CarBooking/CheckCar', 'ConUserCarBooking::CarBookingCheckCar');
$routes->get('CarBooking/Add/(:any)', 'ConUserCarBooking::CarBookingAdd/$1');
$routes->get('CarBooking/Edit/(:any)', 'ConUserCarBooking::CarBookingEdit/$1');
$routes->post('CarBooking/Update', 'ConUserCarBooking::CarBookingUpdate');
$routes->match(['get', 'post'],'Booking/DB/ShowTimeCarBooking', 'ConUserCarBooking::ShowTimeCarBooking');
$routes->match(['get', 'post'],'CarBooking/DB/DataTable/View', 'ConUserCarBooking::CarBookingDataTableView');
$routes->match(['get', 'post'],'Booking/DB/CheckDateCarBooking', 'ConUserCarBooking::CheckDateCarBooking');
$routes->match(['get', 'post'],'CarBooking/DB/Insert', 'ConUserCarBooking::CarBookingInsert');
$routes->get('CarBooking/Approve/Admin', 'ConUserCarBooking::CarBookingViewApproveAdmin');
$routes->match(['get', 'post'],'CarBooking/DB/DataTable/Approve/Admin', 'ConUserCarBooking::CarBookingDataTableApproveAdmin');
$routes->match(['get', 'post'],'CarBooking/DB/AppoveCarReservationAdmin', 'ConUserCarBooking::CarBookingApproveAdmin');
$routes->match(['get', 'post'],'CarBooking/DB/NoAppoveCarReservationAdmin', 'ConUserCarBooking::CarBookingNoApproveAdmin');
$routes->match(['get', 'post'],'CarBooking/DB/ResetAppoveCarReservationAdmin', 'ConUserCarBooking::CarBookingResetStatus');

$routes->get('CarBooking/Approve/Admin/Print/(:any)', 'ConUserCarBooking::PrintApproveCarBooking/$1');
$routes->match(['get', 'post'],'Booking/DB/BookingCarChart', 'ConUserCarBooking::BookingCarChart');

// User แจ้งซ่อม
$routes->get('Repair', 'ConUserRepair::RepairMain');
$routes->get('Repair/Add', 'ConUserRepair::RepairAdd');
$routes->match(['get', 'post'],'Repair/DB/CheckPosiUser', 'ConUserRepair::CheckPosiUser');
$routes->match(['get', 'post'],'Repair/DB/Insert', 'ConUserRepair::RepairInsert');
$routes->match(['get', 'post'],'Repair/DataTable/ShowRepari', 'ConUserRepair::DataTableShowRepari');
$routes->match(['get', 'post'],'Repair/DB/CheckRepairFullDetail', 'ConUserRepair::CheckRepairFullDetail');
$routes->match(['get', 'post'],'Repair/DB/UpdateWork', 'ConUserRepair::RepairUpdateWork');
$routes->get('Repair/PrintOrder/(:any)', 'ConUserRepair::PrintOrder/$1');
$routes->get('Repair/View/(:any)', 'ConUserRepair::ViewOrder/$1');
$routes->get('Repair/RepairStatistics', 'ConUserRepair::RepairStatistics');
$routes->match(['get', 'post'],'Repair/DB/CleanupImages', 'ConUserRepair::CleanupImages');
$routes->match(['get', 'post'],'Repair/DB/StatisticsCaselist', 'ConUserRepair::RepairStatisticsCaselist');

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
$routes->post('Admin/Rloes/AddRole', 'ConAdminRoles::AddRole');
$routes->post('Admin/Rloes/DeleteRole', 'ConAdminRoles::DeleteRole');
$routes->match(['get', 'post'],'Admin/Rloes/AddDepartment', 'ConAdminRoles::AddDepartment');

//Admin Person
$routes->get('Admin/WorkPerson/Personnel', 'ConAdminWorkPerson::index');
$routes->get('Admin/WorkPerson/Personnel/Add', 'ConAdminWorkPerson::FormAdd');
$routes->get('Admin/WorkPerson/Personnel/Group/(:any)', 'ConAdminWorkPerson::PersonneViewGroup/$1');
$routes->get('Admin/WorkPerson/Personnel/Update/(:any)', 'ConAdminWorkPerson::FormPersonneUpdate/$1');
$routes->match(['get', 'post'],'Admin/WorkPerson/Personnel/DB/SortableTeacher', 'ConAdminWorkPerson::SortableTeacher');
$routes->match(['get', 'post'],'Admin/WorkPerson/Personnel/DB/Insert', 'ConAdminWorkPerson::PersonnelInsert');
$routes->match(['get', 'post'],'Admin/WorkPerson/Personnel/DB/Update/DataGeneral', 'ConAdminWorkPerson::PersonneUpdateDataGeneral');
$routes->match(['get', 'post'],'Admin/WorkPerson/Personnel/DB/Update/Img', 'ConAdminWorkPerson::PersonnelUpdateImg');

//Admin งานจองยานพาหนะ
$routes->get('Admin/Car/CarMain', 'ConAdminCar::CarMain');
$routes->get('Admin/Car/CarDriver', 'ConAdminCar::CarDriver');
$routes->match(['get', 'post'],'Admin/Car/ShowData', 'ConAdminCar::CarShowData');
$routes->match(['get', 'post'],'Admin/Car/Insert', 'ConAdminCar::CarInsert');
$routes->match(['get', 'post'],'Admin/Car/Delete', 'ConAdminCar::CarDelete');
$routes->match(['get', 'post'],'Admin/CarDriver/ShowData', 'ConAdminCar::CarDriverShowData');
$routes->match(['get', 'post'],'Admin/CarDriver/Insert', 'ConAdminCar::CarDriverInsert');
$routes->match(['get', 'post'],'Admin/CarDriver/Delete', 'ConAdminCar::CarDriverDelete');


// User Food Report
$routes->get('FoodReport', 'ConUserFoodReport::index');
$routes->get('FoodReport/getFoodReportsJson', 'ConUserFoodReport::getFoodReportsJson');
$routes->get('FoodReport/print/(:num)', 'ConUserFoodReport::print/$1');
$routes->get('FoodReport/getReportById/(:num)', 'ConUserFoodReport::getReportById/$1');
$routes->post('FoodReport/insert', 'ConUserFoodReport::foodReportInsert');
$routes->post('FoodReport/update', 'ConUserFoodReport::foodReportUpdate');
$routes->post('FoodReport/delete', 'ConUserFoodReport::foodReportDelete');

$routes->get('check-vendor', 'ConUserFoodReport::checkVendor');

$routes->post('Webhook', 'Webhook::index');
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
