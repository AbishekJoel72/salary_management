<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employees;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function Attendance(Request $request)
    {
        if ($request->method() == 'POST') {

            if ($request->add_attendance) {
                try {
                    $validation = $request->validate([
                        'employee_id' => 'required',
                        'attendance_date' => 'required',
                        'status' => 'required',
                    ]);

                    if ($validation) {
                        $attendance = new Attendance;
                        $attendance->employee_id = $request->employee_id;
                        $attendance->attendance_date = Carbon::createFromFormat('d-m-Y', $request->attendance_date)->format('Y-m-d');
                        $workingHours = 0;
                        // if ($request->status == 'present' || $request->status == 'half_day') {
                        //     $attendance->check_in = $request->check_in;
                        //     $attendance->check_out = $request->check_out;
                        // } else {
                        //     $attendance->check_in = null;
                        //     $attendance->check_out = null;
                        // }

                        if ($request->status == 'present' || $request->status == 'half_day') {
                            if ($request->check_in && $request->check_out) {
                                $checkIn = Carbon::createFromFormat('g:i A', strtoupper(trim($request->check_in)));
                                $checkOut = Carbon::createFromFormat('g:i A', strtoupper(trim($request->check_out)));
                                if ($checkOut->lessThan($checkIn)) {
                                    $checkOut->addDay();
                                }
                                $workingHours = $checkIn->diffInMinutes($checkOut) / 60;
                                $attendance->check_in = $checkIn->format('H:i:s');
                                $attendance->check_out = $checkOut->format('H:i:s');
                            } else {
                                $attendance->check_in = null;
                                $attendance->check_out = null;
                            }
                        } else {
                            $attendance->check_in = null;
                            $attendance->check_out = null;
                        }

                        $attendance->working_hours = round($workingHours, 2);
                        // $attendance->day_value = round(min($workingHours / 8, 1), 3);

                        if ($workingHours >= 8) {
                            $attendance->status = 'present';
                        } elseif ($workingHours >= 4) {
                            $attendance->status = 'half_day';
                        } else {
                            $attendance->status = $request->status;
                        }

                        if ($attendance->status == 'present') {
                            $attendance->day_value = 1.0;
                        } elseif ($attendance->status == 'half_day') {
                            $attendance->day_value = 0.5;
                        } else {
                            $attendance->day_value = 0.0;
                        }

                        $attendance->remarks = $request->remarks ?? null;
                        $attendance->save();
                        session()->flash('success', 'Attendance Details Added Successfully');

                        return redirect()->route('attendance');
                    }

                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back();
                }
            }

            if ($request->edit_attendance) {
                try {
                    $validation = $request->validate([
                        'employee_id' => 'required',
                        'attendance_date' => 'required',
                        'status' => 'required',
                    ]);

                    if ($validation) {
                        if ($request->id) {
                            $attendance = Attendance::where('id', $request->id)->first();
                            if ($attendance) {
                                $attendance->employee_id = $request->employee_id;
                                $attendance->attendance_date = Carbon::createFromFormat('d-m-Y', $request->attendance_date)->format('Y-m-d');
                                $attendance->status = $request->status;
                                $workingHours = 0;
                                if ($request->status == 'present' || $request->status == 'half_day') {
                                    if ($request->check_in && $request->check_out) {
                                        $checkIn = Carbon::createFromFormat('g:i A', strtoupper(trim($request->check_in)));
                                        $checkOut = Carbon::createFromFormat('g:i A', strtoupper(trim($request->check_out)));

                                        if ($checkOut->lessThan($checkIn)) {
                                            $checkOut->addDay();
                                        }
                                        $workingHours = $checkIn->diffInMinutes($checkOut) / 60;
                                        $attendance->check_in = $checkIn->format('H:i:s');
                                        $attendance->check_out = $checkOut->format('H:i:s');

                                    } else {
                                        $attendance->check_in = null;
                                        $attendance->check_out = null;
                                    }
                                } else {
                                    $attendance->check_in = null;
                                    $attendance->check_out = null;
                                }

                                $attendance->working_hours = round($workingHours, 2);
                                // $attendance->day_value = round(min($workingHours / 8, 1), 3);

                                if ($workingHours >= 8) {
                                    $attendance->status = 'present';
                                } elseif ($workingHours >= 4) {
                                    $attendance->status = 'half_day';
                                } else {
                                    $attendance->status = $request->status;
                                }

                                if ($attendance->status == 'present') {
                                    $attendance->day_value = 1.0;
                                } elseif ($attendance->status == 'half_day') {
                                    $attendance->day_value = 0.5;
                                } else {
                                    $attendance->day_value = 0.0;
                                }

                                $attendance->remarks = $request->remarks ?? null;
                                $attendance->save();
                                session()->flash('success', 'Attendance Details Updated Successfully');

                                return redirect()->route('attendance');
                            }
                        }
                    }

                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back();
                }
            }
        }

        if ($request->method() == 'GET') {
            if ($request->get_designation_data) {
                $department_id = $request->departmentId;
                $designations = Designation::where('department_id', $department_id)->where('status', '1')->get();

                return response()->json($designations);
            }
        }

        if ($request->ajax()) {
            if ($request->get_atten) {
                $id = $request->id;
                $a = Attendance::where('id', $id)->first();

                return response()->json($a);
            }

            if ($request->get_delete) {
                $id = $request->id;
                $delete = Attendance::where('id', $id)->delete();

                if ($delete) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Deleted successfully.',
                    ]);
                }
            }

            $data = Attendance::with(['get_employee', 'get_employee.get_department', 'get_employee.get_designation']);

            if ($request->filled('employee_id')) {
                $data->where('employee_id', $request->employee_id);
            }

            if ($request->filled('department_id')) {
                $data->whereHas('get_employee', function ($query) use ($request) {
                    $query->where('department_id', $request->department_id);
                });
            }

            if ($request->filled('designation_id')) {
                $data->whereHas('get_employee', function ($query) use ($request) {
                    $query->where('designation_id', $request->designation_id);
                });
            }

            if ($request->filled('from_date')) {
                try {
                    $fromDate = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
                    $data->whereDate('attendance_date', '>=', $fromDate);

                } catch (\Exception $e) {
                    // Invalid date - ignore filter
                }
            }

            if ($request->filled('to_date')) {
                try {
                    $toDate = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');
                    $data->whereDate('attendance_date', '<=', $toDate);

                } catch (\Exception $e) {
                    // Invalid date - ignore filter
                }
            }

            if ($request->filled('status')) {
                $data->where('status', $request->status);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('employee', function ($row) {
                    return $row->get_employee->employee_code
                        .' - '
                        .$row->get_employee->name;
                })
                ->addColumn('department', function ($row) {
                    return $row->get_employee->get_department->code
                        .' - '
                        .$row->get_employee->get_department->name;
                })
                ->addColumn('designation', function ($row) {
                    return $row->get_employee->get_designation->name;
                })

                ->addColumn('actions', function ($row) {
                    return '
                        <div class="dropdown">
                            <a href="#" class="text-dark"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">

                                <i class="fas fa-ellipsis-v"></i>

                            </a>

                            <ul class="dropdown-menu">

                                <li>
                                    <a href="javascript:void(0)"
                                        class="editRow dropdown-item"
                                        data-id="'.$row->id.'">
                                        Edit
                                    </a>
                                </li>

                                <li>
                                    <a href="javascript:void(0)"
                                        class="deleteRow dropdown-item text-danger"
                                        data-id="'.$row->id.'">
                                        Delete
                                    </a>
                                </li>

                            </ul>
                        </div>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $this->data['employeedata'] = Employees::where('status', '1')->get();
        $this->data['departmentdata'] = Department::where('status', '1')->get();

        return view('admin.attendance')->with($this->data);
    }
}
