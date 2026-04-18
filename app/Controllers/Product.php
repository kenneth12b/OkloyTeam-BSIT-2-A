<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;

class Product extends Controller
{
    public function index()
    {
        return view('product/index');
    }

    public function getAll()
    {
        $model = new ProductModel();
        return $this->response->setJSON([
            'data' => $model->orderBy('product_id','DESC')->findAll()
        ]);
    }

    public function save()
    {
        $model = new ProductModel();

        $model->insert($this->request->getPost());

        return $this->response->setJSON(['status'=>'success']);
    }

    public function edit($id)
    {
        return $this->response->setJSON([
            'data' => (new ProductModel())->find($id)
        ]);
    }

    public function update()
    {
        $model = new ProductModel();

        $model->save($this->request->getPost());

        return $this->response->setJSON(['status'=>'success']);
    }

    public function delete($id)
    {
        (new ProductModel())->delete($id);

        return $this->response->setJSON(['status'=>'success']);
    }
}