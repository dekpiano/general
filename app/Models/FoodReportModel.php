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

    public function getFoodReportsWithRecorderDetails($year = null)
    {
        $builder = $this->select('tb_food_reports.*, CONCAT(p.pers_prefix,p.pers_firstname, " ", p.pers_lastname) as recorder_full_name')
                    ->join('skjacth_personnel.tb_personnel as p', 'p.pers_id = tb_food_reports.food_admin', 'left');
        
        if ($year) {
            $builder->where('YEAR(tb_food_reports.food_date)', $year);
        }
                    
        return $builder->orderBy('tb_food_reports.food_date', 'DESC')
                    ->orderBy('tb_food_reports.food_id', 'DESC')
                    ->findAll();
    }
}
