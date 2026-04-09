<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // 🔐 Login check
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $model = new ProductModel();

        // 📊 Summary Cards
        $data['totalProducts'] = $model->countAll();

        $data['totalStock'] = $model
            ->selectSum('quantity')
            ->first()['quantity'] ?? 0;

        // 📉 LOW STOCK LIST (below 10)
        $data['lowStock'] = $model
            ->where('quantity <', 10)
            ->findAll();

        return view('dashboard/index', $data);
    }
}