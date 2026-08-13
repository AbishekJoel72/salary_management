@extends('layout.default')
@section('content')
      <div class="container">

        <div class="card">
            <div class="card-header bg-transparent mt-2">
                <h5 class="card-title">Designation Filter</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label mb-1"> Department </label>

                        <select name="department" id="department" class="form-select">
                            <option value=""> All Department</option>
                            @foreach ($departmentdata as $item)
                                <option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label mb-1"> Designation </label>
                        <input type="text" name="designation" id="designation" class="form-control"
                            placeholder="Designation">
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
                <h5 class="card-title">Designation</h5>
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
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Designation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('designation') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>
                        @csrf
                        <input type="hidden" name="add_designation" value="true">
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">Department <span class="text-danger">*</span>
                                    </label>
                                    <select name="department" id="add_department" class="form-select">
                                        <option value="" disabled selected> All Department</option>
                                        @foreach ($departmentdata as $item)
                                            <option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }}</option>
                                        @endforeach

                                    </select>
                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">Designation <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="add_designation_name"
                                        name="designation_name" placeholder="Enter Designation " required>
                                    <small class="text-errors"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-4 confirmSubmit" data-message="insert_confirm">
                                <i class="fa-solid fa-paper-plane me-2"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Editmodel" tabindex="-1" aria-labelledby="EditmodelLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Designation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('designation') }}" method="POST" autocomplete="off" class="needs-validation"
                        novalidate>
                        @csrf
                        <input type="hidden" name="edit_designation" value="true">
                        <input type="hidden" name="id" id="edit_designation_id">
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">Department <span class="text-danger">*</span>
                                    </label>
                                    <select name="department" id="edit_department" class="form-select">
                                        <option value="" selected disabled> All Department</option>
                                        @foreach ($departmentdata as $item)
                                            <option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }}</option>
                                        @endforeach

                                    </select>
                                    <small class="text-errors"></small>
                                </div>

                                <div class="mb-3 col-md-6 form-field">
                                    <label class="form-label mb-1">Designation <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="edit_designation_name"
                                        name="designation_name" placeholder="Enter Designation " required>
                                    <small class="text-errors"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-4 confirmSubmit" data-message="update_confirm">
                                <i class="fa-solid fa-paper-plane me-2"></i> Update
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
                    <form action="{{ route('designation') }}" method="POST" autocomplete="off" class="needs-validation"
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
        $(document).ready(function () {
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('designation') }}",
                    data: function (d) {
                        d.department = $('#department').val();
                        d.designation = $('#designation').val();
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
                    data: 'department',
                    name: 'department',
                    className: 'text-center',
                },
                {
                    data: 'name',
                    name: 'name',
                    className: 'text-center',

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
                $('#department').val('');
                $('#designation').val('');
                table.ajax.reload();
            });


        });

        $(document).on('click', '.editRow', function () {

            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('designation') }}",
                type: "GET",

                data: {
                    id: id,
                    get_designation: true
                },

                dataType: "json",

                success: function (response) {

                    console.log(response);

                    $('#edit_designation_id').val(response.id);
                    $('#edit_department').val(response.department_id);
                    $('#edit_designation_name').val(response.name);

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
                url: "{{ route('designation') }}",
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
                    url: "{{ route('designation') }}",
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
