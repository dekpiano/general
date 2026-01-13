<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ConUserManual extends BaseController
{
    public function index()
    {
        // Manual Hub Page - shows all available manuals
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['uri'] = service('uri');
        $data['title'] = "คู่มือการใช้งานระบบ";
        $data['description'] = "ศูนย์รวมคู่มือการใช้งานระบบทั้งหมด";
        $data['UrlMenuMain'] = 'Manual';
        $data['UrlMenuSub'] = '';

        return view('User/UserManual/ManualIndex', $data);
    }

    public function bookingSystemManual()
    {
        // Data for the view
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['uri'] = service('uri');
        $data['title'] = "คู่มือการใช้งานระบบจองสถานที่";
        $data['description'] = "ขั้นตอนและวิธีการใช้งานระบบจองห้องประชุมและสถานที่ต่างๆ";
        $data['UrlMenuMain'] = 'ManualBooking'; // To set the active state in the menu
        $data['UrlMenuSub'] = '';

        // Load the view for the booking system manual
        return view('User/UserManual/BookingManual', $data);
    }

    public function carBookingSystemManual()
    {
        // Data for the view
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['uri'] = service('uri');
        $data['title'] = "คู่มือการใช้งานระบบจองยานพาหนะ";
        $data['description'] = "ขั้นตอนและวิธีการใช้งานระบบจองยานพาหนะ";
        $data['UrlMenuMain'] = 'ManualCarBooking'; // To set the active state in the menu
        $data['UrlMenuSub'] = '';

        // Load the view for the car booking system manual
        return view('User/UserManual/CarBookingManual', $data);
    }

    public function repairSystemManual()
    {
        // Data for the view
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['uri'] = service('uri');
        $data['title'] = "คู่มือการใช้งานระบบแจ้งซ่อมออนไลน์";
        $data['description'] = "ขั้นตอนและวิธีการใช้งานระบบแจ้งซ่อมออนไลน์";
        $data['UrlMenuMain'] = 'ManualRepair'; // To set the active state in the menu
        $data['UrlMenuSub'] = '';

        // Load the view for the repair system manual
        return view('User/UserManual/RepairManual', $data);
    }

    public function foodReportManual()
    {
        // Data for the view
        $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data['uri'] = service('uri');
        $data['title'] = "คู่มือการใช้งานระบบรายงานอาหาร";
        $data['description'] = "ขั้นตอนและวิธีการใช้งานระบบรายงานอาหารโรงเรียน";
        $data['UrlMenuMain'] = 'ManualFoodReport';
        $data['UrlMenuSub'] = '';

        // Load the view for the food report manual
        return view('User/UserManual/FoodReportManual', $data);
    }
}
