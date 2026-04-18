<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use App\Models\TablesModel;

class Reservation extends BaseController
{
    // =========================
    // 📋 LIST PAGE
    // =========================
    public function index()
    {
        $reservationModel = new ReservationModel();
        $tableModel = new TablesModel();

        $data = [
            'reservations' => $reservationModel->orderBy('reservation_id', 'DESC')->findAll(),
            'tables' => $tableModel->orderBy('table_id', 'ASC')->findAll()
        ];

        return view('reservation/index', $data);
    }

    // =========================
    // ➕ ADD RESERVATION (FIXED)
    // =========================
   public function save()
{
    $model = new \App\Models\ReservationModel();
    $tableModel = new \App\Models\TablesModel();

    $table_id = $this->request->getPost('table_id');
    $name     = $this->request->getPost('customer_name');
    $start    = $this->request->getPost('start_time');
    $end      = $this->request->getPost('end_time');

    if (!$table_id || !$name || !$start || !$end) {
        return redirect()->back()->with('error', 'Missing fields');
    }

    $model->insert([
        'table_id' => $table_id,
        'customer_name' => $name,
        'start_time' => $start,
        'end_time' => $end,
        'status' => 'pending'
    ]);

    // 🔥 IMPORTANT FIX: UPDATE TABLE STATUS
    $tableModel->update($table_id, [
        'status' => 'reserved'
    ]);

    return redirect()->to('/reservation')->with('success', 'Saved');
}
    // =========================
    // ✅ APPROVE RESERVATION
    // =========================
    public function approve($id)
{
    $model = new ReservationModel();

    $model->update($id, [
        'status' => 'approved'
    ]);

    return redirect()->to('/reservation');
}
//EDIT PAGE
    public function edit($id)
{
    $reservationModel = new \App\Models\ReservationModel();
    $tableModel = new \App\Models\TablesModel();

    $data = [
        'reservation' => $reservationModel->find($id),
        'tables' => $tableModel->findAll()
    ];

    return view('reservation/edit', $data);
}


//UPDATE SAVE
public function update($id)
{
    $model = new \App\Models\ReservationModel();

    $model->update($id, [
        'table_id' => $this->request->getPost('table_id'),
        'customer_name' => $this->request->getPost('customer_name'),
        'reserved_at' => $this->request->getPost('reserved_at'),
        'status' => $this->request->getPost('status')
    ]);

    return redirect()->to('/reservation')->with('success', 'Updated successfully');
}


//DELETE
public function delete($id)
{
    $model = new \App\Models\ReservationModel();
    $tableModel = new \App\Models\TablesModel();

    $res = $model->find($id);

    if ($res) {
        // ibalik table status kung i-delete reservation
        $tableModel->update($res['table_id'], [
            'status' => 'available'
        ]);
    }

    $model->delete($id);

    return redirect()->to('/reservation')->with('success', 'Deleted successfully');
}




    // =========================
    // ❌ CANCEL RESERVATION
    // =========================
   public function cancel($id)
{
    $model = new \App\Models\ReservationModel();
    $tableModel = new \App\Models\TablesModel();

    $res = $model->find($id);

    if ($res) {
        // return table status
        $tableModel->update($res['table_id'], [
            'status' => 'available'
        ]);

        $model->update($id, [
            'status' => 'cancelled'
        ]);
    }

    return redirect()->to('/reservation');
}
}