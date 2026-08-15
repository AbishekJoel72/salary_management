<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employees;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeesController extends Controller
{
    public function Employees(Request $request)
    {
        if ($request->method() == 'POST') {
            if ($request->add_employee) {
                try {
                    $validation = $request->validate([
                        'department_id' => 'required',
                        'designation_id' => 'required',
                        'employee_code' => 'required',
                        'name' => 'required',
                        'email' => 'nullable|email',
                        'phone' => 'nullable',
                        'joining_date' => 'required',
                    ]);
                    if ($validation) {

                        if (Employees::where('employee_code', $request->employee_code)->exists()) {
                            session()->flash('error', 'Employee Code already exists.');

                            return redirect()->back()->withInput();
                        }

                        if (! empty($request->email)) {
                            if (Employees::where('email', $request->email)->exists()) {
                                session()->flash('error', 'Email already exists.');

                                return redirect()->back()->withInput();
                            }
                        }

                        if (! empty($request->phone)) {
                            if (Employees::where('phone', $request->phone)->exists()) {
                                session()->flash('error', 'Phone number already exists.');

                                return redirect()->back()->withInput();
                            }
                        }

                        $emp = new Employees;
                        $emp->department_id = $request->department_id;
                        $emp->designation_id = $request->designation_id;
                        $emp->employee_code = $request->employee_code;
                        $emp->name = $request->name;
                        $emp->email = ! empty($request->email) ? $request->email : null;
                        $emp->phone = ! empty($request->phone) ? $request->phone : null;
                        $emp->employee_type = $request->employee_type;
                        $emp->daily_rate = ! empty($request->daily_rate) ? $request->daily_rate : null;
                        $emp->monthly_salary = ! empty($request->monthly_salary) ? $request->monthly_salary : null;

                        try {
                            $emp->joining_date = Carbon::createFromFormat('d-m-Y', $request->joining_date)->format('Y-m-d');
                        } catch (\Exception $ex) {
                            $emp->joining_date = Carbon::parse($request->joining_date)->format('Y-m-d');
                        }

                        $emp->save();
                        session()->flash('success', 'Employee Details Added Successfully');

                        return redirect()->route('employee');

                    }

                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back()->withInput();
                }
            }

            if ($request->edit_employee) {
                try {
                    $validation = $request->validate([
                        'department_id' => 'required',
                        'designation_id' => 'required',
                        'employee_code' => 'required',
                        'name' => 'required',
                        'email' => 'nullable|email',
                        'phone' => 'nullable',
                        'joining_date' => 'required',
                    ]);
                    if ($validation) {
                        if ($request->id) {
                            try {
                                $joiningDate = Carbon::createFromFormat('d-m-Y', $request->joining_date)->format('Y-m-d');
                            } catch (\Exception $ex) {
                                $joiningDate = Carbon::parse($request->joining_date)->format('Y-m-d');
                            }

                            Employees::where('id', $request->id)->update([
                                'department_id' => $request->department_id,
                                'designation_id' => $request->designation_id,
                                'employee_code' => $request->employee_code,
                                'name' => $request->name,
                                'email' => ! empty($request->email) ? $request->email : null,
                                'phone' => ! empty($request->phone) ? $request->phone : null,
                                'employee_type' => $request->employee_type,
                                'daily_rate' => ! empty($request->daily_rate) ? $request->daily_rate : null,
                                'monthly_salary' => ! empty($request->monthly_salary) ? $request->monthly_salary : null,
                                'joining_date' => $joiningDate,
                            ]);
                            session()->flash('success', 'Employee Details Updated Successfully');

                            return redirect()->route('employee');
                        }
                    }
                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back()->withInput();
                }
            }

            if ($request->edit_status) {
                try {
                    $validation = $request->validate([
                        'status' => 'required',
                    ]);
                    if ($validation) {
                        if ($request->id) {
                            Employees::where('id', $request->id)
                                ->update([
                                    'status' => $request->status,
                                ]);
                            session()->flash('success', 'Status Updated Successfully');

                            return redirect()->route('employee');
                        }
                    }
                } catch (\Exception $th) {
                    session()->flash('error', $th->getMessage());

                    return redirect()->back();
                }
            }
        }

        if ($request->method() == 'GET') {

            if ($request->get_designation_data) {

                $department_id = $request->departmentId;

                $designations = Designation::where(
                    'department_id',
                    $department_id
                )
                    ->where('status', '1')
                    ->get();

                return response()->json($designations);
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
                        'message' => 'Deleted successfully.',
                    ]);
                }
            }

            $data = Employees::with('get_department', 'get_designation');

            if ($request->department) {
                $data->where('department_id', $request->department);
            }

            if ($request->designation) {
                $data->where('designation_id', $request->designation);
            }

            if ($request->employee_type) {
                $data->where('employee_type', $request->employee_type);
            }

            if ($request->employee_code) {
                $data->where('employee_code', 'like', '%'.$request->employee_code.'%');
            }

            if ($request->employee_name) {
                $data->where('name', 'like', '%'.$request->employee_name.'%');
            }

            if ($request->status !== null && $request->status !== '') {
                $data->where('status', $request->status);
            }

            $data = $data->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('department', function ($row) {
                    return $row->get_department->code.' - '.$row->get_department->name;
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
        $this->data['departmentdata'] = Department::where('status', '1')->get();
        $this->data['designationdata'] = Designation::where('status', '1')->get();

        return view('admin.employees')->with($this->data);
    }
}
