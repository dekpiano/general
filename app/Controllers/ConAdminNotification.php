<?php

namespace App\Controllers;

use App\Libraries\Datethai;

class ConAdminNotification extends BaseController
{
    public function getPendingNotifications()
    {
        try {
            $session = session();
            if (!$session->get('username')) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'ยังไม่ได้เข้าสู่ระบบ']);
            }

            $database = \Config\Database::connect();
            $datethai = new Datethai();
            
            $userRoles = $session->get('rloes') ?: '';
            $userStatus = $session->get('status') ?: '';
            $targetSystem = $this->request->getVar('system'); // 'car', 'room', 'repair'
            
            // Check for Supervisory/Admin roles (See everything)
            $isSuperAdmin = ($userStatus === 'admin' || $userStatus === 'ExecutiveGeneral' || $userStatus === 'AdminGeneral' || 
                             strpos($userRoles, 'หัวหน้าบริหารทั่วไป') !== false || 
                             strpos($userRoles, 'รองผู้อำนวยการบริหารทั่วไป') !== false || 
                             strpos($userRoles, 'ผู้อำนวยการโรงเรียน') !== false);

            $data = [
                'car' => [],
                'room' => [],
                'repair' => []
            ];
            $totalCount = 0;

            // 1. Car Bookings
            if (($isSuperAdmin || strpos($userRoles, 'งานยานพาหนะ') !== false) && (!$targetSystem || $targetSystem === 'car')) {
                $carBookings = $database->table('tb_car_reservation')
                    ->select('MAX(car_reserv_id) as car_reserv_id, car_reserv_order, MAX(car_reserv_location) as car_reserv_location, MAX(car_reserv_StartDate) as car_reserv_StartDate, MAX(car_reserv_StartTime) as car_reserv_StartTime')
                    ->whereNotIn('car_reserv_status', ['อนุมัติ', 'ไม่อนุมัติ', 'ยกเลิก'])
                    ->groupBy('car_reserv_order')
                    ->orderBy('car_reserv_id', 'DESC')
                    ->limit(5)
                    ->get()->getResult();
                
                foreach ($carBookings as $cb) {
                    $timeStr = '';
                    if ($cb->car_reserv_StartDate && $cb->car_reserv_StartDate != '0000-00-00') {
                        $timestamp = strtotime($cb->car_reserv_StartDate);
                        $timeStr = ($timestamp) ? $datethai->thai_date_fullmonth($timestamp) . ' ' . $cb->car_reserv_StartTime : $cb->car_reserv_StartDate;
                    }

                    $data['car'][] = [
                        'id' => $cb->car_reserv_id,
                        'title' => ($cb->car_reserv_location ?: 'ไม่ระบุ'),
                        'time' => $timeStr,
                        'link' => base_url('CarBooking/Approve/Admin'),
                        'icon' => 'bi-truck',
                        'color' => 'bg-warning'
                    ];
                }
                $carCount = $database->table('tb_car_reservation')
                    ->whereNotIn('car_reserv_status', ['อนุมัติ', 'ไม่อนุมัติ', 'ยกเลิก'])
                    ->select('COUNT(DISTINCT car_reserv_order) as total')
                    ->get()->getRow()->total;
                $totalCount += (int)$carCount;
            }

            // 2. Room Bookings
            if (($isSuperAdmin || strpos($userRoles, 'งานอาคารสถานที่') !== false) && (!$targetSystem || $targetSystem === 'room')) {
                $roomBookings = $database->table('tb_booking')
                    ->select('MAX(booking_id) as booking_id, booking_order, MAX(booking_title) as booking_title, MAX(booking_dateStart) as booking_dateStart, MAX(booking_timeStart) as booking_timeStart')
                    ->whereNotIn('booking_admin_approve', ['อนุมัติ', 'ไม่อนุมัติ', 'ยกเลิก'])
                    ->groupBy('booking_order')
                    ->orderBy('booking_id', 'DESC')
                    ->limit(5)
                    ->get()->getResult();

                foreach ($roomBookings as $rb) {
                    $timeStr = '';
                    if ($rb->booking_dateStart && $rb->booking_dateStart != '0000-00-00') {
                        $timestamp = strtotime($rb->booking_dateStart);
                        $timeStr = ($timestamp) ? $datethai->thai_date_fullmonth($timestamp) . ' ' . $rb->booking_timeStart : $rb->booking_dateStart;
                    }

                    $data['room'][] = [
                        'id' => $rb->booking_id,
                        'title' => ($rb->booking_title ?: 'ไม่ระบุ'),
                        'time' => $timeStr,
                        'link' => base_url('Booking/Approve/Admin'),
                        'icon' => 'bi-building',
                        'color' => 'bg-info'
                    ];
                }
                $roomCount = $database->table('tb_booking')
                    ->whereNotIn('booking_admin_approve', ['อนุมัติ', 'ไม่อนุมัติ', 'ยกเลิก'])
                    ->select('COUNT(DISTINCT booking_order) as total')
                    ->get()->getRow()->total;
                $totalCount += (int)$roomCount;
            }

            // 3. Repair Requests
            if (($isSuperAdmin || strpos($userRoles, 'งานแจ้งซ่อม') !== false) && (!$targetSystem || $targetSystem === 'repair')) {
                $repairs = $database->table('tb_repair')
                    ->select('MAX(repair_ID) as repair_ID, repair_order, MAX(repair_caselist) as repair_caselist, MAX(repair_datetime) as repair_datetime')
                    ->where('repair_status', 'รอดำเนินการ')
                    ->groupBy('repair_order')
                    ->orderBy('repair_ID', 'DESC')
                    ->limit(5)
                    ->get()->getResult();

                foreach ($repairs as $rp) {
                    $timeStr = '';
                    if ($rp->repair_datetime && $rp->repair_datetime != '0000-00-00 00:00:00') {
                        $timestamp = strtotime($rp->repair_datetime);
                        $timeStr = ($timestamp) ? $datethai->thai_date_and_time_short($timestamp) : $rp->repair_datetime;
                    }

                    $data['repair'][] = [
                        'id' => $rp->repair_ID,
                        'title' => ($rp->repair_caselist ?: 'ไม่ระบุ'),
                        'time' => $timeStr,
                        'link' => base_url('Repair/View/' . $rp->repair_order),
                        'icon' => 'bi-tools',
                        'color' => 'bg-danger'
                    ];
                }
                $repairCount = $database->table('tb_repair')
                    ->where('repair_status', 'รอดำเนินการ')
                    ->select('COUNT(DISTINCT repair_order) as total')
                    ->get()->getRow()->total;
                $totalCount += (int)$repairCount;
            }

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $data,
                'totalCount' => $totalCount
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
