@extends('layout.default')
@section('content')
    <div class="container">

        <div class="card mt-3">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-1">Salary Payment Filter</h5>
            </div>

            <div class="card-body">
                <div class="row align-items-end">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Employee</label>
                        <select class="form-select" id="filter_employee" name="filter_employee">
                            <option value="">All Employees</option>

                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->employee_code }} - {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Department</label>
                        <select class="form-select" id="filter_department" name="filter_department">
                            <option value="">All Departments</option>

                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Designation</label>
                        <select class="form-select" id="filter_designation" name="filter_designation">
                            <option value="">All Designations</option>

                            @foreach ($designations as $designation)
                                <option value="{{ $designation->id }}">
                                    {{ $designation->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label fw-semibold">Payment Date From</label>
                        <input type="text" class="form-control filter_date" id="filter_payment_date_from"
                            placeholder="Select From Date" name="filter_payment_date_from">
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label fw-semibold">Payment Date To</label>
                        <input type="text" class="form-control filter_date" id="filter_payment_date_to"
                            placeholder="Select To Date" name="filter_payment_date_to">
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
                <h5 class="card-title mb-0">Salary Payment</h5>
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
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Net Salary</th>
                                <th>Status</th>
                                <th>Payment Date</th>
                                <th>Payment Amount</th>
                                <th>Payment Method</th>
                                <th>Transaction </th>
                                <th>Remarks</th>
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

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('salary_payment') }}",
                    data: function(d) {
                        d.filter_employee = $('#filter_employee').val();
                        d.filter_department = $('#filter_department').val();
                        d.filter_designation = $('#filter_designation').val();
                        d.filter_payment_date_from = $('#filter_payment_date_from').val();
                        d.filter_payment_date_to = $('#filter_payment_date_to').val();
                    }
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'employee',
                        name: 'employee',
                        className: 'text-center',

                    },
                    {
                        data: 'department',
                        name: 'department',
                        className: 'text-center',

                    },
                    {
                        data: 'designation',
                        name: 'designation',
                        className: 'text-center',

                    },
                    {
                        data: 'get_salarydetail.net_salary',
                        name: 'get_salarydetail.net_salary',
                        className: 'text-center fw-semibold',
                        render: function(data) {
                            if (!data) {
                                return '-';
                            }

                            return parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        data: 'get_salarydetail.status',
                        name: 'get_salarydetail.status',
                        className: 'text-center',
                        render: function(data) {
                            if (!data) {
                                return '-';
                            }

                            if (data == 'calculated') {
                                return '<span class="badge bg-info-subtle text-info">Calculated</span>';
                            } else if (data == 'approved') {
                                return '<span class="badge bg-success-subtle text-success">Approved</span>';
                            } else if (data == 'paid') {
                                return '<span class="badge bg-primary-subtle text-primary">Paid</span>';
                            } else if (data == 'cancelled') {
                                return '<span class="badge bg-danger-subtle text-danger">Cancelled</span>';
                            } else {
                                return '<span class="badge bg-secondary-subtle text-secondary">' +
                                    data +
                                    '</span>';
                            }
                        }
                    },
                    {
                        data: 'payment_date',
                        name: 'payment_date',
                        className: 'text-center',
                        render: function(data) {
                            if (!data) {
                                return '-';
                            }

                            let date = new Date(data);

                            let day = String(date.getDate()).padStart(2, '0');
                            let month = String(date.getMonth() + 1).padStart(2, '0');
                            let year = date.getFullYear();

                            return `${day}-${month}-${year}`;
                        }
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        className: 'text-center fw-semibold',
                        render: function(data) {
                            if (!data) {
                                return '-';
                            }

                            return parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method',
                        className: 'text-center',
                        render: function(data) {
                            if (!data) {
                                return '-';
                            }

                            if (data == 'cash') {
                                return '<span class="badge bg-success-subtle text-success">Cash</span>';
                            } else if (data == 'bank_transfer') {
                                return '<span class="badge bg-primary-subtle text-primary">Bank Transfer</span>';
                            } else if (data == 'upi') {
                                return '<span class="badge bg-info-subtle text-info">UPI</span>';
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'transaction_reference',
                        name: 'transaction_reference',
                        className: 'text-center',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'remarks',
                        name: 'remarks',
                        className: 'text-center',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    }
                ]
            });
            $('#filterBtn').click(function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#resetBtn').click(function() {
                $('#filter_employee').val('');
                $('#filter_department').val('');
                $('#filter_designation').val('')
                $('#filter_payment_date_from').val('');
                $('#filter_payment_date_to').val('');
                table.ajax.reload();
            });
        });


        $(document).on('click', '.exportBtn', function(e) {
            e.preventDefault();
            let type = $(this).data('type');
            let employee = $('#filter_employee').val();
            let department = $('#filter_department').val();
            let designation = $('#filter_designation').val();
            let payment_date_from = $('#filter_payment_date_from').val();
            let payment_date_to = $('#filter_payment_date_to').val();
            let url = "{{ route('salary_payment_export') }}";
            window.location.href =
                url +
                '?type=' + encodeURIComponent(type) +
                '&employee=' + encodeURIComponent(employee) +
                '&department=' + encodeURIComponent(department) +
                '&designation=' + encodeURIComponent(designation) +
                '&payment_date_from=' + encodeURIComponent(payment_date_from) +
                '&payment_date_to=' + encodeURIComponent(payment_date_to);
        });
    </script>
@endsection
