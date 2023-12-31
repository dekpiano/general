<?php

namespace App\Controllers;

class ConUserBooking extends BaseController
{

    function __construct(){
        
    }

    public function DataMain(){
       $data['full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       $data['uri'] = service('uri'); 
       
        return $data;
    }

    public function BookingMain()
    {
        $session = session();
        $data = $this->DataMain();
        $data['title']="จองห้อง / สถานที่";
        $data['description']="ระบบสำหรับจองห้อง / สถานที่ ภายในโรงเรียน";
        $data['UrlMenuMain'] = 'Booking';
        $data['UrlMenuSub'] = 'BookingMain';

        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $data['CountLocationRoomAll'] = $builder->countAll();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserBooking/UserBookingMain')
                .view('User/UserLeyout/UserFooter');
    }
    
    public function BookingSelect()
    {
        $data = $this->DataMain();
        $data['title']="เลือกห้อง / สถานที่";
        $data['description']="เลือกห้องสำหรับใช้ภายในโรงเรียน";
        $data['UrlMenuMain'] = 'Booking';
        $data['UrlMenuSub'] = 'BookingSelect';
        $session = session();
      

        $database = \Config\Database::connect();
        $builder = $database->table('tb_location');
        $data['LocationRoomAll'] = $builder->get()->getResult();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserBooking/UserBookingSelect')
                .view('User/UserLeyout/UserFooter');
    }

    public function BookingAdd($LocationID = null)
    {
        $session = session();
        $data = $this->DataMain();
        $data['title']="จองห้อง / สถานที่";
        $data['description']="จองห้องสำหรับใช้ภายในโรงเรียน";
        $data['UrlMenuMain'] = 'Booking';
        $data['UrlMenuSub'] = 'BookingAdd';        

        $database = \Config\Database::connect();
        $DBlocation = $database->table('tb_location');

        $data['loca'] = $DBlocation->where('location_ID',$LocationID)->get()->getRow();
        //print_r($data['loca']->location_detail); exit();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserBooking/UserBookingAdd')
                .view('User/UserLeyout/UserFooter');
    }

    public function BookingInsert(){

        $session = session();
        $database = \Config\Database::connect();
        $DBlocation = $database->table('tb_booking');
        
        if($this->request->getVar('booking_equipment') != ""){
          $equipment = implode('|',$this->request->getVar('booking_equipment'));
        }else{
            $equipment = "";
        }
        $data = [
            'booking_locationroom' => $this->request->getVar('booking_locationroom'),
            'booking_number' => $this->request->getVar('booking_number'),
            'booking_title' => $this->request->getVar('booking_title'),
            'booking_dateStart' => $this->request->getVar('booking_dateStart'),
            'booking_timeStart' => $this->request->getVar('booking_timeStart'),
            'booking_dateEnd' => $this->request->getVar('booking_dateEnd'),
            'booking_timeEnd' => $this->request->getVar('booking_timeEnd'),
            'booking_typeuse' => $this->request->getVar('booking_typeuse'),
            'booking_other' => $this->request->getVar('booking_other'),
            'booking_Booker' => $this->request->getVar('booking_Booker'),
            'booking_telephone' => $this->request->getVar('booking_telephone'),
            'booking_equipment' => $equipment,
            'booking_status' => "รอตรวจสอบ" 
        ];
        
        $DBlocation->insert($data);
        echo $this->request->getVar('booking_locationroom');
        //print_r($this->request->getVar());
    }

    public function BookingView($Key){

        $session = session();
        $data = $this->DataMain();
        $data['title']="ดูข้อมูลจองห้องประชุมและสถานที่";
        $data['description']="ดูข้อมูลจองห้องประชุมและสถานที่";
        $data['UrlMenuMain'] = 'Booking';
        $data['UrlMenuSub'] = 'BookingView';        

        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $data['Booking'] = $DBbooking
        ->select('booking_title,booking_locationroom,booking_Booker,booking_status,booking_reason,booking_id,location_name,booking_dateStart,booking_timeStart,booking_dateEnd,booking_timeEnd,booking_typeuse')
        ->join('tb_location','tb_booking.booking_locationroom = tb_location.location_ID')
        ->where('booking_locationroom',$Key)
        ->where('booking_Booker',$_SESSION['id'])
        ->get()->getResult();
        //echo '<pre>';print_r($data['loca']); exit();
        
        return view('User/UserLeyout/UserHeader',$data)
                .view('User/UserLeyout/UserMenuLeft')
                .view('User/UserBooking/UserBookingView')
                .view('User/UserLeyout/UserFooter');
    }

    public function BookingCancel(){
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

        $data = [
            'booking_status' => 'ยกเลิกโดยผู้จอง'
        ];        
        $DBbooking->where('booking_id', $this->request->getVar('KeyID'));
        echo $DBbooking->update($data);

        
    }

    public function ShowTimeBooking(){
        $session = session();
        $database = \Config\Database::connect();
        $DBbooking = $database->table('tb_booking');

       $S_data = $DBbooking->select('booking_title,booking_dateStart,booking_dateEnd')->get()->getResult();

        foreach ($S_data as $key => $value) {
            $data=[
                'title'=> $value->booking_title,
                'start' => $value->booking_dateStart,
                'end' => $value->booking_dateEnd
            ];        
        }

        return json_encode($data);
    }


    public function DictationInsert()
    {  
        helper(['form', 'url']);
         
        $database = \Config\Database::connect();
        $builder = $database->table('tb_dictation');
        $validateImage = $this->validate([
            'file' => [
                'uploaded[dicta_file]',
                'max_size[dicta_file, 10000]',
            ],
        ]);
    
        $response = [
            'success' => false,
            'data' => '',
            'msg' => "อัพโหลดไฟล์ไม่ถูกต้อง"
        ];
        if ($validateImage) {
            $imageFile = $this->request->getFile('dicta_file');
            $type = $imageFile->getMimeType();
            $newName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'uploads/User/dictation/',$newName);
            $data = [
                'dicta_year' => $this->request->getPost('dicta_year'),
                'dicta_number' => $this->request->getPost('dicta_number'),
                'dicta_createdate' => $this->request->getPost('dicta_createdate'),
                'dicta_title' => $this->request->getPost('dicta_title'),
                'dicta_file'  => $newName
            ];
            $save = $builder->insert($data);
            $response = [
                'success' => true,
                'data' => $save,
                'msg' => "บันทึกข้อมูลเรียบร้อย"
            ];
        }
        return $this->response->setJSON($response);
    }

    public function DictationShowData(){
      
        $database = \Config\Database::connect();
        $builder = $database->table('tb_dictation');

        $DictationRecords = $builder->get()->getResult();
        $data = array();
        foreach ($DictationRecords as $row) {
            $data[] = array(
               "dicta_year"=>$row->dicta_year,
               "dicta_number"=>$row->dicta_number,
               "dicta_createdate"=>$row->dicta_createdate,
               "dicta_title"=>$row->dicta_title,
               "dicta_file"=>$row->dicta_file
            );
         }

         $response = array(           
            "aaData" => $data
         );
         echo json_encode($response);
       // echo '<pre>'; print_r($data);

    }
}
