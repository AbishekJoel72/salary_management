@extends('layout.default')


<style>
    :root {
        --db-primary: #4f46e5;
        --db-primary-light: #eef2ff;
        --db-info: #0ea5e9;
        --db-info-light: #e0f2fe;
        --db-success: #16a34a;
        --db-success-light: #dcfce7;
        --db-warning: #d97706;
        --db-warning-light: #fef3c7;
        --db-danger: #dc2626;
        --db-danger-light: #fee2e2;
        --db-muted: #6b7280;
        --db-bg: #f8fafc;
        --db-radius: 14px;
    }

    .dashboard-wrap {
        background: var(--db-bg);
    }

    /* ---------- Header ---------- */
    .db-header {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 55%, #818cf8 100%);
        border-radius: var(--db-radius);
        padding: 22px 26px;
        color: #fff;
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.18);
    }

    .db-header h4 {
        font-weight: 700;
        letter-spacing: .2px;
    }

    .db-header small {
        color: rgba(255, 255, 255, 0.85) !important;
    }

    .db-header .badge {
        background: rgba(255, 255, 255, 0.18) !important;
        font-weight: 500;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: .8rem;
        backdrop-filter: blur(4px);
    }

    /* ---------- Generic card polish ---------- */
    .db-card {
        border: 1px solid #eef0f4;
        border-radius: var(--db-radius);
        transition: transform .15s ease, box-shadow .15s ease;
        background: #fff;
    }

    .db-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08) !important;
    }

    .db-card .card-header {
        border-bottom: 1px solid #f1f2f6;
        padding: 14px 18px;
        border-top-left-radius: var(--db-radius) !important;
        border-top-right-radius: var(--db-radius) !important;
    }

    .db-card .card-header h6 {
        font-weight: 700;
        color: #1f2430;
        letter-spacing: .2px;
    }

    .db-card .card-body {
        padding: 18px;
    }

    /* ---------- Stat cards (top row) ---------- */
    .stat-card .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }

    .stat-card .stat-label {
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 600;
        color: var(--db-muted) !important;
        margin-bottom: 4px;
    }

    .stat-card .stat-value {
        font-weight: 700;
        color: #111827;
    }

    .stat-card .stat-sub {
        font-weight: 500;
        font-size: .78rem;
    }

    .icon-primary { background: var(--db-primary-light); color: var(--db-primary); }
    .icon-info    { background: var(--db-info-light);    color: var(--db-info); }
    .icon-success { background: var(--db-success-light); color: var(--db-success); }
    .icon-warning { background: var(--db-warning-light); color: var(--db-warning); }

    /* ---------- Money summary cards ---------- */
    .money-card .money-label {
        text-transform: uppercase;
        font-size: .72rem;
        letter-spacing: .6px;
        font-weight: 700;
        color: var(--db-muted) !important;
    }

    .money-card .money-value {
        font-weight: 700;
        font-size: 1.35rem;
        margin-top: 4px;
    }

    .money-card {
        border-left: 4px solid var(--db-primary);
    }
    .money-card.money-danger  { border-left-color: var(--db-danger); }
    .money-card.money-primary { border-left-color: var(--db-primary); }
    .money-card.money-neutral { border-left-color: #94a3b8; }
    .money-card.money-success { border-left-color: var(--db-success); }

    /* ---------- Employee type / Attendance mini stats ---------- */
    .mini-stat h3, .mini-stat h5 {
        font-weight: 700;
        margin-bottom: 6px;
        color: #111827;
    }

    .mini-stat .badge {
        font-weight: 600;
        letter-spacing: .3px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: .72rem;
    }

    .divider-x {
        border-right: 1px solid #f1f2f6;
    }

    /* ---------- Salary period status strip ---------- */
    .status-strip h4 {
        font-weight: 700;
        color: #111827;
        margin-bottom: 6px;
    }

    .status-strip .badge {
        border-radius: 999px;
        padding: 6px 14px;
        font-weight: 600;
        letter-spacing: .3px;
        font-size: .72rem;
    }

    /* ---------- Tables ---------- */
    .db-card table.dataTable,
    .table-body table {
        border-collapse: separate !important;
        border-spacing: 0;
    }

    .table-body table thead th {
        background: #f8fafc;
        color: #475569;
        font-size: .76rem;
        text-transform: uppercase;
        letter-spacing: .4px;
        font-weight: 700;
        border-bottom: 2px solid #e5e7eb !important;
        white-space: nowrap;
    }

    .table-body table tbody td {
        vertical-align: middle;
        font-size: .875rem;
        color: #1f2937;
        border-color: #f1f2f6 !important;
    }

    .table-body table tbody tr:hover {
        background-color: #f8fafc;
    }

    .table-body .badge {
        border-radius: 999px;
        padding: 5px 12px;
        font-weight: 600;
        font-size: .7rem;
        letter-spacing: .3px;
    }

    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
    }
</style>


@section('content')
<div class="container-fluid dashboard-wrap py-2">

    <div class="db-header d-flex justify-content-between align-items-center mt-2 mb-4 flex-wrap gap-2">
        <div>
            <h4 class="mb-1">Dashboard</h4>
            <small>Payroll &amp; Employee Overview</small>
        </div>
        <div>
            <span class="badge">
                <i class="bi bi-calendar3 me-1"></i>{{ now()->format('d-m-Y') }}
            </span>
        </div>
    </div>


    <div class="row g-3">

        <div class="col-xl-3 col-md-6">
            <div class="card db-card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label mb-1">Departments</p>
                            <h3 class="stat-value mb-1">{{ $totalDepartments }}</h3>
                            <small class="stat-sub text-success">
                                <i class="bi bi-check-circle-fill me-1"></i>Active: {{ $activeDepartments }}
                            </small>
                        </div>
                        <div class="stat-icon icon-primary">
                            <i class="bi bi-building"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card db-card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label mb-1">Designations</p>
                            <h3 class="stat-value mb-1">{{ $totalDesignations }}</h3>
                            <small class="stat-sub text-success">
                                <i class="bi bi-check-circle-fill me-1"></i>Active: {{ $activeDesignations }}
                            </small>
                        </div>
                        <div class="stat-icon icon-info">
                            <i class="bi bi-person-badge"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card db-card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label mb-1">Employees</p>
                            <h3 class="stat-value mb-1">{{ $totalEmployees }}</h3>
                            <small class="stat-sub text-success">
                                <i class="bi bi-check-circle-fill me-1"></i>Active: {{ $activeEmployees }}
                            </small>
                        </div>
                        <div class="stat-icon icon-success">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card db-card stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stat-label mb-1">Salary Details</p>
                            <h3 class="stat-value mb-1">{{ $totalSalaryDetails }}</h3>
                            <small class="stat-sub text-primary">
                                <i class="bi bi-wallet2 me-1"></i>Paid: {{ $paidSalaryDetails }}
                            </small>
                        </div>
                        <div class="stat-icon icon-warning">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row g-3 mt-1">

        <div class="col-xl-6">
            <div class="card db-card shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0"><i class="bi bi-diagram-3 me-2 text-primary"></i>Employee Type</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center mini-stat">
                        <div class="col-6 divider-x">
                            <h3>{{ $dailyEmployees }}</h3>
                            <span class="badge bg-info">DAILY</span>
                        </div>
                        <div class="col-6">
                            <h3>{{ $monthlyEmployees }}</h3>
                            <span class="badge bg-primary">MONTHLY</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card db-card shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Attendance</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center mini-stat">
                        <div class="col divider-x">
                            <h5>{{ $presentAttendance }}</h5>
                            <span class="badge bg-success">PRESENT</span>
                        </div>
                        <div class="col divider-x">
                            <h5>{{ $halfDayAttendance }}</h5>
                            <span class="badge bg-warning">HALF DAY</span>
                        </div>
                        <div class="col divider-x">
                            <h5>{{ $absentAttendance }}</h5>
                            <span class="badge bg-danger">ABSENT</span>
                        </div>
                        <div class="col">
                            <h5>{{ $leaveAttendance }}</h5>
                            <span class="badge bg-info">LEAVE</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card db-card shadow-sm mt-3">
        <div class="card-header bg-transparent">
            <h6 class="mb-0"><i class="bi bi-bar-chart-steps me-2 text-primary"></i>Salary Period Status</h6>
        </div>
        <div class="card-body">
            <div class="row text-center status-strip">
                <div class="col">
                    <h4>{{ $totalSalaryPeriods }}</h4>
                    <span class="badge bg-secondary">TOTAL</span>
                </div>
                <div class="col">
                    <h4>{{ $draftSalaryPeriods }}</h4>
                    <span class="badge bg-secondary">DRAFT</span>
                </div>
                <div class="col">
                    <h4>{{ $calculatedSalaryPeriods }}</h4>
                    <span class="badge bg-info">CALCULATED</span>
                </div>
                <div class="col">
                    <h4>{{ $approvedSalaryPeriods }}</h4>
                    <span class="badge bg-warning">APPROVED</span>
                </div>
                <div class="col">
                    <h4>{{ $paidSalaryPeriods }}</h4>
                    <span class="badge bg-success">PAID</span>
                </div>
                <div class="col">
                    <h4>{{ $cancelledSalaryPeriods }}</h4>
                    <span class="badge bg-danger">CANCELLED</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">

        <div class="col-xl-3 col-md-6">
            <div class="card db-card money-card money-primary shadow-sm h-100">
                <div class="card-body">
                    <small class="money-label">Gross Salary</small>
                    <h4 class="money-value mb-0">₹ {{ number_format($totalGrossSalary, 2) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card db-card money-card money-danger shadow-sm h-100">
                <div class="card-body">
                    <small class="money-label">Deduction</small>
                    <h4 class="money-value mb-0 text-danger">₹ {{ number_format($totalDeduction, 2) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card db-card money-card money-neutral shadow-sm h-100">
                <div class="card-body">
                    <small class="money-label">Adjustment</small>
                    <h4 class="money-value mb-0">₹ {{ number_format($totalAdjustment, 2) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card db-card money-card money-success shadow-sm h-100">
                <div class="card-body">
                    <small class="money-label">Net Salary</small>
                    <h4 class="money-value mb-0 text-success">₹ {{ number_format($totalNetSalary, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>


    <div class="row g-3 mt-1">

        <div class="col-xl-6">
            <div class="card db-card shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0"><i class="bi bi-sun me-2 text-primary"></i>Daily Salary Summary</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Employees</small>
                            <h5>{{ $dailySalaryDetailsSummary->total ?? 0 }}</h5>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Net Salary</small>
                            <h5>₹ {{ number_format($dailySalaryDetailsSummary->net_salary ?? 0, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card db-card shadow-sm h-100">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0"><i class="bi bi-calendar3-range me-2 text-primary"></i>Monthly Salary Summary</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Employees</small>
                            <h5>{{ $monthlySalaryDetails->total ?? 0 }}</h5>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Net Salary</small>
                            <h5>₹ {{ number_format($monthlySalaryDetails->net_salary ?? 0, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- RECENT SALARY PERIODS --}}
    {{-- ========================================================= --}}
    <div class="card db-card shadow-sm mt-3">
        <div class="card-header bg-transparent">
            <h6 class="mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Salary Periods</h6>
        </div>
        <div class="card-body table-body">
            <div class="table-responsive">
                <table id="salaryPeriodsTable" class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Period Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Calculated</th>
                            <th>Approved</th>
                            <th>Paid</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- RECENT SALARY DETAILS --}}
    {{-- ========================================================= --}}
    <div class="card db-card shadow-sm mt-3">
        <div class="card-header bg-transparent">
            <h6 class="mb-0"><i class="bi bi-receipt me-2 text-primary"></i>Recent Salary Details</h6>
        </div>
        <div class="card-body table-body">
            <div class="table-responsive">
                <table id="salaryDetailsTable" class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Employee Code</th>
                            <th>Salary Type</th>
                            <th>Period</th>
                            <th>Full Days</th>
                            <th>Half Days</th>
                            <th>Absent</th>
                            <th>Gross</th>
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

    {{-- ========================================================= --}}
    {{-- RECENT EMPLOYEES --}}
    {{-- ========================================================= --}}
    <div class="card db-card shadow-sm mt-3 mb-4">
        <div class="card-header bg-transparent">
            <h6 class="mb-0"><i class="bi bi-people-fill me-2 text-primary"></i>Recent Employees</h6>
        </div>
        <div class="card-body table-body">
            <div class="table-responsive">
                <table id="recentEmployeesTable" class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee Code</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Type</th>
                            <th>Salary</th>
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

            /*
            |--------------------------------------------------------------------------
            | SALARY PERIODS
            |--------------------------------------------------------------------------
            */

            $('#salaryPeriodsTable').DataTable({

                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('dashboard') }}",
                    type: "GET",
                    data: {
                        type: "salary_periods"
                    }
                },

                pageLength: 10,

                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                searching: true,
                ordering: true,
                responsive: true,
                autoWidth: false,

                order: [
                    [0, 'desc']
                ],

                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },

                    {
                        data: 'period_type',
                        name: 'period_type',
                        className: 'text-center'
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
                        className: 'text-center'
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
                    }

                ]

            });


            /*
            |--------------------------------------------------------------------------
            | SALARY DETAILS
            |--------------------------------------------------------------------------
            */

            $('#salaryDetailsTable').DataTable({

                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('dashboard') }}",
                    type: "GET",
                    data: {
                        type: "salary_details"
                    }
                },

                pageLength: 10,

                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                searching: true,
                ordering: true,
                responsive: true,
                autoWidth: false,

                order: [
                    [0, 'desc']
                ],

                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },

                    {
                        data: 'employee_name',
                        name: 'employee_name'
                    },

                    {
                        data: 'employee_code',
                        name: 'employee_code'
                    },

                    {
                        data: 'salary_type',
                        name: 'salary_type',
                        className: 'text-center'
                    },

                    {
                        data: 'period',
                        name: 'period',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
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
                        className: 'text-end'
                    },

                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    }

                ]

            });


            /*
            |--------------------------------------------------------------------------
            | RECENT EMPLOYEES
            |--------------------------------------------------------------------------
            */

            $('#recentEmployeesTable').DataTable({

                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('dashboard') }}",
                    type: "GET",
                    data: {
                        type: "recent_employees"
                    }
                },

                pageLength: 10,

                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                searching: true,
                ordering: true,
                responsive: true,
                autoWidth: false,

                order: [
                    [0, 'desc']
                ],

                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },

                    {
                        data: 'employee_code',
                        name: 'employee_code'
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'department',
                        name: 'department',
                        orderable: false
                    },

                    {
                        data: 'designation',
                        name: 'designation',
                        orderable: false
                    },

                    {
                        data: 'employee_type',
                        name: 'employee_type',
                        className: 'text-center'
                    },

                    {
                        data: 'salary',
                        name: 'salary',
                        orderable: false,
                        searchable: false,
                        className: 'text-end'
                    },

                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    }

                ]

            });

        });
    </script>
@endsection
