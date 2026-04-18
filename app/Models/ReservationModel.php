<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table = 'reservations';
    protected $primaryKey = 'reservation_id';

    

    protected $allowedFields = [
    'table_id',
    'customer_name',
    'start_time',
    'end_time',
    'status'
];

    

    protected $useTimestamps = false;
}