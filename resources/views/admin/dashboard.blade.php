@extends('layout.default')


<style>
    .dashboard-wrap {
        background: var(--bg-body);
    }

    .db-header {
        background: linear-gradient(135deg,
                var(--primary-color) 0%,
                var(--primary-hover) 55%,
                var(--primary-color) 100%);
        border-radius: var(--radius-lg);
        padding: 22px 26px;
        color: var(--white);
        box-shadow: var(--shadow-lg);
    }

    .db-header small {
        color: rgba(255, 255, 255, 0.85) !important;
    }

    .db-header .badge {
        background: rgba(255, 255, 255, 0.18) !important;
        color: var(--white);
        font-weight: 500;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: .8rem;
        backdrop-filter: blur(4px);
    }

    /* card design */
    .db-card {
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        transition: transform .15s ease, box-shadow .15s ease;
        background: var(--bg-card);
    }

    .db-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg) !important;
    }

    .db-card .card-header {
        border-bottom: 1px solid var(--border-color);
        padding: 14px 18px;
        border-top-left-radius: var(--radius-lg) !important;
        border-top-right-radius: var(--radius-lg) !important;
    }

    .db-card .card-header h6 {
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: .2px;
    }

    .db-card .card-body {
        padding: 18px;
    }

    /* stat card design */
    .stat-card .stat-label {
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 600;
        color: var(--text-secondary) !important;
        margin-bottom: 4px;
    }

    .stat-card .stat-value {
        font-weight: 700;
        color: var(--text-primary);
    }

    .icon-primary {
        background: var(--primary-light);
        color: var(--primary-color);
    }

    .icon-info {
        background: var(--info-light);
        color: var(--info-color);
    }

    .icon-success {
        background: var(--success-light);
        color: var(--success-color);
    }

    .icon-warning {
        background: var(--warning-light);
        color: var(--warning-color);
    }

    /* money card design */
    .money-card .money-label {
        text-transform: uppercase;
        font-size: .72rem;
        letter-spacing: .6px;
        font-weight: 700;
        color: var(--text-secondary) !important;
    }

    .money-card .money-value {
        font-weight: 700;
        font-size: 1.35rem;
        margin-top: 4px;
        color: var(--text-primary);
    }

    .money-card {
        border-left: 4px solid var(--primary-color);
    }

    .money-card.money-danger {
        border-left-color: var(--danger-color);
    }

    .money-card.money-primary {
        border-left-color: var(--primary-color);
    }

    .money-card.money-neutral {
        border-left-color: var(--text-muted);
    }

    .money-card.money-success {
        border-left-color: var(--success-color);
    }


    /* divider */
    .divider-x {
        border-right: 1px solid var(--border-color);
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
                                <span class="badge bg-info-subtle text-info px-2 py-1">
                                    Daily
                                </span>
                            </div>
                            <div class="col-6">
                                <h3>{{ $monthlyEmployees }}</h3>
                                <span class="badge bg-primary-subtle text-primary px-2 py-1">
                                    Monthly
                                </span>
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
                                <span class="badge bg-success-subtle text-success px-2 py-1">Present</span>
                            </div>
                            <div class="col divider-x">
                                <h5>{{ $halfDayAttendance }}</h5>
                                <span class="badge bg-warning-subtle text-warning px-2 py-1"> Half Day</span>
                            </div>
                            <div class="col divider-x">
                                <h5>{{ $absentAttendance }}</h5>
                                <span class="badge bg-danger-subtle text-danger px-2 py-1"> Absent</span>
                            </div>
                            <div class="col">
                                <h5>{{ $leaveAttendance }}</h5>
                                <span class="badge bg-info-subtle text-info px-2 py-1"> Leave</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card db-card shadow-sm mt-3">
            <div class="card-header bg-transparent">
                <h6 class="mb-0">
                    <i class="bi bi-bar-chart-steps me-2 text-primary"></i>
                    Salary Period Status
                </h6>
            </div>

            <div class="card-body">
                <div class="row text-center status-strip">

                    <div class="col">
                        <h4>{{ $totalSalaryPeriods }}</h4>
                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
                            Total
                        </span>
                    </div>

                    <div class="col">
                        <h4>{{ $draftSalaryPeriods }}</h4>
                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
                             Draft
                        </span>
                    </div>

                    <div class="col">
                        <h4>{{ $calculatedSalaryPeriods }}</h4>
                        <span class="badge bg-info-subtle text-info px-2 py-1">
                             Calculated
                        </span>
                    </div>

                    <div class="col">
                        <h4>{{ $approvedSalaryPeriods }}</h4>
                        <span class="badge bg-warning-subtle text-warning px-2 py-1">
                             Approved
                        </span>
                    </div>

                    <div class="col">
                        <h4>{{ $paidSalaryPeriods }}</h4>
                        <span class="badge bg-success-subtle text-success px-2 py-1">
                             Paid
                        </span>
                    </div>

                    <div class="col">
                        <h4>{{ $cancelledSalaryPeriods }}</h4>
                        <span class="badge bg-danger-subtle text-danger px-2 py-1">
                             Cancelled
                        </span>
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
                        <h6 class="mb-0"><i class="bi bi-calendar3-range me-2 text-primary"></i>Monthly Salary Summary
                        </h6>
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
                    <table id="salaryPeriodsTable" class="table table-bordered ">
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
                                <th>Cancelled</th>
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
                                <th>Salary Type</th>
                                <th>Period</th>
                                <th>Full Days</th>
                                <th>Half Days</th>
                                <th>Absent</th>
                                <th>Leave</th>
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
                                <th>Employee</th>
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
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'period_type',
                        name: 'period_type',
                        className: 'text-center',
                        render: function(data, type, row) {
                            if (data === 'weekly') {
                                return `
                                    <span class="badge bg-info-subtle text-info px-2 py-1">
                                        WEEKLY
                                    </span>
                                `;
                            }
                            if (data === 'monthly') {
                                return `
                                    <span class="badge bg-primary-subtle text-primary px-2 py-1">
                                        MONTHLY
                                    </span>
                                `;
                            }
                            return `
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
                                    -
                                </span>
                            `;
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

                            return `${day}-${month}-${year}`;
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

                            return `${day}-${month}-${year}`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        render: function(data, type, row) {
                            const badges = {
                                draft: 'dark',
                                calculated: 'secondary',
                                approved: 'warning',
                                paid: 'success',
                                cancelled: 'danger'
                            };
                            const badge = badges[data] || 'secondary';
                            return `
                                <span class="badge bg-${badge}-subtle text-${badge} px-2 py-1">
                                    ${(data || '-').toUpperCase()}
                                </span>
                            `;
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
                        data: 'employee',
                        name: 'employee'
                    },
                    {
                        data: 'salary_type',
                        name: 'salary_type',
                        className: 'text-center',
                        render: function(data, type, row) {

                            if (data === 'daily') {
                                return `
                                    <span class="badge bg-info-subtle text-info px-2 py-1">
                                        DAILY
                                    </span>
                                `;
                            }
                            if (data === 'monthly') {
                                return `
                                    <span class="badge bg-primary-subtle text-primary px-2 py-1">
                                        MONTHLY
                                    </span>
                                `;
                            }
                            return `
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
                                    -
                                </span>
                            `;
                        }
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
                        className: 'text-center',
                        render: function(data, type, row) {
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
                        render: function(data, type, row) {
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
                        render: function(data, type, row) {
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
                        render: function(data, type, row) {
                            return `
                                <span class="badge bg-info-subtle text-info px-2 py-1">
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
                            return '₹ ' + Number(data || 0).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
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
                        className: 'text-end fw-semibold',
                        render: function(data, type, row) {
                            return '₹ ' + Number(data || 0).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    },

                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        render: function(data, type, row) {

                            const badges = {
                                calculated: 'secondary',
                                approved: 'warning',
                                paid: 'success',
                                cancelled: 'danger'
                            };

                            const badge = badges[data] || 'secondary';

                            return `
                                <span class="badge bg-${badge}-subtle text-${badge} px-2 py-1">
                                    ${(data || '-').toUpperCase()}
                                </span>
                            `;
                        }
                    },

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
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },

                    {
                        data: 'employee',
                        name: 'employee'
                    },

                    {
                        data: 'get_department.name',
                        name: 'get_department.name',
                        orderable: false
                    },

                    {
                        data: 'get_designation.name',
                        name: 'get_designation.name',
                        orderable: false
                    },

                    {
                        data: 'employee_type',
                        name: 'employee_type',
                        className: 'text-center',
                        render: function(data, type, row) {

                            if (data === 'daily') {
                                return `
                                    <span class="badge bg-info-subtle text-info px-2 py-1">
                                        DAILY
                                    </span>
                                `;
                            }

                            if (data === 'monthly') {
                                return `
                                    <span class="badge bg-primary-subtle text-primary px-2 py-1">
                                        MONTHLY
                                    </span>
                                `;
                            }

                            return `
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
                                    -
                                </span>
                            `;
                        }
                    },

                    {
                        data: 'salary',
                        name: 'salary',
                        orderable: false,
                        searchable: false,
                        className: 'text-end',
                        render: function(data, type, row) {

                            let salary = 0;
                            let label = '';

                            if (row.employee_type === 'daily') {
                                salary = row.daily_rate || 0;
                                label = '- Day';
                            } else if (row.employee_type === 'monthly') {
                                salary = row.monthly_salary || 0;
                                label = '- Month';
                            }

                            return '₹ ' + Number(salary).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + ' ' + label;
                        }
                    },

                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {

                            if (data == 1) {
                                return `
                                <span class="badge bg-success-subtle text-success px-2 py-1">
                                    Active
                                </span>
                            `;
                            }

                            return `
                                <span class="badge bg-danger-subtle text-danger px-2 py-1">
                                    In Active
                                </span>
                            `;
                        }
                    },

                ]

            });

        });
    </script>
@endsection
