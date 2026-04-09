<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;
use App\Models\LogModel;

class Product extends Controller
{
    public function index(){
        return view('product/index');
    }

    public function save(){
        $model = new ProductModel();
        $logModel = new LogModel();

        $data = [
            'product_name' => $this->request->getPost('product_name'),
            'quantity'     => $this->request->getPost('quantity'),
            'price'        => $this->request->getPost('price'),
        ];

        if ($model->insert($data)) {
            $logModel->addLog('Product added: ' . $data['product_name'], 'ADD');
            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error']);
    }

    public function update(){
        $model = new ProductModel();

        $id = $this->request->getPost('id');

        $data = [
            'product_name' => $this->request->getPost('product_name'),
            'quantity'     => $this->request->getPost('quantity'),
            'price'        => $this->request->getPost('price'),
        ];

        $model->update($id, $data);

        return $this->response->setJSON(['success' => true]);
    }

    public function edit($id){
        $model = new ProductModel();
        return $this->response->setJSON(['data' => $model->find($id)]);
    }

    public function delete($id){
        $model = new ProductModel();
        $model->delete($id);
        return $this->response->setJSON(['success' => true]);
    }

    public function fetchRecords(){
        $model = new ProductModel();

        $start = $this->request->getPost('start');
        $length = $this->request->getPost('length');
        $search = $this->request->getPost('search')['value'];

        $result = $model->getRecords($start, $length, $search);

        $start = $this->request->getPost('start');
$data = [];
$no = $start + 1;

foreach ($result['data'] as $row) {
    $row['row_number'] = $no++; // ✅ ADD THIS
    $data[] = $row;
}

return $this->response->setJSON([
    'draw' => intval($this->request->getPost('draw')),
    'recordsTotal' => $model->countAll(),
    'recordsFiltered' => $result['filtered'],
    'data' => $data,
]);
    }
}