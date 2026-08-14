<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryPeriod extends Model
{
    protected $table = "salary_periods";
    protected $fillable = [
        "period_type",
        "start_date",
        "end_date",
        "status",
        "calculated_at",
        "approved_at",
        "paid_at",
    ] ;

     public function get_salarydetails()
    {
        return $this->hasMany(SalaryDetails::class);
    }
}
