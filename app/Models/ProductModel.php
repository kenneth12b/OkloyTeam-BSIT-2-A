<?php

namespace App\Models;
use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $allowedFields = ['product_name', 'quantity', 'price'];

    public function getRecords($start, $length, $searchValue = '')
    {
        $builder = $this->builder();

        if ($searchValue) {
            $builder->like('product_name', $searchValue);
        }

        $filtered = $builder->countAllResults(false);

        $builder->limit($length, $start);
        $data = $builder->get()->getResultArray();

        return ['data' => $data, 'filtered' => $filtered];
    }
}