<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employees;
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

            $data = SalaryPayment::with([
                'get_salarydetail',
                'get_salarydetail.get_employee',
                'get_salarydetail.get_employee.get_department',
                'get_salarydetail.get_employee.get_designation',
            ]);

            if ($request->filled('filter_employee')) {
                $data->whereHas('get_salarydetail', function ($query) use ($request) {
                    $query->where('employee_id', $request->filter_employee);
                });
            }

            if ($request->filled('filter_department')) {
                $data->whereHas('get_salarydetail.get_employee', function ($query) use ($request) {
                    $query->where('department_id', $request->filter_department);
                }
                );
            }

            if ($request->filled('filter_designation')) {
                $data->whereHas('get_salarydetail.get_employee', function ($query) use ($request) {
                    $query->where('designation_id', $request->filter_designation);
                }
                );
            }

            if ($request->filled('filter_salary_type')) {
                $data->whereHas('get_salarydetail', function ($query) use ($request) {
                    $query->where('salary_type', $request->filter_salary_type);
                });
            }

            if ($request->filled('filter_status')) {
                $data->whereHas('get_salarydetail', function ($query) use ($request) {
                    $query->where('status', $request->filter_status);
                });
            }

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
                ->addColumn('employee', function ($row) {
                    return $row->get_salarydetail->get_employee->employee_code.' -'.
                    $row->get_salarydetail->get_employee->name;
                })
                ->addColumn('department', function ($row) {
                    return $row->get_salarydetail->get_employee->get_department->code.' -'.
                    $row->get_salarydetail->get_employee->get_department->name;
                })
                ->addColumn('designation', function ($row) {
                    return $row->get_salarydetail->get_employee->get_designation->name;
                })
                ->make(true);
        }

        $this->data['employees'] = Employees::where('status', '1')->get();
        $this->data['departments'] = Department::where('status', '1')->get();
        $this->data['designations'] = Designation::where('status', '1')->get();

        return view('admin.salary_payment')->with($this->data);
    }

    public function SalaryPaymentPDF(Request $request)
    {

        $salaryPayments = SalaryPayment::with([
            'get_salarydetail',
            'get_salarydetail.get_employee',
            'get_salarydetail.get_employee.get_department',
            'get_salarydetail.get_employee.get_designation',
        ]);

        if ($request->filled('filter_employee')) {
            $salaryPayments->whereHas('get_salarydetail', function ($query) use ($request) {
                $query->where('employee_id', $request->filter_employee);
            });
        }

        if ($request->filled('filter_department')) {
            $salaryPayments->whereHas('get_salarydetail.get_employee', function ($query) use ($request) {
                $query->where('department_id', $request->filter_department);
            }
            );
        }

        if ($request->filled('filter_designation')) {
            $salaryPayments->whereHas('get_salarydetail.get_employee', function ($query) use ($request) {
                $query->where('designation_id', $request->filter_designation);
            }
            );
        }

        if ($request->filled('filter_salary_type')) {
            $salaryPayments->whereHas('get_salarydetail', function ($query) use ($request) {
                $query->where('salary_type', $request->filter_salary_type);
            });
        }

        if ($request->filled('filter_status')) {
            $salaryPayments->whereHas('get_salarydetail', function ($query) use ($request) {
                $query->where('status', $request->filter_status);
            });
        }

        if ($request->filter_payment_method) {
            $salaryPayments->where('payment_method', $request->filter_payment_method);
        }

        if ($request->filter_payment_date_from) {
            $fromDate = Carbon::createFromFormat('d-m-Y', $request->filter_payment_date_from)->format('Y-m-d');
            $salaryPayments->whereDate('payment_date', '>=', $fromDate);
        }

        if ($request->filter_payment_date_to) {
            $toDate = Carbon::createFromFormat('d-m-Y', $request->filter_payment_date_to)->format('Y-m-d');
            $salaryPayments->whereDate('payment_date', '<=', $toDate);
        }

        $salaryPayments = $salaryPayments->orderBy('id', 'desc')->get();

        $pdf = Pdf::loadView('admin.salary_payment_pdf', compact('salaryPayments'));

        return $pdf->download('salary-payment-'.date('d-m-Y').'.pdf');
    }
}
