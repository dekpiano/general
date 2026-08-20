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
$routes->get('manual', 'ConUserManual::index');
$routes->get('manual/booking', 'ConUserManual::bookingSystemManual');
$routes->get('manual/car-booking', 'ConUserManual::carBookingSystemManual');
$routes->get('manual/repair', 'ConUserManual::repairSystemManual');
$routes->get('manual/food-report', 'ConUserManual::foodReportManual');

// User รายงานอาหาร
$routes->get('FoodReport', 'ConUserFoodReport::index');
$routes->get('FoodReport/Print/(:any)', 'ConUserFoodReport::print/$1');
$routes->get('FoodReport/ExportWord/(:any)', 'ConUserFoodReport::exportWord/$1');
$routes->get('FoodReport/word/(:any)', 'ConUserFoodReport::exportWord/$1');
$routes->get('FoodReport/getFoodReportsJson', 'ConUserFoodReport::getFoodReportsJson');
$routes->match(['GET', 'POST'], 'FoodReport/insert', 'ConUserFoodReport::foodReportInsert');
$routes->match(['GET', 'POST'], 'FoodReport/update', 'ConUserFoodReport::foodReportUpdate');
$routes->match(['GET', 'POST'], 'FoodReport/delete', 'ConUserFoodReport::foodReportDelete');

//User งานจองห้อง
$routes->get('Booking', 'ConUserBooking::BookingMain');

$routes->get('Booking/Add/(:any)', 'ConUserBooking::BookingAdd/$1');
$routes->get('Booking/View/(:any)', 'ConUserBooking::BookingView/$1');
$routes->get('Booking/Edit/(:any)', 'ConUserBooking::BookingEdit/$1');
$routes->get('Booking/Approve/Admin', 'ConUserBooking::BookingViewApproveAdmin');
$routes->get('Booking/Approve/Executive', 'ConUserBooking::BookingViewApproveExecutive');
$routes->get('Booking/Approve/File/Requestform/(:any)', 'ConUserBooking::BookingRequestform/$1');
$routes->match(['GET', 'POST'],'Booking/DB/Insert', 'ConUserBooking::BookingInsert');
$routes->match(['GET', 'POST'],'Booking/DB/Update', 'ConUserBooking::BookingUpdate');
$routes->match(['GET', 'POST'],'Booking/DB/Cancel', 'ConUserBooking::BookingCancel');
$routes->match(['GET', 'POST'],'Booking/DB/ShowTimeBooking', 'ConUserBooking::ShowTimeBooking');
$routes->match(['GET', 'POST'],'Booking/CheckDateBooking', 'ConUserBooking::CheckDateBooking');
$routes->match(['GET', 'POST'],'Booking/DB/CheckDate', 'ConUserBooking::CheckDateBooking');
$routes->match(['GET', 'POST'],'Booking/DB/CheckTimeBooking', 'ConUserBooking::CheckTimeBooking');
$routes->match(['GET', 'POST'],'User/Dictation/ShowData', 'ConUserWorkSaraban::DictationShowData');
$routes->match(['GET', 'POST'],'Booking/DB/DataTable/Approve/Admin', 'ConUserBooking::BookingDataTableApproveAdmin');
$routes->match(['GET', 'POST'],'Booking/DB/DataTable/Approve/Executive', 'ConUserBooking::BookingDataTableApproveExecutive');
$routes->match(['GET', 'POST'],'Booking/DB/BookingApproveAdmin', 'ConUserBooking::BookingCheckApproveAdmin');
$routes->match(['GET', 'POST'],'Booking/DB/BookingNoApproveAdmin', 'ConUserBooking::BookingNoApproveAdmin');
$routes->match(['GET', 'POST'],'Booking/DB/ResetAppoveBookingAdmin', 'ConUserBooking::BookingResetStatus');
$routes->match(['GET', 'POST'],'Booking/DB/BookingSignatureAdmin/Save', 'ConUserBooking::BookingSignatureAdminSave');
$routes->match(['GET', 'POST'],'Booking/DB/BookingSignatureAdmin/Show/(:any)', 'ConUserBooking::BookingSignatureAdminShow/$1');
$routes->match(['GET', 'POST'],'Booking/DB/BookingSignatureExecutive/Save', 'ConUserBooking::BookingSignatureExecutiveSave');
$routes->match(['GET', 'POST'],'Booking/DB/BookingSignatureExecutive/Show/(:any)', 'ConUserBooking::BookingSignatureExecutiveShow/$1');

$routes->match(['GET', 'POST'],'Booking/DB/BookingChart', 'ConUserBooking::BookingChart');
$routes->get('Booking/getBookingCalendarJson', 'ConUserBooking::getBookingCalendarJson');

//User งานจองยานพาหนะ
$routes->get('CarBooking', 'ConUserCarBooking::CarBookingMain');
$routes->get('CarBooking/View', 'ConUserCarBooking::CarBookingView');
$routes->get('CarBooking/CheckCar', 'ConUserCarBooking::CarBookingCheckCar');
$routes->get('CarBooking/Add/(:any)', 'ConUserCarBooking::CarBookingAdd/$1');
$routes->get('CarBooking/Edit/(:any)', 'ConUserCarBooking::CarBookingEdit/$1');
$routes->post('CarBooking/Update', 'ConUserCarBooking::CarBookingUpdate');
$routes->match(['GET', 'POST'],'Booking/DB/ShowTimeCarBooking', 'ConUserCarBooking::ShowTimeCarBooking');
$routes->match(['GET', 'POST'],'CarBooking/DB/DataTable/View', 'ConUserCarBooking::CarBookingDataTableView');
$routes->match(['GET', 'POST'],'Booking/DB/CheckDateCarBooking', 'ConUserCarBooking::CheckDateCarBooking');
$routes->match(['GET', 'POST'],'CarBooking/DB/Insert', 'ConUserCarBooking::CarBookingInsert');
$routes->get('CarBooking/Approve/Admin', 'ConUserCarBooking::CarBookingViewApproveAdmin');
$routes->match(['GET', 'POST'],'CarBooking/DB/DataTable/Approve/Admin', 'ConUserCarBooking::CarBookingDataTableApproveAdmin');
$routes->match(['GET', 'POST'],'CarBooking/DB/AppoveCarReservationAdmin', 'ConUserCarBooking::CarBookingApproveAdmin');
$routes->match(['GET', 'POST'],'CarBooking/DB/NoAppoveCarReservationAdmin', 'ConUserCarBooking::CarBookingNoApproveAdmin');
$routes->match(['GET', 'POST'],'CarBooking/DB/ResetAppoveCarReservationAdmin', 'ConUserCarBooking::CarBookingResetStatus');
$routes->match(['GET', 'POST'],'CarBooking/Cancel', 'ConUserCarBooking::CarBookingCancel');

$routes->get('CarBooking/Approve/Admin/Print/(:any)', 'ConUserCarBooking::PrintApproveCarBooking/$1');
$routes->match(['GET', 'POST'],'Booking/DB/BookingCarChart', 'ConUserCarBooking::BookingCarChart');

// User แจ้งซ่อม
$routes->get('Repair', 'ConUserRepair::RepairMain');
$routes->get('Repair/Add', 'ConUserRepair::RepairAdd');
$routes->match(['GET', 'POST'],'Repair/DB/CheckPosiUser', 'ConUserRepair::CheckPosiUser');
$routes->match(['GET', 'POST'],'Repair/DB/Insert', 'ConUserRepair::RepairInsert');
$routes->match(['GET', 'POST'],'Repair/DataTable/ShowRepari', 'ConUserRepair::DataTableShowRepari');
$routes->match(['GET', 'POST'],'Repair/DB/CheckRepairFullDetail', 'ConUserRepair::CheckRepairFullDetail');
$routes->match(['GET', 'POST'],'Repair/DB/UpdateWork', 'ConUserRepair::RepairUpdateWork');
$routes->get('Repair/PrintOrder/(:any)', 'ConUserRepair::PrintOrder/$1');
$routes->get('Repair/View/(:any)', 'ConUserRepair::ViewOrder/$1');
$routes->get('Repair/RepairStatistics', 'ConUserRepair::RepairStatistics');
$routes->match(['GET', 'POST'],'Repair/DB/CleanupImages', 'ConUserRepair::CleanupImages');
$routes->match(['GET', 'POST'],'Repair/DB/MigrateImages', 'ConUserRepair::MigrateImages');
$routes->match(['GET', 'POST'],'Repair/DB/StatisticsCaselist', 'ConUserRepair::RepairStatisticsCaselist');
$routes->get('Repair/Api/getRepairList', 'ConUserRepair::getRepairList');
$routes->get('Repair/Api/getRepairDetail/(:any)', 'ConUserRepair::getRepairDetail/$1');
$routes->get('Repair/BuildingMemo', 'ConUserRepair::RepairBuildingMemo');
$routes->match(['GET', 'POST'], 'Repair/BuildingMemo/Print', 'ConUserRepair::RepairBuildingMemoPrint');
$routes->post('Repair/DB/SaveEvaluation', 'ConUserRepair::RepairSaveEvaluation');
$routes->post('Repair/DB/StaffLogin', 'ConUserRepair::StaffLogin');
$routes->post('Repair/DB/StaffLogout', 'ConUserRepair::StaffLogout');



//Admin
$routes->get('Admin/Home', 'ConAdminHome::index');
$routes->get('Admin/LocationRoom/LocationRoomMain', 'ConAdminLocationRoom::LocationRoomMain');

$routes->post('Admin/LocationRoom/Insert', 'ConAdminLocationRoom::LocationRoomInsert');
$routes->match(['GET', 'POST'],'Admin/LocationRoom/Delete', 'ConAdminLocationRoom::LocationRoomDelete');
$routes->match(['GET', 'POST'],'Admin/LocationRoom/ShowData', 'ConAdminLocationRoom::LocationRoomShowData');

$routes->get('Admin/Rloes/Setting', 'ConAdminRoles::index');
$routes->post('Admin/Rloes/SaveUserRoles', 'ConAdminRoles::SaveUserRoles');
$routes->match(['GET', 'POST'],'Admin/Rloes/RloesSettingManager', 'ConAdminRoles::RloesSettingManager');
$routes->post('Admin/Rloes/AddRole', 'ConAdminRoles::AddRole');
$routes->post('Admin/Rloes/DeleteRole', 'ConAdminRoles::DeleteRole');
$routes->match(['GET', 'POST'],'Admin/Rloes/AddDepartment', 'ConAdminRoles::AddDepartment');

//Admin Person
$routes->get('Admin/WorkPerson/Personnel', 'ConAdminWorkPerson::index');
$routes->get('Admin/WorkPerson/Personnel/Add', 'ConAdminWorkPerson::FormAdd');
$routes->get('Admin/WorkPerson/Personnel/Group/(:any)', 'ConAdminWorkPerson::PersonneViewGroup/$1');
$routes->get('Admin/WorkPerson/Personnel/Update/(:any)', 'ConAdminWorkPerson::FormPersonneUpdate/$1');
$routes->match(['GET', 'POST'],'Admin/WorkPerson/Personnel/DB/SortableTeacher', 'ConAdminWorkPerson::SortableTeacher');
$routes->match(['GET', 'POST'],'Admin/WorkPerson/Personnel/DB/Insert', 'ConAdminWorkPerson::PersonnelInsert');
$routes->match(['GET', 'POST'],'Admin/WorkPerson/Personnel/DB/Update/DataGeneral', 'ConAdminWorkPerson::PersonneUpdateDataGeneral');
$routes->match(['GET', 'POST'],'Admin/WorkPerson/Personnel/DB/Update/Img', 'ConAdminWorkPerson::PersonnelUpdateImg');

//Admin งานจองยานพาหนะ
$routes->get('Admin/Car/CarMain', 'ConAdminCar::CarMain');
$routes->get('Admin/Car/CarDriver', 'ConAdminCar::CarDriver');
$routes->match(['GET', 'POST'],'Admin/Car/ShowData', 'ConAdminCar::CarShowData');
$routes->match(['GET', 'POST'],'Admin/Car/Insert', 'ConAdminCar::CarInsert');
$routes->match(['GET', 'POST'],'Admin/Car/Update', 'ConAdminCar::CarUpdate');
$routes->match(['GET', 'POST'],'Admin/Car/Delete', 'ConAdminCar::CarDelete');
$routes->match(['GET', 'POST'],'Admin/CarDriver/ShowData', 'ConAdminCar::CarDriverShowData');
$routes->match(['GET', 'POST'],'Admin/CarDriver/Insert', 'ConAdminCar::CarDriverInsert');
$routes->match(['GET', 'POST'],'Admin/CarDriver/Delete', 'ConAdminCar::CarDriverDelete');


// User Food Report
$routes->get('FoodReport', 'ConUserFoodReport::index');
$routes->get('FoodReport/getFoodReportsJson', 'ConUserFoodReport::getFoodReportsJson');
$routes->get('FoodReport/print/(:num)', 'ConUserFoodReport::print/$1');
$routes->get('FoodReport/word/(:num)', 'ConUserFoodReport::exportWord/$1');
$routes->get('FoodReport/getReportById/(:num)', 'ConUserFoodReport::getReportById/$1');
$routes->post('FoodReport/insert', 'ConUserFoodReport::foodReportInsert');
$routes->post('FoodReport/update', 'ConUserFoodReport::foodReportUpdate');
$routes->post('FoodReport/delete', 'ConUserFoodReport::foodReportDelete');



$routes->get('check-vendor', 'ConUserFoodReport::checkVendor');

// User ยืม-คืนพัสดุอุปกรณ์ (รวมหน้ารายการอนุมัติและจัดการสต็อกในหน้าบ้าน)
$routes->get('Equipment', 'ConUserEquipment::index');
$routes->get('Equipment/Add', 'ConUserEquipment::add');
$routes->get('Equipment/History', 'ConUserEquipment::history');
$routes->get('Equipment/Detail/(:num)', 'ConUserEquipment::detail/$1');
$routes->get('Equipment/Print/(:num)', 'ConUserEquipment::printOrder/$1');
$routes->get('Equipment/Approve', 'ConUserEquipment::approveList');
$routes->get('Equipment/Manage', 'ConUserEquipment::manageStock');
$routes->get('Equipment/StaffDetail/(:num)', 'ConUserEquipment::staffDetail/$1');
$routes->post('Equipment/insert', 'ConUserEquipment::insertBorrow');
$routes->post('Equipment/cancel', 'ConUserEquipment::cancelBorrow');
$routes->match(['GET', 'POST'], 'Equipment/cleanupOrphanImages', 'ConUserEquipment::cleanupOrphanImages');
$routes->get('Equipment/getAvailableItems', 'ConUserEquipment::getAvailableItems');
$routes->get('Equipment/getBorrowHistoryJson', 'ConUserEquipment::getBorrowHistoryJson');

// Admin งานพัสดุและอุปกรณ์
$routes->get('Admin/Equipment/Approve', 'ConAdminEquipment::approveList');
$routes->get('Admin/Equipment/Manage', 'ConAdminEquipment::manageStock');
$routes->get('Admin/Equipment/Detail/(:num)', 'ConAdminEquipment::detail/$1');
$routes->get('Admin/Equipment/getBorrowListJson', 'ConAdminEquipment::getBorrowListJson');
$routes->get('Admin/Equipment/getStockJson', 'ConAdminEquipment::getStockJson');
$routes->post('Admin/Equipment/approveBorrow', 'ConAdminEquipment::approveBorrow');
$routes->post('Admin/Equipment/rejectBorrow', 'ConAdminEquipment::rejectBorrow');
$routes->post('Admin/Equipment/savePickup', 'ConAdminEquipment::savePickup');
$routes->post('Admin/Equipment/saveReturn', 'ConAdminEquipment::saveReturn');
$routes->post('Admin/Equipment/deleteBorrow', 'ConAdminEquipment::deleteBorrow');
$routes->post('Equipment/deleteBorrow', 'ConAdminEquipment::deleteBorrow');
$routes->post('Admin/Equipment/insertEquipment', 'ConAdminEquipment::insertEquipment');
$routes->post('Admin/Equipment/updateEquipment', 'ConAdminEquipment::updateEquipment');
$routes->post('Admin/Equipment/deleteEquipment', 'ConAdminEquipment::deleteEquipment');
$routes->post('Admin/Equipment/saveCategory', 'ConAdminEquipment::saveCategory');
$routes->post('Admin/Equipment/deleteCategory', 'ConAdminEquipment::deleteCategory');
$routes->match(['GET', 'POST'], 'Admin/Equipment/cleanupOrphanImages', 'ConAdminEquipment::cleanupOrphanImages');
$routes->match(['GET', 'POST'], 'Equipment/cleanupOrphanImages', 'ConAdminEquipment::cleanupOrphanImages');

$routes->get('Admin/Notifications/getPending', 'ConAdminNotification::getPendingNotifications');

$routes->post('Webhook', 'Webhook::index');

// New Google Auth Flow
$routes->get('LoginOfficerGeneral', 'Auth::login'); // รองรับลิงก์เดิม
$routes->get('LogoutOfficerGeneral', 'Auth::logout'); // รองรับปุ่ม Logout เดิม
$routes->get('Auth/login', 'Auth::login');
$routes->get('Auth/googleLogin', 'Auth::googleLogin');
$routes->post('Auth/ajaxGoogleLogin', 'Auth::ajaxGoogleLogin'); // รองรับระบบ Login ใหม่แบบ AJAX
$routes->get('Auth/logout', 'Auth::logout');
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
