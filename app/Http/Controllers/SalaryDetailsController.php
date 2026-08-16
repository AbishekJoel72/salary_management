<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\SalaryDetails;
use App\Models\SalaryPeriod;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalaryDetailsController extends Controller
{
    public function SalaryDetails(Request $request)
    {
        if ($request->ajax()) {

            $salaryDetails = SalaryDetails::with(['get_salaryperiod', 'get_employee'])->select('salary_details.*');

            if ($request->filled('salary_period_id')) {
                $salaryDetails->where('salary_period_id', $request->salary_period_id);
            }

            if ($request->filled('employee_id')) {
                $salaryDetails->where('employee_id', $request->employee_id);
            }

            if ($request->filled('salary_type')) {
                $salaryDetails->where('salary_type', $request->salary_type);
            }

            if ($request->filled('status')) {
                $salaryDetails->where('status', $request->status);
            }

            if ($request->filled('start_date')) {
                $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
                $salaryDetails->whereHas('get_salaryperiod',
                    function ($query) use ($startDate) {
                        $query->whereDate('start_date', '>=', $startDate);
                    }
                );
            }

            if ($request->filled('end_date')) {
                $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
                $salaryDetails->whereHas('get_salaryperiod', function ($query) use ($endDate) {
                    $query->whereDate('end_date', '<=', $endDate);
                });
            }

            return DataTables::of($salaryDetails)
                ->addIndexColumn()
                ->addColumn('salary_period', function ($row) {
                    if (! $row->get_salaryperiod) {
                        return '-';
                    }

                    return ucfirst(
                        $row->get_salaryperiod->period_type
                    )
                        .' - '
                        .Carbon::parse(
                            $row->get_salaryperiod->start_date
                        )->format('d-m-Y')
                        .' to '
                        .Carbon::parse(
                            $row->get_salaryperiod->end_date
                        )->format('d-m-Y');

                })

                ->addColumn('employee', function ($row) {
                    if (! $row->get_employee) {
                        return '-';
                    }

                    return $row->get_employee->employee_code.' - '.$row->get_employee->name;
                })
                ->make(true);
        }

        $this->data['salaryperioddata'] = SalaryPeriod::orderBy('id', 'desc')->get();
        $this->data['status'] = SalaryPeriod::select('status')
            ->distinct()->get();
        $this->data['employeedata'] = Employees::where('status', '1')->orderBy('name')->get();

        return view('admin.salary_details')->with($this->data);
    }

    public function SalaryDetailsPDF(Request $request)
    {
        $salaryDetails = SalaryDetails::with([
            'get_salaryperiod',
            'get_employee',
        ]);

        if ($request->filled('salary_period_id')) {
            $salaryDetails->where('salary_period_id', $request->salary_period_id);
        }

        if ($request->filled('employee_id')) {
            $salaryDetails->where('employee_id', $request->employee_id);
        }

        if ($request->filled('salary_type')) {
            $salaryDetails->where('salary_type', $request->salary_type);
        }

        if ($request->filled('status')) {
            $salaryDetails->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
            $salaryDetails->whereHas('get_salaryperiod', function ($query) use ($startDate) {
                $query->whereDate('start_date', '>=', $startDate);
            });
        }

        if ($request->filled('end_date')) {
            $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
            $salaryDetails->whereHas('get_salaryperiod', function ($query) use ($endDate) {
                $query->whereDate('end_date', '<=', $endDate);
            });
        }

        $salaryDetails = $salaryDetails->orderBy('id', 'desc')->get();
        $pdf = Pdf::loadView('admin.salary_details_pdf', compact('salaryDetails'));

        return $pdf->download('salary-details-'.date('d-m-Y').'.pdf');
    }
}
