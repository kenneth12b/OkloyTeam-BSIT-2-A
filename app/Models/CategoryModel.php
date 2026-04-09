<?php

namespace App\Models;
use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';           // ✅ Your table name
    protected $primaryKey = 'category_id';     // ✅ Same pattern

    protected $allowedFields = ['category_name', 'description'];  // ✅ Same pattern

    public function getRecords($start, $length, $searchValue = '')
    {
        $builder = $this->builder();

        if ($searchValue) {
            $builder->like('category_name', $searchValue);  // ✅ Same pattern
        }

        $filtered = $builder->countAllResults(false);

        $builder->limit($length, $start);
        $data = $builder->get()->getResultArray();

        return ['data' => $data, 'filtered' => $filtered];
    }
}