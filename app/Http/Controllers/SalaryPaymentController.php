<?php

namespace App\Http\Controllers;

use App\Models\SalaryPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalaryPaymentController extends Controller
{
    public function SalaryPayment(Request $request)
    {
        if ($request->ajax()) {

            $data = SalaryPayment::with('get_salarydetail');

            if ($request->filter_payment_method) {
                $data->where('payment_method', $request->filter_payment_method);
            }

            if ($request->filter_payment_date_from) {
                $fromDate = Carbon::createFromFormat('d-m-Y', $request->filter_payment_date_from)->format('Y-m-d');
                $data->whereDate('payment_date', '>=', $fromDate);
            }

            if ($request->filter_payment_date_to) {
                $toDate = Carbon::createFromFormat('d-m-Y', $request->filter_payment_date_to)->format('Y-m-d');
                $data->whereDate('payment_date', '<=', $toDate);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.salary_payment');
    }

    public function SalaryPaymentPDF(Request $request)
    {
        $salaryPayments = SalaryPayment::with([
            'get_salarydetail',
        ]);

        if ($request->filled('payment_method')) {
            $salaryPayments->where('payment_method', $request->payment_method);
        }

        if ($request->filled('payment_date_from')) {
            $startDate = Carbon::createFromFormat('d-m-Y', $request->payment_date_from)->format('Y-m-d');
            $salaryPayments->whereDate('payment_date', '>=', $startDate);
        }

        if ($request->filled('payment_date_to')) {
            $endDate = Carbon::createFromFormat('d-m-Y', $request->payment_date_to)->format('Y-m-d');
            $salaryPayments->whereDate('payment_date', '<=', $endDate);
        }

        $salaryPayments = $salaryPayments->orderBy('id', 'desc')->get();

        $pdf = Pdf::loadView('admin.salary_payment_pdf',compact('salaryPayments'));
        return $pdf->download('salary-payment-'.date('d-m-Y').'.pdf');
    }
}
