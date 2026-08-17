@extends('layout.default')
@section('content')
    <div class="container">

        <div class="card ">
            <div class="card-header bg-transparent">
                <h6 class="mb-1 card-title">Salary Period Filter</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label mb-1">Period Type</label>
                        <select id="filter_period_type" class="form-select">
                            <option value="">All Period Type</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label mb-1">Start Date</label>
                        <input type="text" id="filter_start_date" class="form-control filter_date"
                            placeholder="Select Start Date">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label mb-1">End Date</label>
                        <input type="text" id="filter_end_date" class="form-control filter_date"
                            placeholder="Select End Date">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label mb-1">Status</label>
                        <select id="filter_status" class="form-select">
                            <option value="">All Status</option>
                            <option value="draft">Draft</option>
                            <option value="calculated">Calculated</option>
                            <option value="approved">Approved</option>
                            <option value="paid">Paid</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center gap-2 bg-transparent">
                <button type="button" class="btn btn-primary" id="filter_btn">
                    <i class="fa-solid fa-filter me-1"></i>
                    Show Filter
                </button>
                <button type="button" class="btn btn-secondary" id="reset_filter">
                    <i class="fa-solid fa-rotate-left me-1"></i>
                    Reset
                </button>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-2">
                <h5 class="card-title mb-0">Salary Period</h5>

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
                                <th>Cancelled At</th>
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
                                <div class="mb-3 col-md-4 form-field">
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

                                <div class="mb-3 col-md-4 form-field">
                                    <label class="form-label mb-1">Start Date<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="start_date" id="add_start_date"
                                        class="form-control filter_date" placeholder="Select Start Date" required>
                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-4 form-field">
                                    <label class="form-label mb-1">
                                        End Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="end_date" id="add_end_date"
                                        class="form-control filter_date" placeholder="Select End Date" required>
                                    <small class="text-errors"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-4 confirmSubmit"
                                data-message="insert_confirm">
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
                        <h5 class="modal-title">
                            Edit Salary Period
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <form action="{{ route('salary_period') }}" method="POST" autocomplete="off"
                        class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="edit_salary_period" value="true">
                        <input type="hidden" name="id" id="edit_salary_period_id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-4 form-field">
                                    <label class="form-label mb-1">
                                        Period Type <span class="text-danger">*</span>
                                    </label>
                                    <select name="period_type" id="edit_period_type" class="form-select" required>
                                        <option value="" disabled selected>Select Period Type</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly"> Monthly</option>
                                    </select>
                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-4 form-field">
                                    <label class="form-label mb-1">
                                        Start Date<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="start_date" id="edit_start_date"
                                        class="form-control filter_date" placeholder="Select Start Date" required>
                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-4 form-field">
                                    <label class="form-label mb-1">
                                        End Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="end_date" id="edit_end_date"
                                        class="form-control filter_date" placeholder="Select End Date" required>
                                    <small class="text-errors"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-4 confirmSubmit"
                                data-message="update_confirm">
                                <i class="fa-solid fa-paper-plane me-2"></i>
                                Update
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
                            <div class="col-md-6 mb-3">
                                <label class="form-label ">Period Type</label>
                                <div class="form-control bg-light d-flex align-items-center justify-content-start"
                                    id="view_period_type">
                                    -
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label ">Start Date</label>
                                <div class="form-control bg-light d-flex align-items-center justify-content-start"
                                    id="view_start_date">
                                    -
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label ">End Date</label>
                                <div class="form-control bg-light d-flex align-items-center justify-content-start"
                                    id="view_end_date">
                                    -
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label ">Status</label>
                                <div class="form-control bg-light d-flex align-items-center justify-content-start"
                                    id="view_status">
                                    -
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label ">Calculated At</label>
                                <div class="form-control bg-light d-flex align-items-center justify-content-start"
                                    id="view_calculated_at">
                                    -
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label ">Approved At</label>
                                <div class="form-control bg-light d-flex align-items-center justify-content-start"
                                    id="view_approved_at">
                                    -
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label ">Paid At</label>
                                <div class="form-control bg-light d-flex align-items-center justify-content-start"
                                    id="view_paid_at">
                                    -
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label ">Cancelled At</label>
                                <div class="form-control bg-light d-flex align-items-center justify-content-start"
                                    id="view_cancelled_at">
                                    -
                                </div>
                            </div>

                        </div>
                    </div>
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
                    url: "{{ route('salary_period') }}",
                    type: "GET",

                    data: function(d) {

                        d.period_type = $('#filter_period_type').val();
                        d.start_date = $('#filter_start_date').val();
                        d.end_date = $('#filter_end_date').val();
                        d.status = $('#filter_status').val();
                    }
                },
                columns: [{
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
                        render: function(data, type, row) {

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
                        className: 'text-center',
                        render: function(data, type, row) {
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
                        data: 'end_date',
                        name: 'end_date',
                        className: 'text-center',
                        render: function(data, type, row) {
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
                        render: function(data, type, row) {
                            if (data == 'draft') {
                                return '<span class="badge bg-secondary-subtle text-secondary">Draft</span>';
                            } else if (data == 'calculated') {
                                return '<span class="badge bg-info-subtle text-info">Calculated</span>';
                            } else if (data == 'approved') {
                                return '<span class="badge bg-success-subtle text-success">Approved</span>';
                            } else if (data == 'paid') {
                                return '<span class="badge bg-primary-subtle text-primary">Paid</span>';
                            } else if (data == 'cancelled') {
                                return '<span class="badge bg-danger-subtle text-danger">Cancelled</span>';
                            } else {
                                return '<span class="badge bg-dark-subtle text-dark">Unknown</span>';
                            }
                        }
                    },
                    {
                        data: 'calculated_at',
                        name: 'calculated_at',
                        className: 'text-center',
                        render: function(data, type, row) {
                            if (!data) {
                                return '-';
                            }

                            let date = data.replace('T', ' ').split('.')[0];

                            let parts = date.split(' ');
                            let datePart = parts[0];
                            let timePart = parts[1];

                            let dateParts = datePart.split('-');
                            let timeParts = timePart.split(':');

                            let day = dateParts[2];
                            let month = dateParts[1];
                            let year = dateParts[0];

                            let hours = parseInt(timeParts[0]);
                            let minutes = timeParts[1];

                            let ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12;
                            hours = hours ? hours : 12;

                            return `${day}-${month}-${year} - ${String(hours).padStart(2, '0')}:${minutes} ${ampm}`;
                        }
                    },
                    {
                        data: 'approved_at',
                        name: 'approved_at',
                        className: 'text-center',
                        render: function(data, type, row) {
                            if (!data) {
                                return '-';
                            }

                            let date = new Date(data);

                            let day = String(date.getDate()).padStart(2, '0');
                            let month = String(date.getMonth() + 1).padStart(2, '0');
                            let year = date.getFullYear();

                            let hours = date.getHours();
                            let minutes = String(date.getMinutes()).padStart(2, '0');

                            let ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12;
                            hours = hours ? hours : 12;

                            return `${day}-${month}-${year} - ${String(hours).padStart(2, '0')}:${minutes} ${ampm}`;
                        }
                    },
                    {
                        data: 'paid_at',
                        name: 'paid_at',
                        className: 'text-center',
                        render: function(data, type, row) {
                            if (!data) {
                                return '-';
                            }

                            let date = new Date(data);

                            let day = String(date.getDate()).padStart(2, '0');
                            let month = String(date.getMonth() + 1).padStart(2, '0');
                            let year = date.getFullYear();

                            let hours = date.getHours();
                            let minutes = String(date.getMinutes()).padStart(2, '0');

                            let ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12;
                            hours = hours ? hours : 12;

                            return `${day}-${month}-${year} - ${String(hours).padStart(2, '0')}:${minutes} ${ampm}`;
                        }
                    },
                    {
                        data: 'cancelled_at',
                        name: 'cancelled_at',
                        className: 'text-center',
                        render: function(data, type, row) {
                            if (!data) {
                                return '-';
                            }

                            let date = new Date(data);

                            let day = String(date.getDate()).padStart(2, '0');
                            let month = String(date.getMonth() + 1).padStart(2, '0');
                            let year = date.getFullYear();

                            let hours = date.getHours();
                            let minutes = String(date.getMinutes()).padStart(2, '0');

                            let ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12;
                            hours = hours ? hours : 12;

                            return `${day}-${month}-${year} - ${String(hours).padStart(2, '0')}:${minutes} ${ampm}`;
                        }
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
            $('#filter_btn').on('click', function() {
                table.ajax.reload();
            });

            $('#reset_filter').on('click', function() {
                $('#filter_period_type').val('');
                $('#filter_start_date').val('');
                $('#filter_end_date').val('');
                $('#filter_status').val('');
                table.ajax.reload();
            });

        });

        function formatDate(date) {
            let d = new Date(date);
            if (isNaN(d.getTime())) {
                return date;
            }
            let day = String(d.getDate()).padStart(2, '0');
            let month = String(d.getMonth() + 1).padStart(2, '0');
            let year = d.getFullYear();
            return day + '-' + month + '-' + year;
        }

        function formatDateTime(dateTime) {
            let d = new Date(dateTime);
            if (isNaN(d.getTime())) {
                return dateTime;
            }

            let day = String(d.getDate()).padStart(2, '0');
            let month = String(d.getMonth() + 1).padStart(2, '0');
            let year = d.getFullYear();

            let hours = d.getHours();
            let minutes = String(d.getMinutes()).padStart(2, '0');

            let ampm = hours >= 12 ? 'PM' : 'AM';

            hours = hours % 12;
            hours = hours ? hours : 12;

            return day + '-' + month + '-' + year +
                ' - ' +
                hours + ':' + minutes + ' ' + ampm;
        }

        $(document).on('click', '.View', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('salary_period') }}",
                type: "GET",
                data: {
                    id: id,
                    view_data: true,
                },
                success: function(response) {
                    $('#view_period_type').text(
                        response.period_type ?
                        response.period_type.charAt(0).toUpperCase() +
                        response.period_type.slice(1) :
                        '-'
                    );
                    $('#view_start_date').text(
                        response.start_date ?
                        formatDate(response.start_date) :
                        '-'
                    );
                    $('#view_end_date').text(
                        response.end_date ?
                        formatDate(response.end_date) :
                        '-'
                    );
                    let status = response.status ?
                        response.status.toLowerCase() :
                        '';
                    let statusBadge = '';
                    switch (response.status.toLowerCase()) {
                        case 'draft':
                            statusBadge =
                                '<span class="badge bg-secondary-subtle text-secondary px-2 py-1">' +
                                'Draft' +
                                '</span>';
                            break;
                        case 'calculated':
                            statusBadge =
                                '<span class="badge bg-info-subtle text-info px-2 py-1">' +
                                'Calculated' +
                                '</span>';
                            break;
                        case 'approved':
                            statusBadge =
                                '<span class="badge bg-success-subtle text-success px-2 py-1">' +
                                'Approved' +
                                '</span>';
                            break;
                        case 'paid':
                            statusBadge =
                                '<span class="badge bg-primary-subtle text-primary px-2 py-1">' +
                                'Paid' +
                                '</span>';
                            break;
                        case 'cancelled':
                            statusBadge =
                                '<span class="badge bg-danger-subtle text-danger px-2 py-1">' +
                                'Cancelled' +
                                '</span>';
                            break;
                        default:
                            statusBadge = '-';
                    }
                    $('#view_status').html(statusBadge);
                    $('#view_calculated_at').text(
                        response.calculated_at ?
                        formatDateTime(response.calculated_at) :
                        '-'
                    );
                    $('#view_approved_at').text(
                        response.approved_at ?
                        formatDateTime(response.approved_at) :
                        '-'
                    );
                    $('#view_paid_at').text(
                        response.paid_at ?
                        formatDateTime(response.paid_at) :
                        '-'
                    );
                    $('#view_cancelled_at').text(
                        response.cancelled_at ?
                        formatDateTime(response.cancelled_at) :
                        '-'
                    );
                    $('#Viewmodel').modal('show');

                },

                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        $(document).on('click', '.editRow', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "{{ route('salary_period') }}",
                type: "GET",
                data: {
                    id: id,
                    edit_data: true,
                },
                success: function(response) {
                    $('#edit_salary_period_id').val(response.id);
                    $('#edit_period_type').val(response.period_type);
                    let startDate = response.start_date.split('-');
                    let endDate = response.end_date.split('-');
                    $('#edit_start_date').val(
                        startDate[2] + '-' + startDate[1] + '-' + startDate[0]
                    );
                    $('#edit_end_date').val(
                        endDate[2] + '-' + endDate[1] + '-' + endDate[0]
                    );
                    $('#Editmodel').modal('show');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });


        $(document).on('click', '.calculateRow', function() {
            let id = $(this).data('id');
            confirmAction(messages.calculate_confirm, function() {
                $.ajax({
                    url: "{{ route('salary_period') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        calculate_salary_period: true
                    },
                    success: function(response) {
                        if (response.status === true) {
                            $('#datatable').DataTable().ajax.reload(null, false);
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#4f46e5',
                                allowOutsideClick: false,
                                width: '350px',
                                customClass: {
                                    title: 'session-title'
                                }
                            });

                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#4f46e5',
                                allowOutsideClick: false,
                                width: '350px',
                                customClass: {
                                    title: 'session-title'
                                }
                            });
                        }
                    },

                    error: function(xhr) {
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
                                title: 'session-title'
                            }
                        });
                    }
                });
            });
        });


        $(document).on('click', '.approveRow', function() {
            let id = $(this).data('id');
            confirmAction(messages.approve_confirm, function() {
                $.ajax({
                    url: "{{ route('salary_period') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        approve_salary_period: true
                    },
                    success: function(response) {
                        if (response.status === true) {
                            $('#datatable').DataTable().ajax.reload(null, false);
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#4f46e5',
                                allowOutsideClick: false,
                                width: '350px',
                                customClass: {
                                    title: 'session-title'
                                }
                            });

                        } else {

                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#4f46e5',
                                allowOutsideClick: false,
                                width: '350px',
                                customClass: {
                                    title: 'session-title'
                                }
                            });
                        }
                    },

                    error: function(xhr) {
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
                                title: 'session-title'
                            }
                        });
                    }
                });

            });
        });


        $(document).on('click', '.payRow', function() {
            let id = $(this).data('id');
            confirmAction(messages.pay_confirm, function() {
                $.ajax({
                    url: "{{ route('salary_period') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        pay_salary_period: true
                    },
                    success: function(response) {
                        if (response.status === true) {
                            $('#datatable').DataTable().ajax.reload(null, false);
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#4f46e5',
                                allowOutsideClick: false,
                                width: '350px',
                                customClass: {
                                    title: 'session-title'
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#4f46e5',
                                allowOutsideClick: false,
                                width: '350px',
                                customClass: {
                                    title: 'session-title'
                                }
                            });
                        }
                    },
                    error: function(xhr) {
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
                                title: 'session-title'
                            }
                        });
                    }
                });

            });
        });


        $(document).on('click', '.cancelRow', function() {
            let id = $(this).data('id');
            confirmAction(messages.cancel_confirm, function() {
                $.ajax({
                    url: "{{ route('salary_period') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        cancel_salary_period: true
                    },
                    success: function(response) {
                        if (response.status === true) {
                            $('#datatable').DataTable().ajax.reload(null, false);
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#4f46e5',
                                allowOutsideClick: false,
                                width: '350px',
                                customClass: {
                                    title: 'session-title'
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#4f46e5',
                                allowOutsideClick: false,
                                width: '350px',
                                customClass: {
                                    title: 'session-title'
                                }
                            });
                        }
                    },
                    error: function(xhr) {
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
                                title: 'session-title'
                            }
                        });
                    }
                });

            });
        });


        $(document).on('click', '.deleteRow', function() {
            let id = $(this).data('id');
            confirmAction(messages.delete_confirm, function() {
                $.ajax({
                    url: "{{ route('salary_period') }}",
                    type: 'GET',
                    data: {
                        id: id,
                        get_delete: true
                    },
                    dataType: 'json',
                    success: function(response) {
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

                    error: function(xhr) {
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
