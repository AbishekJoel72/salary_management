<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';

    protected $fillable = [
        'employee_id', 'attendance_date', 'check_in', 'check_out', 'working_hours', 'day_value', 'status', 'remarks'];

        public function get_employee()
        {
            return $this->belongsTo(Employees::class, 'employee_id','id');
        }
}
