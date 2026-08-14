@extends('layout.default')

@section('content')

    <div class="container">

        {{-- Filter Card --}}
        <div class="card mt-3">

            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0">
                    Salary Details
                </h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">
                            Salary Period
                        </label>
                        <select id="filter_salary_period" class="form-select">

                            <option value="">
                                All Salary Period
                            </option>

                            @foreach ($salaryperioddata as $item)

                                <option value="{{ $item->id }}">

                                    {{ ucfirst($item->period_type) }}
                                    -
                                    {{ \Carbon\Carbon::parse($item->start_date)->format('d-m-Y') }}
                                    to
                                    {{ \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">
                            Employee
                        </label>
                        <select id="filter_employee" class="form-select">
                            <option value="">
                                All Employees
                            </option>
                            @foreach ($employeedata as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->employee_code }}
                                    -
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">
                            Salary Type
                        </label>
                        <select id="filter_salary_type" class="form-select">
                            <option value="">
                                All
                            </option>
                            <option value="daily">
                                Daily
                            </option>
                            <option value="monthly">
                                Monthly
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">
                            Status
                        </label>
                        <select id="filter_status" class="form-select">
                            <option value="">
                                All Status
                            </option>
                            <option value="pending">
                                Pending
                            </option>
                            <option value="calculated">
                                Calculated
                            </option>
                            <option value="approved">
                                Approved
                            </option>
                            <option value="paid">
                                Paid
                            </option>
                        </select>
                    </div>


                    <div class="col-md-4  mb-3">
                        <label class="form-label mb-1">
                            Start Date
                        </label>
                        <input type="text" id="filter_start_date" class="form-control filter_date" placeholder="Start Date">
                    </div>


                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">
                            End Date
                        </label>
                        <input type="text" id="filter_end_date" class="form-control filter_date" placeholder="End Date">
                    </div>

                </div>


                <div class="d-flex justify-content-center gap-2 mt-3">

                    <button type="button" class="btn btn-primary" id="filter_btn">

                        <i class="fa-solid fa-filter me-1"></i>
                        Filter

                    </button>


                    <button type="button" class="btn btn-secondary" id="reset_filter">

                        <i class="fa-solid fa-rotate-left me-1"></i>
                        Reset

                    </button>

                </div>

            </div>

        </div>


        {{-- Salary Details --}}
        <div class="card mt-3">

            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-2">

                <h5 class="card-title mb-0">
                    Salary Details
                </h5>

            </div>


            <div class="card-body table-body">

                <div class="table-responsive">

                    <table id="datatable" class="table table-bordered">

                        <thead>

                            <tr>

                                <th>S.No</th>
                                <th>Salary Period</th>
                                <th>Employee</th>
                                <th>Salary Type</th>
                                <th>Base Salary</th>
                                <th>Full Days</th>
                                <th>Half Days</th>
                                <th>Absent Days</th>
                                <th>Worked Days</th>
                                <th>Gross Salary</th>
                                <th>Deduction</th>
                                <th>Adjustment</th>
                                <th>Net Salary</th>
                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('script')

    @include("layout.dataTable")

    <script>
        $(document).ready(function () {

            $('.filter_date').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            });


            let table = $('#datatable').DataTable({

                processing: true,

                serverSide: true,

                ajax: {

                    url: "{{ route('salary_details') }}",

                    type: "GET",

                    data: function (d) {

                        d.get_salary_details = true;

                        d.salary_period_id =
                            $('#filter_salary_period').val();

                        d.employee_id =
                            $('#filter_employee').val();

                        d.salary_type =
                            $('#filter_salary_type').val();

                        d.status =
                            $('#filter_status').val();

                        d.start_date =
                            $('#filter_start_date').val();

                        d.end_date =
                            $('#filter_end_date').val();

                    }

                },


                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },

                    {
                        data: 'salary_period',
                        name: 'salary_period',
                        className: 'text-center'
                    },

                    {
                        data: 'employee',
                        name: 'employee',
                        className: 'text-start'
                    },

                    {
                        data: 'salary_type',
                        name: 'salary_type',
                        className: 'text-center'
                    },

                    {
                        data: 'base_salary',
                        name: 'base_salary',
                        className: 'text-end'
                    },

                    {
                        data: 'full_days',
                        name: 'full_days',
                        className: 'text-center'
                    },

                    {
                        data: 'half_days',
                        name: 'half_days',
                        className: 'text-center'
                    },

                    {
                        data: 'absent_days',
                        name: 'absent_days',
                        className: 'text-center'
                    },

                    {
                        data: 'worked_days',
                        name: 'worked_days',
                        className: 'text-center'
                    },

                    {
                        data: 'gross_salary',
                        name: 'gross_salary',
                        className: 'text-end'
                    },

                    {
                        data: 'deduction',
                        name: 'deduction',
                        className: 'text-end'
                    },

                    {
                        data: 'adjustment',
                        name: 'adjustment',
                        className: 'text-end'
                    },

                    {
                        data: 'net_salary',
                        name: 'net_salary',
                        className: 'text-end fw-semibold'
                    },

                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',

                        render: function (data) {

                            if (data === 'calculated') {
                                return '<span class="badge bg-info">Calculated</span>';
                            }

                            if (data === 'approved') {
                                return '<span class="badge bg-success">Approved</span>';
                            }

                            if (data === 'paid') {
                                return '<span class="badge bg-primary">Paid</span>';
                            }

                            if (data === 'pending') {
                                return '<span class="badge bg-warning">Pending</span>';
                            }

                            return '<span class="badge bg-secondary">' +
                                (data ?? '-') +
                                '</span>';
                        }

                    }

                ],

                order: [
                    [0, 'desc']
                ]

            });


            // Filter
            $('#filter_btn').on('click', function () {

                table.ajax.reload(null, false);

            });


            // Reset
            $('#reset_filter').on('click', function () {

                $('#filter_salary_period').val('');
                $('#filter_employee').val('');
                $('#filter_salary_type').val('');
                $('#filter_status').val('');
                $('#filter_start_date').val('');
                $('#filter_end_date').val('');

                table.ajax.reload(null, false);

            });

        });
    </script>

@endsection
