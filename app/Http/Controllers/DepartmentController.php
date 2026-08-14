<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function Department(Request $request)
    {
        if ($request->method() == 'POST') {
            if ($request->add_department) {
                try {
                    $validation = $request->validate([
                        'department_name' => 'required',
                        'department_code' => 'required',
                    ]);
                    if ($validation) {

                        if (Department::where('code', $request->department_code)->exists()) {
                            session()->flash('error', 'Department code already exists.');

                            return redirect()->back()->withInput();
                        }

                        if (Department::where('name', $request->department_name)->exists()) {
                            session()->flash('error', 'Department name already exists.');

                            return redirect()->back()->withInput();
                        }
                        
                        $department = new Department;
                        $department->code = $request->department_code;
                        $department->name = $request->department_name;
                        $department->save();
                        session()->flash('success', 'Department Added successfully.');

                        return redirect()->route('department');
                    }
                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back();
                }
            }

            if ($request->edit_department) {
                try {
                    $validation = $request->validate([
                        'department_name' => 'required',
                        'department_code' => 'required',
                    ]);
                    if ($validation) {
                        if ($request->id) {
                            Department::where('id', $request->id)
                                ->update([
                                    'code' => $request->department_code,
                                    'name' => $request->department_name,

                                ]);
                            session()->flash('success', 'Department Updated Successfully');

                            return redirect()->route('department');
                        }
                    }

                } catch (\Exception $th) {
                    session()->flash('error', $th->getMessage());

                    return redirect()->back();
                }
            }
            if ($request->edit_status) {
                try {
                    $validation = $request->validate([
                        'status' => 'required',
                    ]);
                    if ($validation) {
                        if ($request->id) {
                            Department::where('id', $request->id)
                                ->update([
                                    'status' => $request->status,
                                ]);
                            session()->flash('success', 'Status Updated Successfully');

                            return redirect()->route('department');
                        }
                    }
                } catch (\Exception $th) {
                    session()->flash('error', $th->getMessage());

                    return redirect()->back();
                }
            }
        }

        if ($request->ajax()) {

            if ($request->get_department) {
                $id = $request->id;
                $department = Department::where('id', $id)->first();

                return response()->json($department);
            }

            if ($request->get_status) {
                $id = $request->id;
                $status = Department::where('id', $id)->first();

                return response()->json($status);
            }

            if ($request->get_delete) {
                $id = $request->id;
                $delete = Department::where('id', $id)->delete();

                if ($delete) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Deleted successfully.',
                    ]);
                }
            }

            $data = Department::select([
                'id',
                'code',
                'name',
                'status',
            ]);

            if ($request->filled('department')) {
                $search = $request->department;
                $data->where(function ($query) use ($search) {
                    $query->where('code', 'like', '%'.$search.'%')
                        ->orWhere('name', 'like', '%'.$search.'%');
                });
            }

            return DataTables::of($data)
                ->addIndexColumn()
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

        return view('admin.department');
    }
}
