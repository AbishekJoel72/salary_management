<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employees;
use App\Models\SalaryDetails;
use App\Models\SalaryPayment;
use App\Models\SalaryPeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function Dashboard(Request $request)
    {

        if ($request->ajax()) {

            if ($request->type == 'salary_periods') {

                $periods = SalaryPeriod::query()->latest('id');

                return DataTables::of($periods)
                    ->addIndexColumn()
                    ->make(true);
            }

            if ($request->type == 'salary_details') {
                $details = SalaryDetails::with(['get_employee', 'get_salaryperiod'])->latest('id');

                return DataTables::of($details)
                    ->addIndexColumn()
                    ->addColumn('employee', function ($row) {
                        return $row->get_employee->employee_code.' - '.$row->get_employee->name;
                    })
                    ->addColumn('period', function ($row) {
                        if (! $row->get_salaryperiod) {
                            return '-';
                        }
                        $start = $row->get_salaryperiod->start_date
                            ? Carbon::parse(
                                $row->get_salaryperiod->start_date
                            )->format('d-m-Y')
                            : '-';
                        $end = $row->get_salaryperiod->end_date
                            ? Carbon::parse(
                                $row->get_salaryperiod->end_date
                            )->format('d-m-Y')
                            : '-';

                        return $start.' - '.$end;
                    })

                    ->make(true);
            }

            if ($request->type == 'salary_payment') {
                $salaryPayment = SalaryPayment::with([
                    'get_salarydetail',
                    'get_salarydetail.get_employee',
                    'get_salarydetail.get_employee.get_department',
                    'get_salarydetail.get_employee.get_designation',
                ]);

                return DataTables::of($salaryPayment)
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

            if ($request->type == 'recent_employees') {
                $employees = Employees::with([
                    'get_department',
                    'get_designation',
                ])->latest('id');

                return DataTables::of($employees)
                    ->addIndexColumn()
                    ->addColumn('employee', function ($row) {
                        return $row->employee_code.'- '.$row->name;
                    })
                    ->make(true);
            }
        }

        $this->data['totalDepartments'] = Department::count();
        $this->data['activeDepartments'] = Department::where('status', '1')->count();
        $this->data['totalDesignations'] = Designation::count();
        $this->data['activeDesignations'] = Designation::where('status', '1')->count();
        $this->data['totalEmployees'] = Employees::count();
        $this->data['activeEmployees'] = Employees::where('status', '1')->count();
        $this->data['dailyEmployees'] = Employees::where('employee_type', 'daily')->where('status', '1')->count();
        $this->data['monthlyEmployees'] = Employees::where('employee_type', 'monthly')->where('status', '1')->count();
        $this->data['totalAttendance'] = Attendance::count();
        $this->data['presentAttendance'] = Attendance::where('status', 'present')->count();
        $this->data['halfDayAttendance'] = Attendance::where('status', 'half_day')->count();
        $this->data['absentAttendance'] = Attendance::where('status', 'absent')->count();
        $this->data['leaveAttendance'] = Attendance::where('status', 'leave')->count();
        $this->data['totalSalaryPeriods'] = SalaryPeriod::count();
        $this->data['draftSalaryPeriods'] = SalaryPeriod::where('status', 'draft')->count();
        $this->data['calculatedSalaryPeriods'] = SalaryPeriod::where('status', 'calculated')->count();
        $this->data['approvedSalaryPeriods'] = SalaryPeriod::where('status', 'approved')->count();
        $this->data['paidSalaryPeriods'] = SalaryPeriod::where('status', 'paid')->count();
        $this->data['cancelledSalaryPeriods'] = SalaryPeriod::where('status', 'cancelled')->count();
        $this->data['totalSalaryDetails'] = SalaryDetails::count();
        $this->data['calculatedSalaryDetails'] = SalaryDetails::where('status', 'calculated')->count();
        $this->data['approvedSalaryDetails'] = SalaryDetails::where('status', 'approved')->count();
        $this->data['paidSalaryDetails'] = SalaryDetails::where('status', 'paid')->count();
        $this->data['cancelledSalaryDetails'] = SalaryDetails::where('status', 'cancelled')->count();
        $this->data['dailySalaryDetails'] = SalaryDetails::where('salary_type', 'daily')->count();
        $this->data['monthlySalaryDetailsCount'] = SalaryDetails::where('salary_type', 'monthly')->count();
        $this->data['totalGrossSalary'] = SalaryDetails::sum('gross_salary');
        $this->data['totalDeduction'] = SalaryDetails::sum('deduction');
        $this->data['totalAdjustment'] = SalaryDetails::sum('adjustment');
        $this->data['totalNetSalary'] = SalaryDetails::sum('net_salary');
        $this->data['totalPaidAmount'] = 0;

        if (class_exists(SalaryPayment::class)) {

            $this->data['totalPaidAmount'] =
                SalaryPayment::sum('amount');
        }

        $this->data['monthlySalaryDetails'] = SalaryDetails::where(
            'salary_type',
            'monthly'
        )->selectRaw('
            COUNT(*) as total,
            SUM(gross_salary) as gross_salary,
            SUM(deduction) as deduction,
            SUM(adjustment) as adjustment,
            SUM(net_salary) as net_salary
        ')->first();

        $this->data['dailySalaryDetailsSummary'] = SalaryDetails::where(
            'salary_type',
            'daily'
        )->selectRaw('
            COUNT(*) as total,
            SUM(gross_salary) as gross_salary,
            SUM(deduction) as deduction,
            SUM(adjustment) as adjustment,
            SUM(net_salary) as net_salary
        ')->first();

        return view('admin.dashboard')->with($this->data);
    }
}
