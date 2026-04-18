<?php

namespace App\Models;

use CodeIgniter\Model;

class TablesModel extends Model
{
    protected $table = 'tables';
    protected $primaryKey = 'table_id';

    protected $allowedFields = [
        'table_number',
        'status',
        'hourly_rate',
        'start_time',
        'end_time'
    ];

    protected $useTimestamps = false;

    // =========================
    // ✅ GET ALL TABLES (VIEW SAFE)
    // =========================
    public function getAllTables()
    {
        return $this->orderBy('table_id', 'ASC')->findAll();
    }

    // =========================
    // ✅ ADD TABLE (SAFE INSERT)
    // =========================
    public function addTable($table_number, $hourly_rate)
    {
        return $this->insert([
            'table_number' => $table_number,
            'hourly_rate'  => $hourly_rate,
            'status'       => 'available',
            'start_time'   => null,
            'end_time'     => null
        ]);
    }

    // =========================
    // ✅ UPDATE STATUS HELPERS (SAFE)
    // =========================
    public function startTable($id)
    {
        return $this->update($id, [
            'status' => 'occupied',
            'start_time' => date('Y-m-d H:i:s'),
            'end_time' => null
        ]);
    }

    public function endTable($id)
    {
        return $this->update($id, [
            'status' => 'available',
            'end_time' => date('Y-m-d H:i:s')
        ]);
    }

    public function reserveTable($id)
    {
        return $this->update($id, [
            'status' => 'reserved'
        ]);
    }

    public function resetTable($id)
    {
        return $this->update($id, [
            'status' => 'available',
            'start_time' => null,
            'end_time' => null
        ]);
    }

    

    // =========================
    // ✅ DATA TABLES (FIXED VERSION)
    // =========================
    public function getRecords($start, $length, $searchValue = '')
    {
        $builder = $this->builder();

        $builder->select('*');

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('table_number', $searchValue)
                ->orLike('status', $searchValue)
                ->groupEnd();
        }

        $filtered = (clone $builder)->countAllResults();

        $builder->orderBy('table_id', 'ASC');
        $builder->limit($length, $start);

        $data = $builder->get()->getResultArray();

        return [
            'data' => $data,
            'filtered' => $filtered
        ];
    }
}