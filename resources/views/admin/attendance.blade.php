@extends('layout.default')
@section('content')
      <div class="container">

        <div class="card mt-3">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-2">
                <h5 class="card-title">Employees</h5>
                <div class="d-flex align-items-center gap-2 ms-auto">
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#Addmodel">
                        <i class="fa-solid fa-plus"></i> Add New
                    </a>
                </div>
            </div>
            <div class="card-body table-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Work Hours</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
 

        <div class="modal fade" id="Addmodel" tabindex="-1" aria-labelledby="AddmodelLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title"> Add Attendance </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>


                    <form action="{{ route('attendance') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>

                        @csrf

                        <input type="hidden" name="add_attendance" value="true">


                        <div class="modal-body">
                            <div class="row">


                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">Employee<span class="text-danger">*</span></label>
                                    <select name="employee_id" id="add_employee_id" class="form-select" required>
                                        <option value="" disabled selected>Select Employee</option>
                                        @foreach ($employeedata as $item)
                                            <option value="{{ $item->id }}">{{ $item->employee_code }} -
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">Attendance Date<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="attendance_date" id="add_attendance_date"
                                        class="form-control filter_date" placeholder="Select Date" required>
                                    <small class="text-errors"></small>

                                </div>


                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">Status<span class="text-danger">*</span>
                                    </label>

                                    <select name="status" id="add_attendance_status" class="form-select" required>
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="present">Present</option>
                                        <option value="half_day">Half Day </option>
                                        <option value="absent">Absent</option>
                                        <option value="leave">Leave</option>
                                    </select>
                                    <small class="text-errors"></small>
                                </div>


                                <div class="mb-3 col-md-6 form-field" id="add_check_in_field">

                                    <label class="form-label mb-1"> Check In
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="check_in" id="add_check_in" class="form-control timepicker"
                                        placeholder="HH:MM">
                                    <small class="text-errors"></small>

                                </div>



                                <div class="mb-3 col-md-6 form-field" id="add_check_out_field">
                                    <label class="form-label mb-1">
                                        Check Out
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="check_out" id="add_check_out" class="form-control timepicker"
                                        placeholder="HH:MM">
                                    <small class="text-errors"></small>

                                </div>


                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Remarks
                                    </label>
                                    <input type="text" name="remarks" id="add_remarks" class="form-control"
                                        placeholder="Enter Remarks">
                                    <small class="text-errors"></small>

                                </div>

                            </div>

                        </div>


                        <div class="modal-footer d-flex justify-content-center">

                            <button type="submit" class="btn btn-primary px-4 confirmSubmit" data-message="insert_confirm">

                                <i class="fa-solid fa-paper-plane me-2"></i>
                                Submit

                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>
 
    </div>

@endsection
@section('script')
    @include("layout.datatable")
    <script>


        function attendanceStatusChange() {
            let status = $('#add_attendance_status').val();
            if (status === 'present' || status === 'half_day') {

                $('#add_check_in_field').show();
                $('#add_check_out_field').show();

                $('#add_check_in').prop('required', true);
                $('#add_check_out').prop('required', true);

            } else {

                $('#add_check_in_field').hide();
                $('#add_check_out_field').hide();

                $('#add_check_in').prop('required', false);
                $('#add_check_out').prop('required', false);

                $('#add_check_in').val('');
                $('#add_check_out').val('');
            }
        }


        $(document).on('change', '#add_attendance_status', function () {

            attendanceStatusChange();

        });


        $(document).ready(function () {
            $('.filter_date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            });

            $('.timepicker').timepicker({
                timeFormat: 'g:i A',
                interval: 15,
                minTime: '12:00 AM',
                maxTime: '11:45 PM',
                startTime: '12:00 AM',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });

            attendanceStatusChange();

            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('attendance') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '5%'
                    },
                    {
                        data: 'get_employee.name',
                        name: 'get_employee.name',
                        className: 'text-center'
                    },
                    {
                        data: 'department',
                        name: 'department',
                        className: 'text-center'
                    },
                    {
                        data: 'designation',
                        name: 'designation',
                        className: 'text-center'
                    },
                    {
                        data: 'attendance_date',
                        name: 'attendance_date',
                        className: 'text-center'
                    },
                    {
                        data: 'check_in',
                        name: 'check_in',
                        className: 'text-center'
                    },
                    {
                        data: 'check_out',
                        name: 'check_out',
                        className: 'text-center'
                    },

                    {
                        data: 'working_hours',
                        name: 'working_hours',
                        className: 'text-center'
                    },

                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                    },
                    {
                        data: 'remarks',
                        name: 'remarks',
                        className: 'text-center',
                    },


                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        width: '5%'
                    }
                ]
            });

        });
    </script>
@endsection
