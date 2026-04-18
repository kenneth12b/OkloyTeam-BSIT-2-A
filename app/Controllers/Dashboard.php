<?php

namespace App\Controllers;

use App\Models\ProductModel;
use Config\Database;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $productModel = new ProductModel();

        $data['totalProducts'] = $productModel->countAll();

        $data['totalStock'] = $productModel
            ->selectSum('quantity')
            ->first()['quantity'] ?? 0;

        $data['lowStock'] = $productModel
            ->where('quantity <', 10)
            ->findAll();

        // 🔥 SINGLE QUERY FIX
        $db = Database::connect();

        $row = $db->query("
            SELECT 
                SUM(CASE WHEN status = 'occupied' THEN 1 ELSE 0 END) AS activeTables,
                SUM(CASE WHEN status = 'reserved' THEN 1 ELSE 0 END) AS reservedTables,
                SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) AS availableTables,
                SUM(
                    CASE 
                        WHEN end_time IS NOT NULL 
                        AND start_time IS NOT NULL 
                        AND hourly_rate IS NOT NULL
                        THEN ((TIMESTAMPDIFF(SECOND, start_time, end_time) / 3600) * hourly_rate)
                        ELSE 0 
                    END
                ) AS totalSales
            FROM tables
        ")->getRowArray();

        $data['activeTables']    = $row['activeTables'] ?? 0;
        $data['reservedTables']  = $row['reservedTables'] ?? 0;
        $data['availableTables'] = $row['availableTables'] ?? 0;
        $data['totalSales']      = $row['totalSales'] ?? 0;

        $data['tables'] = (new \App\Models\TablesModel())
            ->orderBy('table_id', 'ASC')
            ->findAll();

        return view('dashboard/index', $data);
    }
}