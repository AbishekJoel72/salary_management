<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Salary Payment</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 25px 20px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            color: #222;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header h2 {
            margin: 0 0 5px 0;
            font-size: 16px;
        }

        .header p {
            margin: 0;
            font-size: 8px;
        }

        .filter-info {
            width: 100%;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            padding: 7px 10px;
        }

        .filter-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .filter-info td {
            border: none;
            padding: 3px 5px;
            vertical-align: middle;
        }

        .filter-label {
            font-weight: bold;
            width: 12%;
        }

        .filter-value {
            width: 21%;
        }

        .salary-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .salary-table th,
        .salary-table td {
            border: 1px solid #999;
            padding: 5px 3px;
            vertical-align: middle;
        }

        .salary-table th {
            background-color: #eeeeee;
            font-weight: bold;
            text-align: center;
            font-size: 7px;
        }

        .salary-table td {
            font-size: 7px;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        /* Column widths */
        .col-sno {
            width: 3%;
        }

        .col-employee {
            width: 12%;
        }

        .col-department {
            width: 10%;
        }

        .col-designation {
            width: 11%;
        }

        .col-salary-type {
            width: 6%;
        }

        .col-net {
            width: 8%;
        }

        .col-status {
            width: 7%;
        }

        .col-date {
            width: 8%;
        }

        .col-amount {
            width: 8%;
        }

        .col-method {
            width: 8%;
        }

        .col-reference {
            width: 9%;
        }

        .col-remarks {
            width: 10%;
        }

        .status {
            display: inline-block;
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 6px;
            font-weight: bold;
        }

        .status-calculated {
            background: #d9edf7;
        }

        .status-approved {
            background: #dff0d8;
        }

        .status-paid {
            background: #d9edf7;
        }

        .status-cancelled {
            background: #f2dede;
        }

        .status-default {
            background: #eeeeee;
        }

        .footer {
            margin-top: 10px;
            text-align: right;
            font-size: 8px;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <div class="header">
        <h2>Salary Payment Report</h2>
        <p>
            Generated Date: {{ now()->format('d-m-Y H:i') }}
        </p>
    </div>


    {{-- Filter Details --}}
    @if (
        !empty($filters['employee']) ||
            !empty($filters['department']) ||
            !empty($filters['designation']) ||
            !empty($filters['salary_type']) ||
            !empty($filters['status']) ||
            !empty($filters['payment_method']) ||
            !empty($filters['payment_date_from']) ||
            !empty($filters['payment_date_to']))
        <div class="filter-info">
            <table>
                <tr>
                    <td class="filter-label">Employee:</td>
                    <td class="filter-value">{{ !empty($filters['employee_name']) ? $filters['employee_name'] : 'All' }}</td>
                    <td class="filter-label">Department:</td>
                    <td class="filter-value">{{ !empty($filters['department_name']) ? $filters['department_name'] : 'All' }}</td>
                </tr>
                <tr>
                    <td class="filter-label">Designation:</td>
                    <td class="filter-value">{{ !empty($filters['designation_name']) ? $filters['designation_name'] : 'All' }}</td>
                    <td class="filter-label">Salary Type:</td>
                    <td class="filter-value">{{ !empty($filters['salary_type']) ? ucfirst($filters['salary_type']) : 'All' }}</td>
                </tr>
                <tr>
                    <td class="filter-label"> Salary Status:</td>
                    <td class="filter-value"> {{ !empty($filters['status']) ? ucfirst($filters['status']) : 'All' }}</td>
                    <td class="filter-label">Payment Method:</td>
                    <td class="filter-value">
                        {{ !empty($filters['payment_method']) ? ucfirst(str_replace('_', ' ', $filters['payment_method'])) : 'All' }}
                    </td>
                </tr>
                <tr>
                    <td class="filter-label"> Payment Date From:</td>
                    <td class="filter-value">{{ !empty($filters['payment_date_from']) ? $filters['payment_date_from'] : 'All' }}</td>
                    <td class="filter-label">Payment Date To:</td>
                    <td class="filter-value">{{ !empty($filters['payment_date_to']) ? $filters['payment_date_to'] : 'All' }}</td>
                </tr>
            </table>
        </div>
    @endif


    {{-- Salary Payment Table --}}
    <table class="salary-table">
        <thead>
            <tr>
                <th class="col-sno">S.No</th>
                <th class="col-employee">Employee</th>
                <th class="col-department">Department</th>
                <th class="col-designation">Designation</th>
                <th class="col-salary-type">Salary Type</th>
                <th class="col-net">Net Salary</th>
                <th class="col-status">Status</th>
                <th class="col-date">Payment Date</th>
                <th class="col-amount">Payment Amount</th>
                <th class="col-method">Payment Method</th>
                <th class="col-reference">Transaction</th>
                <th class="col-remarks">Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salaryPayments as $index => $row)
                @php
                    $salaryDetail = $row->get_salarydetail;
                    $employee = $salaryDetail?->get_employee;
                    $department = $employee?->get_department;
                    $designation = $employee?->get_designation;
                @endphp
                <tr>
                    <td class="text-center"> {{ $index + 1 }}</td>
                    <td class="text-left">
                        @if ($employee)
                            {{ $employee->employee_code }}
                            <br>
                            {{ $employee->name }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-left">
                        @if ($department)
                            {{ $department->code }}
                            <br>
                            {{ $department->name }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-left">
                        @if ($designation)
                            {{ $designation->name }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($salaryDetail)
                            {{ ucfirst($salaryDetail->salary_type ?? '-') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">
                        @if ($salaryDetail)
                            {{ number_format($salaryDetail->net_salary ?? 0, 2) }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($salaryDetail)
                            @if ($salaryDetail->status === 'calculated')
                                <span class="status status-calculated">
                                    Calculated
                                </span>
                            @elseif($salaryDetail->status === 'approved')
                                <span class="status status-approved">
                                    Approved
                                </span>
                            @elseif($salaryDetail->status === 'paid')
                                <span class="status status-paid">
                                    Paid
                                </span>
                            @elseif($salaryDetail->status === 'cancelled')
                                <span class="status status-cancelled">
                                    Cancelled
                                </span>
                            @else
                                <span class="status status-default">
                                    {{ ucfirst($salaryDetail->status ?? '-') }}
                                </span>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($row->payment_date)
                            {{ \Carbon\Carbon::parse($row->payment_date)->format('d-m-Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($row->amount ?? 0, 2) }}</td>
                    <td class="text-center">
                        @if ($row->payment_method === 'cash')
                            Cash
                        @elseif($row->payment_method === 'bank_transfer')
                            Bank Transfer
                        @elseif($row->payment_method === 'upi')
                            UPI
                        @else
                            {{ ucfirst($row->payment_method ?? '-') }}
                        @endif
                    </td>
                    <td class="text-left">{{ $row->transaction_reference ?? '-' }}</td>
                    <td class="text-left">{{ $row->remarks ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">
                        No salary payments found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">
        Total Records:{{ $salaryPayments->count() }}
    </div>
</body>

</html>
