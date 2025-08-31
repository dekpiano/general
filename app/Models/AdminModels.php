<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModels extends Model
{
    public function countAllLocationRoom()
    {
        $builder = $this->db->table('tb_location');
        return $builder->countAll();
    }

    public function countAllCar()
    {
        $builder = $this->db->table('tb_school_car');
        return $builder->countAll();
    }

    public function countAllDriver()
    {
        $builder = $this->db->table('tb_car_driver');
        return $builder->countAll();
    }
}
