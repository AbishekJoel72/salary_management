<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    protected $table = 'salary_payments';

    protected $fillable = [
        'salary_detail_id',
        'payment_date',
        'amount',
        'payment_method',
        'transaction_reference',
        'remarks',

    ];

    public function get_salarydetail()
    {
        return $this->belongsTo(SalaryDetails::class,'salary_detail_id','id');
    }
}
