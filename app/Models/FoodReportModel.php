<?php

namespace App\Models;

use CodeIgniter\Model;

class FoodReportModel extends Model
{
    protected $table            = 'tb_food_reports';
    protected $primaryKey       = 'food_id';
    protected $allowedFields    = ['food_date', 'food_meal', 'food_menu', 'food_images', 'food_admin'];

    // Dates
    protected $useTimestamps = false;

    public function getFoodReport()
    {
        return $this->findAll();
    }

    public function foodReportInsert($data)
    {
        return $this->insert($data);
    }

    public function foodReportUpdate($fr_id, $data)
    {
        return $this->update($fr_id, $data);
    }

    public function foodReportDelete($fr_id)
    {
        return $this->delete($fr_id);
    }
}
