<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'department_id',
        'designation_id',
        'employee_code',
        'name',
        'email',
        'phone',
        'employee_type',
        'daily_rate',
        'monthly_salary',
        'joining_date',
    ];

    public function get_department()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }
    public function get_designation()
    {
        return $this->belongsTo(Designation::class,'designation_id','id');
    }
}
