<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\SalaryDetails;
use App\Models\SalaryPeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalaryDetailsController extends Controller
{
    public function SalaryDetails(Request $request)
    {
        if (
            $request->ajax() &&
            $request->has('get_salary_details')
        ) {

            $salaryDetails = SalaryDetails::with([
                'get_salaryperiod',
                'get_employee',
            ])
                ->select('salary_details.*');

            // Salary Period Filter
            if ($request->filled('salary_period_id')) {

                $salaryDetails->where(
                    'salary_period_id',
                    $request->salary_period_id
                );
            }

            // Employee Filter
            if ($request->filled('employee_id')) {

                $salaryDetails->where(
                    'employee_id',
                    $request->employee_id
                );
            }

            // Salary Type Filter
            if ($request->filled('salary_type')) {

                $salaryDetails->where(
                    'salary_type',
                    $request->salary_type
                );
            }

            // Status Filter
            if ($request->filled('status')) {

                $salaryDetails->where(
                    'status',
                    $request->status
                );
            }

            // Start Date Filter
            if ($request->filled('start_date')) {

                $startDate = Carbon::createFromFormat(
                    'd-m-Y',
                    $request->start_date
                )->format('Y-m-d');

                $salaryDetails->whereHas(
                    'get_salaryperiod',
                    function ($query) use ($startDate) {

                        $query->whereDate(
                            'start_date',
                            '>=',
                            $startDate
                        );

                    }
                );
            }

            // End Date Filter
            if ($request->filled('end_date')) {

                $endDate = Carbon::createFromFormat(
                    'd-m-Y',
                    $request->end_date
                )->format('Y-m-d');

                $salaryDetails->whereHas(
                    'get_salaryperiod',
                    function ($query) use ($endDate) {

                        $query->whereDate(
                            'end_date',
                            '<=',
                            $endDate
                        );

                    }
                );
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

                    return $row->get_employee->employee_code
                        .' - '
                        .$row->get_employee->name;

                })

                ->editColumn('salary_type', function ($row) {

                    return ucfirst($row->salary_type);

                })

                ->editColumn('base_salary', function ($row) {

                    return number_format(
                        $row->base_salary,
                        2
                    );

                })

                ->editColumn('gross_salary', function ($row) {

                    return number_format(
                        $row->gross_salary,
                        2
                    );

                })

                ->editColumn('deduction', function ($row) {

                    return number_format(
                        $row->deduction,
                        2
                    );

                })

                ->editColumn('adjustment', function ($row) {

                    return number_format(
                        $row->adjustment,
                        2
                    );

                })

                ->editColumn('net_salary', function ($row) {

                    return number_format(
                        $row->net_salary,
                        2
                    );

                })

                ->make(true);
        }

        // Filter dropdown data

        $salaryperioddata = SalaryPeriod::orderBy(
            'id',
            'desc'
        )->get();

        $employeedata = Employees::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();

        return view(
            'admin.salary_details',
            compact(
                'salaryperioddata',
                'employeedata'
            )
        );
    }
}
