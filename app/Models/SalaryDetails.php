<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryDetails extends Model
{
    use HasFactory;

    protected $table = 'salary_details';

    protected $fillable = [
        'salary_period_id',
        'employee_id',
        'salary_type',
        'base_salary',
        'full_days',
        'half_days',
        'absent_days',
        'worked_days',
        'gross_salary',
        'deduction',
        'adjustment',
        'net_salary',
        'status',
    ];



    public function get_salaryperiod()
    {
        return $this->belongsTo(
            SalaryPeriod::class,
            'salary_period_id'
        );
    }

    public function get_employee()
    {
        return $this->belongsTo(
            Employees::class,
            'employee_id'
        );
    }
}
