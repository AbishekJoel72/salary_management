@extends('layout.default')
@section('content')
      <div class="container">
        <div class="card ">
            <div class="card-header bg-transparent">
                <h6 class="mb-0">Filter</h6>
            </div>

            <div class="card-body">
                <div class="row">

                    {{-- Period Type --}}
                    <div class="col-md-3 form-field">
                        <label class="form-label mb-1">Period Type</label>

                        <select id="filter_period_type" class="form-select">
                            <option value="">All Period Type</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>

                        <small class="text-errors"></small>
                    </div>

                    {{-- Start Date --}}
                    <div class="col-md-3 form-field">
                        <label class="form-label mb-1">Start Date</label>

                        <input type="text" id="filter_start_date" class="form-control filter_date"
                            placeholder="Select Start Date">

                        <small class="text-errors"></small>
                    </div>

                    {{-- End Date --}}
                    <div class="col-md-3 form-field">
                        <label class="form-label mb-1">End Date</label>

                        <input type="text" id="filter_end_date" class="form-control filter_date"
                            placeholder="Select End Date">

                        <small class="text-errors"></small>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3 form-field">
                        <label class="form-label mb-1">Status</label>

                        <select id="filter_status" class="form-select">
                            <option value="">All Status</option>
                            <option value="draft">Draft</option>
                            <option value="calculated">Calculated</option>
                            <option value="approved">Approved</option>
                            <option value="paid">Paid</option>
                            <option value="cancelled">Cancelled</option>
                        </select>

                        <small class="text-errors"></small>
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

        <div class="card mt-3">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-2">
                <h5 class="card-title mb-0">Salary Periods</h5>

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
                                <th>Period Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Calculated At</th>
                                <th>Approved At</th>
                                <th>Paid At</th>
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
                        <h5 class="modal-title">Add Salary Period</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>


                    <form action="{{ route('salary_period') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>
                        @csrf
                        <input type="hidden" name="add_salary_period" value="true">

                        <div class="modal-body">
                            <div class="row">

                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">Period Type<span class="text-danger">*</span>
                                    </label>

                                    <select name="period_type" id="add_period_type" class="form-select" required>
                                        <option value="" disabled selected>
                                            Select Period Type
                                        </option>
                                        <option value="weekly"> Weekly</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                    <small class="text-errors"></small>
                                </div>


                                <!-- Start Date -->
                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        Start Date
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="start_date" id="add_start_date"
                                        class="form-control filter_date" placeholder="Select Start Date" required>

                                    <small class="text-errors"></small>

                                </div>


                                <!-- End Date -->
                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">
                                        End Date<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="end_date" id="add_end_date" class="form-control filter_date"
                                        placeholder="Select End Date" required>
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

        <div class="modal fade" id="Viewmodel" tabindex="-1" aria-labelledby="ViewmodelLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="ViewmodelLabel">
                            Salary Period Details
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <!-- Period Type -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Period Type
                                </label>

                                <div class="form-control bg-light" id="view_period_type">
                                    -
                                </div>
                            </div>


                            <!-- Start Date -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Start Date
                                </label>

                                <div class="form-control bg-light" id="view_start_date">
                                    -
                                </div>
                            </div>


                            <!-- End Date -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    End Date
                                </label>

                                <div class="form-control bg-light" id="view_end_date">
                                    -
                                </div>
                            </div>


                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Status
                                </label>

                                <div class="form-control bg-light" id="view_status">
                                    -
                                </div>
                            </div>


                            <!-- Approved At -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Approved At
                                </label>

                                <div class="form-control bg-light" id="view_approved_at">
                                    -
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="modal-footer d-flex justify-content-center">

                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            Close
                        </button>

                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="Editmodel" tabindex="-1" aria-labelledby="EditmodelLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="EditmodelLabel">
                            Edit Salary Period
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>

                    </div>


                    <form action="{{ route('salary_period') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>

                        @csrf

                        <input type="hidden" name="edit_salary_period" value="true">

                        <input type="hidden" name="edit_salary_period_id" id="edit_salary_period_id">


                        <div class="modal-body">

                            <div class="row">

                                <!-- Period Type -->
                                <div class="mb-3 col-md-6 form-field">

                                    <label class="form-label mb-1">
                                        Period Type
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select name="period_type" id="edit_period_type" class="form-select" required>

                                        <option value="" disabled>
                                            Select Period Type
                                        </option>

                                        <option value="weekly">
                                            Weekly
                                        </option>

                                        <option value="monthly">
                                            Monthly
                                        </option>

                                    </select>

                                    <small class="text-errors"></small>

                                </div>


                                <!-- Start Date -->
                                <div class="mb-3 col-md-6 form-field">

                                    <label class="form-label mb-1">
                                        Start Date
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="start_date" id="edit_start_date"
                                        class="form-control filter_date" placeholder="Select Start Date" required>

                                    <small class="text-errors"></small>

                                </div>


                                <!-- End Date -->
                                <div class="mb-3 col-md-6 form-field">

                                    <label class="form-label mb-1">
                                        End Date
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="end_date" id="edit_end_date" class="form-control filter_date"
                                        placeholder="Select End Date" required>

                                    <small class="text-errors"></small>

                                </div>


                                <!-- Status -->
                                <div class="mb-3 col-md-6 form-field">

                                    <label class="form-label mb-1">
                                        Status
                                    </label>

                                    <input type="text" id="edit_status_display" class="form-control" readonly>

                                    <input type="hidden" name="status" id="edit_status">

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
                    url: "{{ route('salary_period') }}",
                    type: "GET",

                    data: function (d) {

                        d.period_type = $('#filter_period_type').val();
                        d.start_date = $('#filter_start_date').val();
                        d.end_date = $('#filter_end_date').val();
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
                        data: 'period_type',
                        name: 'period_type',
                        className: 'text-center',
                        render: function (data, type, row) {

                            if (data === 'weekly') {
                                return '<span class="badge bg-info">WEEKLY</span>';
                            }

                            if (data === 'monthly') {
                                return '<span class="badge bg-primary">MONTHLY</span>';
                            }

                            return '-';
                        }
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                        className: 'text-center'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (data == 'draft') {
                                return '<span class="badge bg-secondary">Draft</span>';
                            } else if (data == 'calculated') {
                                return '<span class="badge bg-info">Calculated</span>';
                            } else if (data == 'approved') {
                                return '<span class="badge bg-success">Approved</span>';
                            } else if (data == 'paid') {
                                return '<span class="badge bg-primary">Paid</span>';
                            } else if (data == 'cancelled') {
                                return '<span class="badge bg-danger">Cancelled</span>';
                            } else {
                                return '<span class="badge bg-dark">Unknown</span>';
                            }
                        }
                    },
                    {
                        data: 'calculated_at',
                        name: 'calculated_at',
                        className: 'text-center'
                    },
                    {
                        data: 'approved_at',
                        name: 'approved_at',
                        className: 'text-center'
                    },
                    {
                        data: 'paid_at',
                        name: 'paid_at',
                        className: 'text-center'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '5%'
                    }
                ],
                order: [
                    [1, 'desc']
                ]
            });
            $('#filter_btn').on('click', function () {
                table.ajax.reload();
            });

            $('#reset_filter').on('click', function () {
                $('#filter_period_type').val('');
                $('#filter_start_date').val('');
                $('#filter_end_date').val('');
                $('#filter_status').val('');
                table.ajax.reload();
            });

        });

        $(document).on('click', '.View', function () {

            let id = $(this).data('id');

            $.ajax({

                url: "{{ route('salary_period') }}",

                type: "GET",

                data: {
                    id: id,
                    view_data: true,
                },

                success: function (response) {

                    if (response.status === true) {

                        let data = response.data;

                        $('#view_period_type').text(data.period_type);

                        $('#view_start_date').text(data.start_date);

                        $('#view_end_date').text(data.end_date);

                        // Status
                        let statusBadge = '';

                        switch (data.status.toLowerCase()) {

                            case 'draft':
                                statusBadge = '<span class="badge bg-secondary">Draft</span>';
                                break;

                            case 'calculated':
                                statusBadge = '<span class="badge bg-info">Calculated</span>';
                                break;

                            case 'approved':
                                statusBadge = '<span class="badge bg-success">Approved</span>';
                                break;

                            case 'paid':
                                statusBadge = '<span class="badge bg-primary">Paid</span>';
                                break;

                            case 'cancelled':
                                statusBadge = '<span class="badge bg-danger">Cancelled</span>';
                                break;

                            default:
                                statusBadge = '<span class="badge bg-secondary">' +
                                    data.status +
                                    '</span>';
                        }

                        $('#view_status').html(statusBadge);

                        $('#view_approved_at').text(data.approved_at);

                        $('#Viewmodel').modal('show');

                    } else {

                        alert(response.message ?? 'Salary period not found.');

                    }
                },

                error: function (xhr) {

                    console.log(xhr.responseText);

                    alert('Something went wrong.');

                }

            });

        });

        $(document).on('click', '.editRow', function () {

            let id = $(this).data('id');

            $.ajax({

                url: "{{ route('salary_period') }}",

                type: "GET",

                data: {
                    id: id,
                    edit_data: true,
                },

                success: function (response) {

                    if (response.status === true) {

                        let data = response.data;

                        // ID
                        $('#edit_salary_period_id').val(data.id);

                        // Period Type
                        $('#edit_period_type').val(data.period_type);

                        // Start Date
                        $('#edit_start_date').val(data.start_date);

                        // End Date
                        $('#edit_end_date').val(data.end_date);

                        // Status
                        $('#edit_status').val(data.status);

                        $('#edit_status_display').val(
                            data.status.charAt(0).toUpperCase() +
                            data.status.slice(1)
                        );

                        // Show Modal
                        $('#Editmodel').modal('show');

                    } else {

                        alert(response.message ?? 'Salary period not found.');

                    }

                },

                error: function (xhr) {

                    console.log(xhr.responseText);

                    alert('Something went wrong.');

                }

            });

        });

        $(document).on('click', '.calculateRow', function () {

            let id = $(this).data('id');

            if (!confirm('Are you sure you want to calculate this salary period?')) {
                return;
            }

            $.ajax({

                url: "{{ route('salary_period') }}",

                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    calculate_salary_period: true
                },

                success: function (response) {

                    if (response.status === true) {

                        alert(response.message);

                        $('#datatable').DataTable().ajax.reload(null, false);

                    } else {

                        alert(response.message);

                    }

                },

                error: function (xhr) {

                    console.log(xhr.responseText);

                    alert('Something went wrong.');

                }

            });

        });

        $(document).on('click', '.approveRow', function () {

            let id = $(this).data('id');

            if (!confirm('Are you sure you want to approve this salary period?')) {
                return;
            }

            $.ajax({

                url: "{{ route('salary_period') }}",

                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    approve_salary_period: true
                },

                success: function (response) {

                    if (response.status === true) {

                        alert(response.message);

                        $('#datatable').DataTable().ajax.reload(null, false);

                    } else {

                        alert(response.message);

                    }

                },

                error: function (xhr) {

                    console.log(xhr.responseText);

                    alert('Something went wrong.');

                }

            });

        });

        $(document).on('click', '.payRow', function () {

            let id = $(this).data('id');

            if (!confirm('Are you sure you want to mark this salary period as Paid?')) {
                return;
            }

            $.ajax({

                url: "{{ route('salary_period') }}",

                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    pay_salary_period: true
                },

                success: function (response) {

                    if (response.status === true) {

                        alert(response.message);

                        $('#datatable').DataTable().ajax.reload(null, false);

                    } else {

                        alert(response.message);
                    }
                },

                error: function (xhr) {

                    console.log(xhr.responseText);

                    alert('Something went wrong.');
                }
            });

        });

        $(document).on('click', '.deleteRow', function () {
            let id = $(this).data('id');
            confirmAction(messages.delete_confirm, function () {
                $.ajax({
                    url: "{{ route('salary_period') }}",
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
