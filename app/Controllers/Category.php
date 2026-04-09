<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CategoryModel;
use App\Models\LogModel;

class Category extends Controller
{
    public function index(){
        return view('product/index');  // Use your WORKING products view temporarily
    }

    public function save(){
        $model = new CategoryModel();
        $logModel = new LogModel();

        $data = [
            'category_name' => $this->request->getPost('category_name'),  // ✅ Same pattern
            'description'   => $this->request->getPost('description'),
        ];

        if ($model->insert($data)) {
            $logModel->addLog('Category added: ' . $data['category_name'], 'ADD');
            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error']);
    }

    public function update(){
        $model = new CategoryModel();

        $id = $this->request->getPost('id');

        $data = [
            'category_name' => $this->request->getPost('category_name'),
            'description'   => $this->request->getPost('description'),
        ];

        $model->update($id, $data);

        return $this->response->setJSON(['success' => true]);
    }

    public function edit($id){
        $model = new CategoryModel();
        return $this->response->setJSON(['data' => $model->find($id)]);
    }

    public function delete($id){
        $model = new CategoryModel();
        $model->delete($id);
        return $this->response->setJSON(['success' => true]);
    }

    public function fetchRecords(){
        $model = new CategoryModel();

        $start = $this->request->getPost('start');
        $length = $this->request->getPost('length');
        $search = $this->request->getPost('search')['value'];

        $result = $model->getRecords($start, $length, $search);

        $start = $this->request->getPost('start');
        $data = [];
        $no = $start + 1;

        foreach ($result['data'] as $row) {
            $row['row_number'] = $no++;
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