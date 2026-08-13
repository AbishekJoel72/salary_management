@extends('layout.default')
@section('content')
      <div class="container">

        <div class="card">
            <div class="card-header bg-transparent mt-2">
                <h5 class="card-title">Employee Filter</h5>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">Department</label>

                        <select name="filter_department" id="filter_department" class="form-select">
                            <option value="">All Department</option>

                            @foreach ($departmentdata as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->code }} - {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">Designation</label>

                        <select name="filter_designation" id="filter_designation" class="form-select">
                            <option value="">All Designation</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">Employee Type</label>

                        <select name="filter_employee_type" id="filter_employee_type" class="form-select">
                            <option value="">All Employee Type</option>
                            <option value="daily">Daily</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">Employee Code</label>
                        <input type="text" name="filter_employee_code" id="filter_employee_code" class="form-control"
                            placeholder="Employee Code">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">Employee Name</label>
                        <input type="text" name="filter_employee_name" id="filter_employee_name" class="form-control"
                            placeholder="Employee Name">
                    </div>


                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">Status</label>

                        <select name="filter_status" id="filter_status" class="form-select">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="card-footer d-flex justify-content-center gap-2 bg-transparent">

                <button type="button" class="btn btn-primary" id="filterBtn">
                    <i class="fa-solid fa-filter"></i> Show Filter
                </button>

                <button type="reset" class="btn btn-secondary" id="resetBtn">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </button>

            </div>
        </div>


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
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Employee Code</th>
                                <th>Employee Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Salary Type</th>
                                <th>Daily</th>
                                <th>Monthly</th>
                                <th>Joining Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
 
        <div class="modal fade" id="Addmodel" tabindex="-1" aria-labelledby="AddmodelLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('employee') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>

                        @csrf

                        <input type="hidden" name="add_employee" value="true">

                        <div class="modal-body">
                            <div class="row">


                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">Department <span class="text-danger">*</span>
                                    </label>

                                    <select name="department_id" id="add_department" class="form-select" required>
                                        <option value="" disabled selected> Select Department</option>
                                        @foreach ($departmentdata as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->code }} - {{ $item->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                    <small class="text-errors"></small>
                                </div>



                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">Designation <span class="text-danger">*</span></label>
                                    <select name="designation_id" id="add_designation" class="form-select" required>
                                        <option value="" disabled selected>Select Designation</option>
                                    </select>
                                    <small class="text-errors"></small>
                                </div>



                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Employee Code <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" class="form-control" name="employee_code" id="add_employee_code"
                                        placeholder="Enter Employee Code" required>

                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Employee Name <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" class="form-control" name="name" id="add_name"
                                        placeholder="Enter Employee Name" required>

                                    <small class="text-errors"></small>
                                </div>



                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Email
                                    </label>

                                    <input type="email" class="form-control" name="email" id="add_email"
                                        placeholder="Enter Email">

                                    <small class="text-errors"></small>
                                </div>


                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Phone
                                    </label>

                                    <input type="text" class="form-control" name="phone" id="add_phone"
                                        placeholder="Enter Phone Number">

                                    <small class="text-errors"></small>
                                </div>



                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Employee Type <span class="text-danger">*</span>
                                    </label>

                                    <div class="d-flex gap-4 mt-2">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="employee_type" checked
                                                id="add_employee_type_daily" value="daily" required>

                                            <label class="form-check-label" for="add_employee_type_daily">
                                                Daily
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="employee_type"
                                                id="add_employee_type_monthly" value="monthly" required>

                                            <label class="form-check-label" for="add_employee_type_monthly">
                                                Monthly
                                            </label>
                                        </div>

                                    </div>

                                    <small class="text-errors"></small>
                                </div>



                                <div class="mb-3 col-md-6 form-field" id="daily_rate_field">

                                    <label class="form-label mb-1">
                                        Daily Rate
                                    </label>

                                    <input type="number" step="0.01" min="0" class="form-control" name="daily_rate"
                                        id="add_daily_rate" placeholder="Enter Daily Rate">

                                    <small class="text-errors"></small>
                                </div>


                                {{-- Monthly Salary --}}
                                <div class="mb-3 col-md-6 form-field" id="monthly_salary_field">

                                    <label class="form-label mb-1">
                                        Monthly Salary
                                    </label>

                                    <input type="number" step="0.01" min="0" class="form-control" name="monthly_salary"
                                        id="add_monthly_salary" placeholder="Enter Monthly Salary">

                                    <small class="text-errors"></small>
                                </div>


                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Joining Date
                                    </label>

                                    <input type="text" class="form-control filter_date" name="joining_date"
                                        id="add_joining_date" placeholder="Joining Date">

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

        <div class="modal fade" id="Editmodel" tabindex="-1" aria-labelledby="EditmodelLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('employee') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>

                        @csrf

                        <input type="hidden" name="edit_employee" value="true">
                        <input type="hidden" id="edit_employee_id" name="id">

                        <div class="modal-body">
                            <div class="row">


                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">Department <span class="text-danger">*</span>
                                    </label>

                                    <select name="department_id" id="edit_department" class="form-select" required>
                                        <option value="" disabled selected> Select Department</option>
                                        @foreach ($departmentdata as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->code }} - {{ $item->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                    <small class="text-errors"></small>
                                </div>



                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">Designation <span class="text-danger">*</span></label>

                                    <select name="designation_id" id="edit_designation" class="form-select" required>
                                        <option value="" disabled selected>Select Designation</option>
                                        @foreach ($designationdata as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                    <small class="text-errors"></small>
                                </div>



                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Employee Code <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" class="form-control" name="employee_code" id="edit_employee_code"
                                        placeholder="Enter Employee Code" required>

                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Employee Name <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" class="form-control" name="name" id="edit_name"
                                        placeholder="Enter Employee Name" required>

                                    <small class="text-errors"></small>
                                </div>



                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Email
                                    </label>

                                    <input type="email" class="form-control" name="email" id="edit_email"
                                        placeholder="Enter Email">

                                    <small class="text-errors"></small>
                                </div>


                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Phone
                                    </label>

                                    <input type="text" class="form-control" name="phone" id="edit_phone"
                                        placeholder="Enter Phone Number">

                                    <small class="text-errors"></small>
                                </div>



                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Employee Type <span class="text-danger">*</span>
                                    </label>

                                    <div class="d-flex gap-4 mt-2">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="employee_type"
                                                id="edit_employee_type_daily" value="daily" required checked>

                                            <label class="form-check-label" for="edit_employee_type_daily">
                                                Daily
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="employee_type"
                                                id="edit_employee_type_monthly" value="monthly" required>

                                            <label class="form-check-label" for="edit_employee_type_monthly">
                                                Monthly
                                            </label>
                                        </div>

                                    </div>

                                    <small class="text-errors"></small>
                                </div>



                                <div class="mb-3 col-md-6 form-field" id="edit_daily_rate_field">

                                    <label class="form-label mb-1">
                                        Daily Rate
                                    </label>

                                    <input type="number" step="0.01" min="0" class="form-control" name="daily_rate"
                                        id="edit_daily_rate" placeholder="Enter Daily Rate">

                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-6 form-field" id="edit_monthly_salary_field">

                                    <label class="form-label mb-1">
                                        Monthly Salary
                                    </label>

                                    <input type="number" step="0.01" min="0" class="form-control" name="monthly_salary"
                                        id="edit_monthly_salary" placeholder="Enter Monthly Salary">

                                    <small class="text-errors"></small>
                                </div>


                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Joining Date
                                    </label>

                                    <input type="text" class="form-control filter_date" name="joining_date"
                                        id="edit_joining_date" placeholder="Joining Date">

                                    <small class="text-errors"></small>
                                </div>



                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-4 confirmSubmit" data-message="update_confirm">

                                <i class="fa-solid fa-paper-plane me-2"></i>
                                Update

                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="Editstatusmodel" tabindex="-1" aria-labelledby="EditstatusmodelLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('employee') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>
                        @csrf
                        <input type="hidden" name="edit_status" value="true">
                        <input type="hidden" id="edit_status_id" name="id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label d-block fw-bold">Status</label>
                                    <div class="form-check form-check-inline mt-2">
                                        <input type="radio" class="form-check-input" id="edit_active" value="1"
                                            name="status">
                                        <label for="edit_active" class="form-check-label ">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input type="radio" class="form-check-input" id="edit_inactive" value="0"
                                            name="status">
                                        <label for="edit_inactive" class="form-check-label">In Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-4 confirmSubmit" data-message="update_state">
                                <i class="fa-solid fa-paper-plane me-2"></i> Update
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

        function employeeTypeChange() {
            let type = $('#Addmodel input[name="employee_type"]:checked').val();
            if (type === 'daily') {

                $('#daily_rate_field').show();
                $('#monthly_salary_field').hide();

                $('#add_daily_rate').prop('required', true);
                $('#add_monthly_salary').prop('required', false);

                $('#add_monthly_salary').val('');

            } else if (type === 'monthly') {

                $('#daily_rate_field').hide();
                $('#monthly_salary_field').show();

                $('#add_daily_rate').prop('required', false);
                $('#add_monthly_salary').prop('required', true);

                $('#add_daily_rate').val('');

            } else {

                $('#daily_rate_field').hide();
                $('#monthly_salary_field').hide();

                $('#add_daily_rate').prop('required', false);
                $('#add_monthly_salary').prop('required', false);
            }
        }



        $(document).on(
            'change',
            '#Addmodel input[name="employee_type"]',
            function () {
                employeeTypeChange();
            }
        );


        $(document).ready(function () {

            $('.filter_date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            });

            employeeTypeChange();

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('employee') }}",
                    data: function (d) {
                        d.department = $('#filter_department').val();
                        d.designation = $('#filter_designation').val();
                        d.employee_type = $('#filter_employee_type').val();
                        d.employee_code = $('#filter_employee_code').val();
                        d.employee_name = $('#filter_employee_name').val();
                        d.status = $('#filter_status').val();
                    }
                },

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
                        data: 'department',
                        name: 'department',
                        className: 'text-center'
                    },
                    {
                        data: 'get_designation.name',
                        name: 'get_designation.name',
                        className: 'text-center'
                    },
                    {
                        data: 'employee_code',
                        name: 'employee_code',
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'text-center'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: 'text-center'
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        className: 'text-center'
                    },
                    {
                        data: 'employee_type',
                        name: 'employee_type',
                        className: 'text-center',
                        render: function (data, type, row) {
                            if (data === 'daily') {
                                return '<span class="badge bg-info">Daily</span>';
                            }
                            if (data === 'monthly') {
                                return '<span class="badge bg-primary">Monthly</span>';
                            }
                            return '-';
                        }
                    },

                    {
                        data: 'daily_rate',
                        name: 'daily_rate',
                        className: 'text-center',

                        render: function (data, type, row) {

                            return data !== null &&
                                data !== undefined &&
                                data !== ''
                                ? data
                                : '-';
                        }
                    },
                    {
                        data: 'monthly_salary',
                        name: 'monthly_salary',
                        className: 'text-center',

                        render: function (data, type, row) {

                            return data !== null &&
                                data !== undefined &&
                                data !== ''
                                ? data
                                : '-';
                        }
                    },
                    {
                        data: 'joining_date',
                        name: 'joining_date',
                        className: 'text-center',
                        render: function (data, type, row) {

                            if (!data) {
                                return '-';
                            }

                            let date = new Date(data);

                            let day = String(date.getDate()).padStart(2, '0');
                            let month = String(date.getMonth() + 1).padStart(2, '0');
                            let year = date.getFullYear();

                            return day + '-' + month + '-' + year;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == 1) {
                                return '<span class="badge bg-success">Active</span>';
                            } else {
                                return '<span class="badge bg-danger">Inactive</span>';
                            }
                        }
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

            $('#filterBtn').click(function (e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#resetBtn').click(function () {
                $('#filter_department').val('');
                $('#filter_designation').html(
                    '<option value="">All Designation</option>'
                );
                $('#filter_employee_type').val('');
                $('#filter_employee_code').val('');
                $('#filter_employee_name').val('');
                $('#filter_status').val('');
                table.ajax.reload();
            });

        });

        $(document).on('change', '#add_department', function () {
            let departmentId = $(this).val();
            let designation = $('#add_designation');
            designation.html(
                '<option value="" disabled selected>Loading...</option>'
            );

            if (!departmentId) {
                designation.html(
                    '<option value="" disabled selected>Select Designation</option>'
                );
                return;
            }

            $.ajax({
                url: "{{ route('employee') }}",
                type: "GET",
                data: {
                    departmentId: departmentId,
                    get_designation_data: true
                },
                dataType: "json",
                success: function (response) {
                    designation.empty();
                    designation.append(
                        '<option value="" disabled selected>Select Designation</option>'
                    );
                    if (response.length > 0) {
                        $.each(response, function (key, item) {
                            designation.append(
                                '<option value="' + item.id + '">' + item.name + '</option>'
                            );
                        });
                    } else {
                        designation.append(
                            '<option value="" disabled>No Designation Found</option>'
                        );
                    }
                },

                error: function (xhr) {
                    console.log(xhr.responseText);
                    designation.html(
                        '<option value="" disabled selected>Unable to load designation</option>'
                    );
                }
            });
        });

        $(document).on('change', '#filter_department', function () {
            let departmentId = $(this).val();
            let designation = $('#filter_designation');
            designation.html(
                '<option value="">Loading...</option>'
            );
            if (!departmentId) {
                designation.html(
                    '<option value="">All Designation</option>'
                );
                return;
            }

            $.ajax({
                url: "{{ route('employee') }}",
                type: "GET",
                data: {
                    departmentId: departmentId,
                    get_designation_data: true
                },
                dataType: "json",
                success: function (response) {
                    designation.empty();
                    designation.append(
                        '<option value="">All Designation</option>'
                    );

                    if (response.length > 0) {
                        $.each(response, function (key, item) {
                            designation.append('<option value="' + item.id + '">' + item.name + '</option>');
                        });
                    } else {
                        designation.append(
                            '<option value="">No Designation Found</option>'
                        );
                    }
                },

                error: function (xhr) {
                    console.log(xhr.responseText);

                    designation.html(
                        '<option value="">Unable to load designation</option>'
                    );

                }

            });

        });

        
        function loadEditDesignations(departmentId, designationId = null) {
            let designation = $('#edit_designation');
            designation.html(
                '<option value="" disabled selected>Loading...</option>'
            );

            if (!departmentId) {
                designation.html(
                    '<option value="" disabled selected>Select Designation</option>'
                );
                return;
            }

            $.ajax({
                url: "{{ route('employee') }}",
                type: "GET",
                data: {
                    departmentId: departmentId,
                    get_designation_data: true
                },
                dataType: "json",
                success: function (response) {
                    designation.empty();
                    designation.append(
                        '<option value="" disabled>Select Designation</option>'
                    );

                    if (response.length > 0) {
                        $.each(response, function (key, item) {
                            designation.append(
                                '<option value="' + item.id + '">' + item.name + '</option>'
                            );

                        });
                        if (designationId) {
                            designation.val(designationId);
                        }
                    } else {
                        designation.append(
                            '<option value="" disabled selected>No Designation Found</option>'
                        );
                    }
                },

                error: function (xhr) {
                    console.log(xhr.responseText);
                    designation.html(
                        '<option value="" disabled selected>Unable to load designation</option>'
                    );
                }
            });
        }

        function editEmployeeTypeChange() {
            let type = $('#Editmodel input[name="employee_type"]:checked').val();
            if (type === 'daily') {
                $('#edit_daily_rate_field').show();
                $('#edit_monthly_salary_field').hide();

                $('#edit_daily_rate').prop('required', true);
                $('#edit_monthly_salary').prop('required', false);

            } else if (type === 'monthly') {
                $('#edit_daily_rate_field').hide();
                $('#edit_monthly_salary_field').show();

                $('#edit_daily_rate').prop('required', false);
                $('#edit_monthly_salary').prop('required', true);

            } else {

                $('#edit_daily_rate_field').hide();
                $('#edit_monthly_salary_field').hide();

                $('#edit_daily_rate').prop('required', false);
                $('#edit_monthly_salary').prop('required', false);
            }
        }

        $(document).on(
            'change',
            '#Editmodel input[name="employee_type"]',
            function () {
                editEmployeeTypeChange();
            }
        );


        $(document).on('change', '#edit_department', function () {
            let departmentId = $(this).val();
            loadEditDesignations(departmentId);
        });

        $(document).on('click', '.editRow', function () {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('employee') }}",
                type: "GET",
                data: {
                    id: id,
                    get_employee: true
                },
                dataType: "json",
                success: function (response) {
                    $('#edit_employee_id').val(response.id);
                    $('#edit_department').val(response.department_id);
                    $('#edit_designation').val(response.designation_id);
                    loadEditDesignations(
                        response.department_id,
                        response.designation_id
                    );

                    $('#edit_employee_code').val(response.employee_code);
                    $('#edit_name').val(response.name);
                    $('#edit_email').val(response.email);
                    $('#edit_phone').val(response.phone);

                    $('#Editmodel input[name="employee_type"]')
                        .prop('checked', false);

                    $('#Editmodel #edit_employee_type_' + response.employee_type)
                        .prop('checked', true);


                    $('#edit_daily_rate').val(response.daily_rate);
                    $('#edit_monthly_salary').val(response.monthly_salary);

                    if (response.joining_date) {
                        let dateParts = response.joining_date.split('-');

                        let formattedDate =
                            dateParts[2] + '-' +
                            dateParts[1] + '-' +
                            dateParts[0];

                        $('#edit_joining_date').val(formattedDate);
                    } else {
                        $('#edit_joining_date').val('');
                    }

                    editEmployeeTypeChange();

                    $('#Editmodel').modal('show');
                },

                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $(document).on('click', '.editStatusRow', function () {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('employee') }}",
                type: 'GET',
                data: {
                    id: id,
                    get_status: true
                },
                dataType: 'json',
                success: function (response) {

                    $('#edit_status_id').val(response.id);
                    if (response.status == 1) {
                        $('#edit_active').prop('checked', true);
                    } else {
                        $('#edit_inactive').prop('checked', true);
                    }

                    $('#Editstatusmodel').modal('show');
                },
                error: function () {
                    console.log(xhr.responseText);
                }
            });

        });


        $(document).on('click', '.deleteRow', function () {
            let id = $(this).data('id');
            confirmAction(messages.delete_confirm, function () {
                $.ajax({
                    url: "{{ route('employee') }}",
                    type: 'GET',
                    data: {
                        id: id,
                        get_delete: true
                    },
                    dataType: 'json',
                    success: function (response) {
                        $('#datatable').DataTable().ajax.reload(null, false);
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#4f46e5',
                            allowOutsideClick: false,
                            width: '350px',
                            customClass: {
                                title: 'session-title',
                            }
                        })
                    },

                    error: function (xhr) {
                        let message = "Something went wrong!";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            title: 'Error',
                            text: message,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#4f46e5',
                            allowOutsideClick: false,
                            width: '350px',
                            customClass: {
                                title: 'session-title',
                            }
                        });
                    }
                });
            });
        });

    </script>
@endsection
