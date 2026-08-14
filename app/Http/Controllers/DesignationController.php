<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DesignationController extends Controller
{
    public function Designation(Request $request)
    {
        if ($request->method() == 'POST') {
            if ($request->add_designation) {
                try {
                    $validation = $request->validate([
                        'department' => 'required',
                        'designation_name' => 'required',
                    ]);
                    if ($validation) {
                        
                        if (Designation::where('name', $request->designation_name)->exists()) {
                            session()->flash('error', 'Designation name already exists.');

                            return redirect()->back()->withInput();
                        }
                        $d = new Designation;
                        $d->department_id = $request->department;
                        $d->name = $request->designation_name;
                        $d->save();
                        session()->flash('success', 'Designation Added successfully.');

                        return redirect()->route('designation');
                    }
                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back();
                }
            }

            if ($request->edit_designation) {
                try {
                    $validation = $request->validate([
                        'department' => 'required',
                        'designation_name' => 'required',
                    ]);
                    if ($validation) {
                        if ($request->id) {
                            Designation::where('id', $request->id)->update([
                                'department_id' => $request->department,
                                'name' => $request->designation_name,
                            ]);
                            session()->flash('success', 'Designation Updated Successfully');

                            return redirect()->route('designation');
                        }
                    }

                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());

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
                            Designation::where('id', $request->id)
                                ->update([
                                    'status' => $request->status,
                                ]);
                            session()->flash('success', 'Status Updated Successfully');

                            return redirect()->route('designation');
                        }
                    }
                } catch (\Exception $th) {
                    session()->flash('error', $th->getMessage());

                    return redirect()->back();
                }
            }
        }

        if ($request->ajax()) {

            if ($request->get_designation) {
                $id = $request->id;
                $d = Designation::where('id', $id)->first();

                return response()->json($d);
            }

            if ($request->get_status) {
                $id = $request->id;
                $status = Designation::where('id', $id)->first();

                return response()->json($status);
            }

            if ($request->get_delete) {
                $id = $request->id;
                $delete = Designation::where('id', $id)->delete();

                if ($delete) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Deleted successfully.',
                    ]);
                }
            }

            $data = Designation::select([
                'id',
                'department_id',
                'name',
                'status',
            ]);

            if ($request->filled('department')) {
                $data->where('department_id', $request->department);
            }

            if ($request->filled('designation')) {
                $search = $request->designation;
                $data->where('name', 'like', '%'.$search.'%');
            }

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

        return view('admin.designation')->with($this->data);
    }
}
