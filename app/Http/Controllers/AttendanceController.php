<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employees;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function Attendance(Request $request)
    {
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
                    $attendance->status = $request->status;
                    if ($request->status == 'present' || $request->status == 'half_day') {
                        $attendance->check_in = $request->check_in;
                        $attendance->check_out = $request->check_out;
                    } else {
                        $attendance->check_in = null;
                        $attendance->check_out = null;
                    }

                    $workingHours = 0;

                    if ($attendance->check_in && $attendance->check_out) {
                        $checkIn = Carbon::createFromFormat('H:i', $attendance->check_in);
                        $checkOut = Carbon::createFromFormat('H:i', $attendance->check_out);
                        if ($checkOut->lessThan($checkIn)) {
                            $checkOut->addDay();
                        }
                        $workingHours = $checkIn->diffInMinutes($checkOut) / 60;
                    }

                    $attendance->working_hours = round($workingHours, 2);

                    if ($request->status == 'present') {
                        $attendance->day_value = 1.0;
                    } elseif ($request->status == 'half_day') {
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

        if ($request->ajax()) {
            if ($request->get_employee) {
                $id = $request->id;
                $emp = Employees::where('id', $id)->first();

                return response()->json($emp);
            }

            if ($request->get_status) {
                $id = $request->id;
                $status = Employees::where('id', $id)->first();

                return response()->json($status);
            }

            if ($request->get_delete) {
                $id = $request->id;
                $delete = Employees::where('id', $id)->delete();

                if ($delete) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Designation Deleted successfully.',
                    ]);
                }
            }

            $data = Attendance::with('get_employee', 'get_employee.get_department', 'get_employee.get_designation')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('department', function ($row) {
                    return $row->get_employee->get_department->code.' - '.$row->get_employee->get_department->name;
                })
                ->addColumn('designation', function ($row) {
                    return $row->get_employee->get_designation->name;
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <div class="dropdown">
                            <a href="#" class="text-dark " role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="javascript:void(0)"  class="editRow dropdown-item" data-id="'.$row->id.'">Edit</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"  class="editStatusRow dropdown-item" data-id="'.$row->id.'">Status</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="deleteRow dropdown-item text-danger" data-id="'.$row->id.'">Delete</a>
                                </li>
                            </ul>
                        </div>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $this->data['employeedata'] = Employees::get();

        return view('admin.attendance')->with($this->data);
    }
}
