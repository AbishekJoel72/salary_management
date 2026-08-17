<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employees;
use App\Models\SalaryDetails;
use App\Models\SalaryPayment;
use App\Models\SalaryPeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SalaryPeriodController extends Controller
{
    public function SalaryPeriod(Request $request)
    {
        if ($request->method() == 'POST') {

            if ($request->add_salary_period) {
                try {

                    $validation = $request->validate([
                        'period_type' => 'required',
                        'start_date' => 'required',
                        'end_date' => 'required',
                    ]);
                    if ($validation) {
                        $salaryPeriod = new SalaryPeriod;
                        $salaryPeriod->period_type = $request->period_type;
                        $salaryPeriod->start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
                        $salaryPeriod->end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
                        $salaryPeriod->status = 'draft';
                        $salaryPeriod->save();
                        session()->flash('success', 'Salary Period Added Successfully');

                        return redirect()->route('salary_period');
                    }

                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back();
                }
            }

            if ($request->edit_salary_period) {
                try {
                    $validation = $request->validate([
                        'period_type' => 'required',
                        'start_date' => 'required',
                        'end_date' => 'required',
                    ]);
                    if ($validation) {
                        if ($request->id) {
                            $salaryPeriod = SalaryPeriod::where('id', $request->id)->first();

                            if (in_array($salaryPeriod->status, ['approved', 'paid', 'cancelled'])) {
                                session()->flash('error', 'Approved, Paid or Cancelled salary period cannot be edited.');

                                return redirect()->back();
                            }

                            $salaryPeriod->update([
                                'period_type' => $request->period_type,
                                'start_date' => Carbon::parse($request->start_date)->format('Y-m-d'),
                                'end_date' => Carbon::parse($request->end_date)->format('Y-m-d'),
                            ]);
                            session()->flash('success', 'Salary period updated successfully.');

                            return redirect()->back();

                        }
                    }
                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back();
                }

            }
        }



        if ($request->ajax()) {

            // ----------------------------------------------------------------------------------------------
            // ------------------------------------ Ajax Calculated ---------------------------------------
            if ($request->calculate_salary_period) {
                try {
                    DB::beginTransaction();
                    $salaryPeriod = SalaryPeriod::find($request->id);
                    if (! $salaryPeriod) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Salary period not found.',
                        ]);
                    }

                    if ($salaryPeriod->status !== 'draft') {
                        return response()->json([
                            'status' => false,
                            'message' => 'Only draft salary periods can be calculated.',
                        ]);
                    }

                    $employeeType = $salaryPeriod->period_type === 'weekly'? 'daily': 'monthly';
                    $employees = Employees::where('status', '1')->where('employee_type', $employeeType)->get();

                    if ($employees->isEmpty()) {
                        return response()->json([
                            'status' => false,
                            'message' => 'No '.$employeeType.' employees found for this salary period.',
                        ]);
                    }

                    $periodDays = Carbon::parse($salaryPeriod->start_date)->diffInDays(Carbon::parse($salaryPeriod->end_date)) + 1;

                    foreach ($employees as $employee) {
                        $attendance = Attendance::where('employee_id',$employee->id)
                            ->whereBetween(
                                'attendance_date',
                                [
                                    $salaryPeriod->start_date,
                                    $salaryPeriod->end_date,
                                ]
                            )->get();

                        $fullDays = $attendance->where('status', 'present')->count();
                        $halfDays = $attendance->where('status', 'half_day')->count();
                        $absentDays = $attendance->where('status', 'absent')->count();
                        $leaveDays = $attendance->where('status', 'leave')->count();

                        if ($employee->employee_type === 'daily') {
                            $salaryType = 'daily';
                            $baseSalary = (float) ($employee->daily_rate ?? 0);
                            $totalDayValue = (float) $attendance->sum('day_value');
                            if ($totalDayValue > 0) {
                                $workedDays = $totalDayValue;
                            } else {
                                $totalHours = (float) $attendance->sum('working_hours');
                                if ($totalHours > 0) {
                                    $workedDays = round($totalHours / 8, 2);
                                } else {
                                    $workedDays = $fullDays + ($halfDays * 0.5);
                                }
                            }

                            $grossSalary = round($workedDays * $baseSalary, 2);
                            $deduction = 0;
                            $adjustment = 0;
                            $netSalary = max(0, $grossSalary - $deduction + $adjustment);

                        } else {

                            $salaryType = 'monthly';
                            $baseSalary = (float) ($employee->monthly_salary ?? 0);
                            $perDayRate = $periodDays > 0 ? ($baseSalary / $periodDays) : 0;
                            $unworkedDays = $leaveDays + $absentDays + ($halfDays * 0.5);
                            $workedDays = max(0, $periodDays - $unworkedDays);
                            $leaveDeduction = round($unworkedDays * $perDayRate, 2);
                            $grossSalary = round($baseSalary, 2);
                            $deduction = $leaveDeduction;
                            $adjustment = 0;
                            $netSalary = max(0, round($baseSalary - $leaveDeduction + $adjustment, 2));
                        }

                        $salaryDetail = SalaryDetails::updateOrCreate(
                            [
                                'salary_period_id' => $salaryPeriod->id,
                                'employee_id' => $employee->id,
                            ],
                            [
                                'salary_type' => $salaryType,
                                'base_salary' => round($baseSalary, 2),
                                'full_days' => $fullDays,
                                'half_days' => $halfDays,
                                'absent_days' => $absentDays,
                                'leave_days' => $leaveDays,
                                'worked_days' => $workedDays,
                                'gross_salary' => round($grossSalary, 2),
                                'deduction' => round($deduction, 2),
                                'adjustment' => round($adjustment, 2),
                                'net_salary' => round($netSalary, 2),
                                'status' => 'calculated',
                            ]
                        );
                    }

                    $salaryPeriod->update(['status' => 'calculated','calculated_at' => now(),]);
                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'message' => 'Salary calculated successfully.',
                    ]);

                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => $e->getMessage(),
                    ], 500);
                }
            }

            // ----------------------------------------------------------------------------------------------
            // ------------------------------------ Ajax Approved At ---------------------------------------

            if ($request->approve_salary_period) {
                try {
                    DB::beginTransaction();
                    $salaryPeriod = SalaryPeriod::find($request->id);

                    if (! $salaryPeriod) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Salary period not found.',
                        ]);
                    }

                    if ($salaryPeriod->status !== 'calculated') {
                        return response()->json([
                            'status' => false,
                            'message' => 'Only calculated salary periods can be approved.',
                        ]);
                    }

                    $salaryDetailsCount = SalaryDetails::where('salary_period_id',$salaryPeriod->id)->count();

                    if ($salaryDetailsCount == 0) {
                        return response()->json([
                            'status' => false,
                            'message' => 'No salary details found for this period.',
                        ]);
                    }

                    SalaryDetails::where('salary_period_id',$salaryPeriod->id)->update(['status' => 'approved',]);
                    $salaryPeriod->update([
                        'status' => 'approved',
                        'approved_at' => now(),
                    ]);
                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'message' => 'Salary period and salary details approved successfully.',
                    ]);

                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => $e->getMessage(),
                    ], 500);
                }
            }

            // ----------------------------------------------------------------------------------------------
            // ------------------------------------ Ajax Paid ---------------------------------------

            if ($request->pay_salary_period) {
                DB::beginTransaction();
                try {
                    $salaryPeriod = SalaryPeriod::find($request->id);
                    if (! $salaryPeriod) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Salary period not found.',
                        ], 404);
                    }
                    if ($salaryPeriod->status !== 'approved') {
                        return response()->json([
                            'status' => false,
                            'message' => 'Only approved salary period can be paid.',
                        ]);
                    }

                    $paymentMethod = $salaryPeriod->period_type == 'weekly'? 'cash': 'bank_transfer';
                    $salaryDetails = SalaryDetails::where('salary_period_id',$salaryPeriod->id)->get();

                    if ($salaryDetails->isEmpty()) {
                        return response()->json([
                            'status' => false,
                            'message' => 'No salary details found for this period.',
                        ]);
                    }

                    foreach ($salaryDetails as $salaryDetail) {
                        $alreadyPaid = SalaryPayment::where('salary_detail_id',$salaryDetail->id)->exists();

                        if ($alreadyPaid) {
                            continue;
                        }

                        SalaryPayment::create([
                            'salary_detail_id' => $salaryDetail->id,
                            'payment_date' => now()->format('Y-m-d'),
                            'amount' => $salaryDetail->net_salary,
                            'payment_method' => $paymentMethod,
                            'transaction_reference' => null,
                            'remarks' => ucfirst($salaryPeriod->period_type).' salary payment',
                        ]);

                        $salaryDetail->status = 'paid';
                        $salaryDetail->save();
                    }

                    $salaryPeriod->status = 'paid';
                    $salaryPeriod->paid_at = now();
                    $salaryPeriod->save();
                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'message' => 'Salary payment completed successfully.',
                    ]);

                } catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => $e->getMessage(),
                    ], 500);
                }
            }

            // ----------------------------------------------------------------------------------------------
            // ------------------------------------ Ajax Cancelled ---------------------------------------
            if ($request->cancel_salary_period) {
                try {
                    $salaryPeriod = SalaryPeriod::find($request->id);

                    if (! $salaryPeriod) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Salary period not found.',
                        ], 404);
                    }

                    if (in_array($salaryPeriod->status, ['paid', 'cancelled'])) {
                        return response()->json([
                            'status' => false,
                            'message' => 'This salary period cannot be cancelled.',
                        ]);
                    }

                    $salaryPeriod->status = 'cancelled';
                    $salaryPeriod->cancelled_at = now();
                    $salaryPeriod->save();

                    return response()->json([
                        'status' => true,
                        'message' => 'Salary period cancelled successfully.',
                    ]);

                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => $e->getMessage(),
                    ], 500);
                }
            }
            
            // ----------------------------------------------------------------------------------------------
            // ------------------------------------ Data Table Data's---------------------------------------

            if ($request->edit_data) {
                $id = $request->id;
                $salaryPeriod = SalaryPeriod::where('id', $id)->first();

                return response()->json($salaryPeriod);
            }

            if ($request->view_data) {
                $id = $request->id;
                $salaryPeriod = SalaryPeriod::where('id', $id)->first();

                return response()->json($salaryPeriod);
            }

            if ($request->get_delete) {
                $id = $request->id;
                $delete = SalaryPeriod::where('id', $id)->delete();

                if ($delete) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Deleted successfully.',
                    ]);
                }
            }

            $salaryPeriods = SalaryPeriod::query()->orderBy('id', 'desc');

            if ($request->filled('period_type')) {
                $salaryPeriods->where('period_type', $request->period_type);
            }

            if ($request->filled('start_date')) {
                $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
                $salaryPeriods->whereDate('start_date', '>=', $startDate);
            }

            if ($request->filled('end_date')) {
                $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
                $salaryPeriods->whereDate('end_date', '<=', $endDate);
            }

            if ($request->filled('status')) {
                $salaryPeriods->where('status', $request->status);
            }

            return DataTables::of($salaryPeriods)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $html = '<div class="dropdown"><a href="#" class="text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a><ul class="dropdown-menu">';
                    $html .= '<li><a href="javascript:void(0)" class="View dropdown-item" data-id="'.$row->id.'">View</a></li>';
                    if ($row->status == 'draft') {
                        $html .= '<li><a href="javascript:void(0)" class="editRow dropdown-item" data-id="'.$row->id.'">Edit</a></li>';
                        $html .= '<li><a href="javascript:void(0)" class="calculateRow dropdown-item" data-id="'.$row->id.'">Calculate</a></li>';
                        $html .= '<li><a href="javascript:void(0)" class="deleteRow dropdown-item text-danger" data-id="'.$row->id.'">Delete</a></li>';
                    }
                    if ($row->status == 'calculated') {
                        $html .= '<li><a href="javascript:void(0)" class="approveRow dropdown-item" data-id="'.$row->id.'">Approve</a></li>';
                        $html .= '<li><a href="javascript:void(0)" class="cancelRow dropdown-item" data-id="'.$row->id.'">Cancelled</a></li>';
                    }
                    if ($row->status == 'approved') {
                        $html .= '<li><a href="javascript:void(0)" class="payRow dropdown-item" data-id="'.$row->id.'">Pay</a></li>';
                        $html .= '<li><a href="javascript:void(0)" class="cancelRow dropdown-item" data-id="'.$row->id.'">Cancelled</a></li>';
                    }
                    $html .= '</ul></div>';

                    return $html;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.salary_period');
    }
}
