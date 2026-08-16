@extends('layout.default')

@section('content')
    <div class="container">

        <div class="card ">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-1">Salary Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">Salary Period</label>
                        <select id="filter_salary_period" name="filter_salary_period" class="form-select">
                            <option value=""> All Salary Period</option>
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
                        <label class="form-label mb-1">Employee</label>
                        <select id="filter_employee" name="filter_employee" class="form-select">
                            <option value=""> All Employees</option>
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
                        <label class="form-label mb-1">Salary Type </label>
                        <select id="filter_salary_type" name="filter_salary_type" class="form-select">
                            <option value="">All</option>
                            <option value="daily">Daily</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">Status</label>
                        <select id="filter_status" name="filter_status" class="form-select">
                            <option value=""> All Status </option>
                            @foreach ($status as $item)
                                <option value="{{ $item->status }}">
                                    {{ ucfirst($item->status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4  mb-3">
                        <label class="form-label mb-1">Start Date</label>
                        <input type="text" id="filter_start_date" class="form-control filter_date"
                            placeholder="Start Date">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label mb-1">End Date</label>
                        <input type="text" id="filter_end_date" class="form-control filter_date" placeholder="End Date">
                    </div>
                </div>

            </div>
            <div class="card-footer d-flex justify-content-center gap-2 bg-transparent">
                <button type="button" class="btn btn-primary" id="filter_btn">
                    <i class="fa-solid fa-filter me-1"></i> Show Filter
                </button>
                <button type="button" class="btn btn-secondary" id="reset_filter">
                    <i class="fa-solid fa-rotate-left me-1"></i> Reset
                </button>
            </div>
        </div>


        <div class="card mt-3">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-2">
                <h5 class="card-title mb-0">Salary Details</h5>
                <div class="d-flex align-items-center gap-2">
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger exportBtn" data-type="pdf">
                        <i class="fa-solid fa-file-pdf me-1"></i>Download PDF
                    </a>
                </div>
            </div>
            <div class="card-body table-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered ">
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
                                <th>Leave Days</th>
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
    @include('layout.dataTable')

    <script>
        $(document).ready(function() {

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
                    data: function(d) {
                        d.salary_period_id = $('#filter_salary_period').val();
                        d.employee_id = $('#filter_employee').val();
                        d.salary_type = $('#filter_salary_type').val();
                        d.status = $('#filter_status').val();
                        d.start_date = $('#filter_start_date').val();
                        d.end_date = $('#filter_end_date').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                    },
                    {
                        data: 'salary_period',
                        name: 'salary_period',
                        className: 'text-start'
                    },
                    {
                        data: 'employee',
                        name: 'employee',
                        className: 'text-start'
                    },
                    {
                        data: 'salary_type',
                        name: 'salary_type',
                        className: 'text-center',
                        render: function(data, type, row) {
                            return data ?
                                data.charAt(0).toUpperCase() + data.slice(1) :
                                '-';
                        }
                    },
                    {
                        data: 'base_salary',
                        name: 'base_salary',
                        className: 'text-end fw-semibold',
                        render: function(data, type, row) {
                            return parseFloat(data || 0).toFixed(2);
                        }
                    },
                    {
                        data: 'full_days',
                        name: 'full_days',
                        className: 'text-center',
                        render: function(data) {
                            return `
                                <span class="badge bg-success-subtle text-success px-2 py-1">
                                    ${parseFloat(data || 0).toFixed(0)}
                                </span>
                            `;
                        }
                    },
                    {
                        data: 'half_days',
                        name: 'half_days',
                        className: 'text-center',
                        render: function(data) {
                            return `
                                <span class="badge bg-warning-subtle text-warning px-2 py-1">
                                    ${parseFloat(data || 0).toFixed(0)}
                                </span>
                            `;
                        }
                    },
                    {
                        data: 'absent_days',
                        name: 'absent_days',
                        className: 'text-center',
                        render: function(data) {
                            return `
                                <span class="badge bg-danger-subtle text-danger px-2 py-1">
                                    ${parseFloat(data || 0).toFixed(0)}
                                </span>
                            `;
                        }
                    },
                    {
                        data: 'leave_days',
                        name: 'leave_days',
                        className: 'text-center',
                        render: function(data) {
                            return `
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
                                    ${parseFloat(data || 0).toFixed(0)}
                                </span>
                            `;
                        }
                    },
                    {
                        data: 'worked_days',
                        name: 'worked_days',
                        className: 'text-center',
                        render: function(data) {
                            return `
                                <span class="badge bg-primary-subtle text-primary px-2 py-1">
                                    ${parseFloat(data || 0).toFixed(0)}
                                </span>
                            `;
                        }
                    },
                    {
                        data: 'gross_salary',
                        name: 'gross_salary',
                        className: 'text-end fw-semibold',
                        render: function(data, type, row) {
                            return parseFloat(data || 0).toFixed(2);
                        }
                    },
                    {
                        data: 'deduction',
                        name: 'deduction',
                        className: 'text-end',
                        render: function(data, type, row) {
                            return parseFloat(data || 0).toFixed(2);
                        }
                    },
                    {
                        data: 'adjustment',
                        name: 'adjustment',
                        className: 'text-end',
                        render: function(data, type, row) {
                            return parseFloat(data || 0).toFixed(2);
                        }
                    },
                    {
                        data: 'net_salary',
                        name: 'net_salary',
                        className: 'text-end fw-semibold',
                        render: function(data, type, row) {
                            return parseFloat(data || 0).toFixed(2);
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data) {
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
                            return `
                                <span class="badge bg-secondary">
                                    ${data ?? '-'}
                                </span>
                            `;
                        }
                    }
                ],
                order: [
                    [0, 'desc']
                ]
            });
            $('#filter_btn').on('click', function(e) {
                e.preventDefault();
                table.ajax.reload(null, false);
            });
            $('#reset_filter').on('click', function() {
                $('#filter_salary_period').val('');
                $('#filter_employee').val('');
                $('#filter_salary_type').val('');
                $('#filter_status').val('');
                $('#filter_start_date').val('');
                $('#filter_end_date').val('');
                table.ajax.reload(null, false);
            });
        });

        $(document).on('click', '.exportBtn', function(e) {
            e.preventDefault();
            let type = $(this).data('type');
            let salary_period_id = $('#filter_salary_period').val();
            let employee_id = $('#filter_employee').val();
            let salary_type = $('#filter_salary_type').val();
            let status = $('#filter_status').val();
            let url = "{{ route('salary_details_export') }}";
            window.location.href =
                url +
                '?type=' + encodeURIComponent(type) +
                '&salary_period_id=' + encodeURIComponent(salary_period_id) +
                '&employee_id=' + encodeURIComponent(employee_id) +
                '&salary_type=' + encodeURIComponent(salary_type) +
                '&status=' + encodeURIComponent(status);
        });
    </script>
@endsection
