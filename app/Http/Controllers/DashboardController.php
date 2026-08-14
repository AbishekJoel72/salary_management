<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employees;
use App\Models\Attendance;
use App\Models\SalaryPeriod;
use App\Models\SalaryDetails;
use App\Models\SalaryPayment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function Dashboard(Request $request)
    {


        if ($request->ajax()) {



            if ($request->type == 'salary_periods') {

                $periods = SalaryPeriod::query()
                    ->latest('id');

                return DataTables::of($periods)

                    ->addIndexColumn()

                    ->editColumn('period_type', function ($row) {

                        if ($row->period_type == 'weekly') {
                            return '<span class="badge bg-info">WEEKLY</span>';
                        }

                        return '<span class="badge bg-primary">MONTHLY</span>';
                    })

                    ->editColumn('start_date', function ($row) {

                        return $row->start_date
                            ? \Carbon\Carbon::parse($row->start_date)->format('d-m-Y')
                            : '-';
                    })

                    ->editColumn('end_date', function ($row) {

                        return $row->end_date
                            ? \Carbon\Carbon::parse($row->end_date)->format('d-m-Y')
                            : '-';
                    })

                    ->editColumn('status', function ($row) {

                        $badges = [
                            'draft'      => 'secondary',
                            'calculated' => 'info',
                            'approved'   => 'warning',
                            'paid'       => 'success',
                            'cancelled'  => 'danger',
                        ];

                        $badge = $badges[$row->status] ?? 'secondary';

                        return '<span class="badge bg-' . $badge . '">'
                            . strtoupper($row->status)
                            . '</span>';
                    })

                    ->editColumn('calculated_at', function ($row) {

                        return $row->calculated_at
                            ? \Carbon\Carbon::parse($row->calculated_at)->format('d-m-Y H:i')
                            : '-';
                    })

                    ->editColumn('approved_at', function ($row) {

                        return $row->approved_at
                            ? \Carbon\Carbon::parse($row->approved_at)->format('d-m-Y H:i')
                            : '-';
                    })

                    ->editColumn('paid_at', function ($row) {

                        return $row->paid_at
                            ? \Carbon\Carbon::parse($row->paid_at)->format('d-m-Y H:i')
                            : '-';
                    })

                    ->rawColumns([
                        'period_type',
                        'status'
                    ])

                    ->make(true);
            }




            if ($request->type == 'salary_details') {

                $details = SalaryDetails::with([
                    'get_employee',
                    'get_salaryperiod'
                ])
                    ->latest('id');

                return DataTables::of($details)

                    ->addIndexColumn()

                    ->addColumn('employee_name', function ($row) {

                        return optional($row->get_employee)->name ?? '-';
                    })

                    ->addColumn('employee_code', function ($row) {

                        return optional($row->get_employee)->employee_code ?? '-';
                    })

                    ->editColumn('salary_type', function ($row) {

                        if ($row->salary_type == 'daily') {

                            return '<span class="badge bg-info">
                                        DAILY
                                    </span>';
                        }

                        return '<span class="badge bg-primary">
                                    MONTHLY
                                </span>';
                    })

                    ->addColumn('period', function ($row) {

                        if (!$row->get_salaryperiod) {
                            return '-';
                        }

                        $start = $row->get_salaryperiod->start_date
                            ? \Carbon\Carbon::parse(
                                $row->get_salaryperiod->start_date
                            )->format('d-m-Y')
                            : '-';

                        $end = $row->get_salaryperiod->end_date
                            ? \Carbon\Carbon::parse(
                                $row->get_salaryperiod->end_date
                            )->format('d-m-Y')
                            : '-';

                        return $start . ' - ' . $end;
                    })

                    ->editColumn('full_days', function ($row) {

                        return number_format($row->full_days ?? 0, 1);
                    })

                    ->editColumn('half_days', function ($row) {

                        return number_format($row->half_days ?? 0, 1);
                    })

                    ->editColumn('absent_days', function ($row) {

                        return number_format($row->absent_days ?? 0, 1);
                    })

                    ->editColumn('gross_salary', function ($row) {

                        return '₹ ' . number_format(
                            $row->gross_salary ?? 0,
                            2
                        );
                    })

                    ->editColumn('deduction', function ($row) {

                        return '₹ ' . number_format(
                            $row->deduction ?? 0,
                            2
                        );
                    })

                    ->editColumn('adjustment', function ($row) {

                        return '₹ ' . number_format(
                            $row->adjustment ?? 0,
                            2
                        );
                    })

                    ->editColumn('net_salary', function ($row) {

                        return '<strong>₹ ' .
                            number_format(
                                $row->net_salary ?? 0,
                                2
                            )
                            . '</strong>';
                    })

                    ->editColumn('status', function ($row) {

                        $badges = [
                            'calculated' => 'info',
                            'approved'   => 'warning',
                            'paid'       => 'success',
                            'cancelled'  => 'danger',
                        ];

                        $badge = $badges[$row->status] ?? 'secondary';

                        return '<span class="badge bg-' . $badge . '">'
                            . strtoupper($row->status)
                            . '</span>';
                    })

                    ->rawColumns([
                        'salary_type',
                        'net_salary',
                        'status'
                    ])

                    ->make(true);
            }



            if ($request->type == 'recent_employees') {

                $employees = Employees::with([
                    'get_department',
                    'get_designation'
                ])
                    ->latest('id');

                return DataTables::of($employees)

                    ->addIndexColumn()

                    ->addColumn('department', function ($row) {

                        return optional($row->get_department)->name ?? '-';
                    })

                    ->addColumn('designation', function ($row) {

                        return optional($row->get_designation)->name ?? '-';
                    })

                    ->editColumn('employee_type', function ($row) {

                        if ($row->employee_type == 'daily') {

                            return '<span class="badge bg-info">
                                        DAILY
                                    </span>';
                        }

                        return '<span class="badge bg-primary">
                                    MONTHLY
                                </span>';
                    })

                    ->addColumn('salary', function ($row) {

                        if ($row->employee_type == 'daily') {

                            return '₹ ' .
                                number_format(
                                    $row->daily_rate ?? 0,
                                    2
                                )
                                . ' / Day';
                        }

                        return '₹ ' .
                            number_format(
                                $row->monthly_salary ?? 0,
                                2
                            )
                            . ' / Month';
                    })

                    ->editColumn('status', function ($row) {

                        if ($row->status == '1') {

                            return '<span class="badge bg-success">
                                        ACTIVE
                                    </span>';
                        }

                        return '<span class="badge bg-danger">
                                    INACTIVE
                                </span>';
                    })

                    ->rawColumns([
                        'employee_type',
                        'status'
                    ])

                    ->make(true);
            }
        }





        $this->data['totalDepartments'] = Department::count();

        $this->data['activeDepartments'] = Department::where(
            'status',
            '1'
        )->count();


        $this->data['totalDesignations'] = Designation::count();

        $this->data['activeDesignations'] = Designation::where(
            'status',
            '1'
        )->count();


        $this->data['totalEmployees'] = Employees::count();

        $this->data['activeEmployees'] = Employees::where(
            'status',
            '1'
        )->count();

        $this->data['dailyEmployees'] = Employees::where(
            'employee_type',
            'daily'
        )
            ->where('status', '1')
            ->count();

        $this->data['monthlyEmployees'] = Employees::where(
            'employee_type',
            'monthly'
        )
            ->where('status', '1')
            ->count();


        $this->data['totalAttendance'] = Attendance::count();

        $this->data['presentAttendance'] = Attendance::where(
            'status',
            'present'
        )->count();

        $this->data['halfDayAttendance'] = Attendance::where(
            'status',
            'half_day'
        )->count();

        $this->data['absentAttendance'] = Attendance::where(
            'status',
            'absent'
        )->count();

        $this->data['leaveAttendance'] = Attendance::where(
            'status',
            'leave'
        )->count();


        $this->data['totalSalaryPeriods'] = SalaryPeriod::count();

        $this->data['draftSalaryPeriods'] = SalaryPeriod::where(
            'status',
            'draft'
        )->count();

        $this->data['calculatedSalaryPeriods'] = SalaryPeriod::where(
            'status',
            'calculated'
        )->count();

        $this->data['approvedSalaryPeriods'] = SalaryPeriod::where(
            'status',
            'approved'
        )->count();

        $this->data['paidSalaryPeriods'] = SalaryPeriod::where(
            'status',
            'paid'
        )->count();

        $this->data['cancelledSalaryPeriods'] = SalaryPeriod::where(
            'status',
            'cancelled'
        )->count();

        $this->data['totalSalaryDetails'] = SalaryDetails::count();

        $this->data['calculatedSalaryDetails'] = SalaryDetails::where(
            'status',
            'calculated'
        )->count();

        $this->data['approvedSalaryDetails'] = SalaryDetails::where(
            'status',
            'approved'
        )->count();

        $this->data['paidSalaryDetails'] = SalaryDetails::where(
            'status',
            'paid'
        )->count();

        $this->data['cancelledSalaryDetails'] = SalaryDetails::where(
            'status',
            'cancelled'
        )->count();


        $this->data['dailySalaryDetails'] = SalaryDetails::where(
            'salary_type',
            'daily'
        )->count();

        $this->data['monthlySalaryDetailsCount'] = SalaryDetails::where(
            'salary_type',
            'monthly'
        )->count();


        $this->data['totalGrossSalary'] = SalaryDetails::sum(
            'gross_salary'
        );

        $this->data['totalDeduction'] = SalaryDetails::sum(
            'deduction'
        );

        $this->data['totalAdjustment'] = SalaryDetails::sum(
            'adjustment'
        );

        $this->data['totalNetSalary'] = SalaryDetails::sum(
            'net_salary'
        );


        $this->data['totalPaidAmount'] = 0;

        if (class_exists(SalaryPayment::class)) {

            $this->data['totalPaidAmount'] =
                SalaryPayment::sum('amount');
        }


        $this->data['monthlySalaryDetails'] = SalaryDetails::where(
            'salary_type',
            'monthly'
        )
            ->selectRaw('
                COUNT(*) as total,
                SUM(gross_salary) as gross_salary,
                SUM(deduction) as deduction,
                SUM(adjustment) as adjustment,
                SUM(net_salary) as net_salary
            ')
            ->first();


        $this->data['dailySalaryDetailsSummary'] = SalaryDetails::where(
            'salary_type',
            'daily'
        )
            ->selectRaw('
                COUNT(*) as total,
                SUM(gross_salary) as gross_salary,
                SUM(deduction) as deduction,
                SUM(adjustment) as adjustment,
                SUM(net_salary) as net_salary
            ')
            ->first();


        return view('admin.dashboard')->with($this->data);
    }
}
