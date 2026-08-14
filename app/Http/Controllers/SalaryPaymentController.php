<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalaryPaymentController extends Controller
{
    public function SalaryPayment(Request $request){
        return view("admin.salary_payment");
    }
}
