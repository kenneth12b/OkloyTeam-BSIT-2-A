<?php

namespace App\Controllers;

use App\Models\TablesModel;

class Tables extends BaseController
{
    public function index()
    {
        $model = new TablesModel();

        $data['tables'] = $model->orderBy('table_id', 'ASC')->findAll();

        return view('tables/index', $data);
    }

    // =========================
    // ➕ ADD TABLE (SAFE FORM POST)
    // =========================
    public function save()
    {
        $model = new TablesModel();

        $table_number = $this->request->getPost('table_number');
        $hourly_rate  = $this->request->getPost('hourly_rate');

        if (!$table_number || !$hourly_rate) {
            return redirect()->to('/tables')->with('error', 'Complete all fields');
        }

        $model->insert([
            'table_number' => $table_number,
            'hourly_rate'  => $hourly_rate,
            'status'       => 'available',
            'start_time'   => null,
            'end_time'     => null
        ]);

        return redirect()->to('/tables')->with('success', 'Table added successfully');
    }

    // =========================
    // ▶ START GAME
    // =========================
   public function start($id)
{
    $model = new \App\Models\TablesModel();

    $model->update($id, [
        'status' => 'occupied',
        'start_time' => date('Y-m-d H:i:s'),
        'end_time' => null
    ]);

    return redirect()->to('/tables');
}

    // =========================
    // ⏹ END GAME
    // =========================
    public function end($id)
{
    $model = new \App\Models\TablesModel();

    $table = $model->find($id);

    if (!$table || empty($table['start_time'])) {
        return redirect()->to('/tables');
    }

    $endTime = date('Y-m-d H:i:s');

    $start = strtotime($table['start_time']);
    $end = strtotime($endTime);

    $hours = ($end - $start) / 3600;
    $total = $hours * $table['hourly_rate'];

    // 🔥 IMPORTANT FIX HERE
    $model->update($id, [
        'status' => 'available',
        // ❌ DO NOT DELETE start_time
        'end_time' => $endTime
    ]);

    return redirect()->to('/tables')->with('success', 'Total: ₱' . round($total, 2));
}

    // =========================
    // ⭐ RESERVE
    // =========================
    public function reserve($id)
    {
        $model = new TablesModel();

        $model->update($id, [
            'status' => 'reserved'
        ]);

        return redirect()->to('/tables');
    }

    // =========================
    // 🔄 RESET
    // =========================
    public function reset($id)
    {
        $model = new TablesModel();

        $model->update($id, [
            'status' => 'available',
            'start_time' => null,
            'end_time' => null
        ]);

        return redirect()->to('/tables');
    }
}