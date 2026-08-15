<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Salary Details</title>

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
            font-size: 9px;
            color: #222;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0 0 5px 0;
            font-size: 16px;
        }

        .header p {
            margin: 0;
            font-size: 9px;
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
            padding: 6px 4px;
            vertical-align: middle;
        }

        .salary-table th {
            background-color: #eeeeee;
            font-weight: bold;
            text-align: center;
            font-size: 8px;
        }

        .salary-table td {
            font-size: 8px;
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

        /* Fixed column widths */
        .col-sno {
            width: 3%;
        }

        .col-period {
            width: 13%;
        }

        .col-employee {
            width: 13%;
        }

        .col-type {
            width: 6%;
        }

        .col-base {
            width: 7%;
        }

        .col-days {
            width: 5%;
        }

        .col-worked {
            width: 5%;
        }

        .col-gross {
            width: 7%;
        }

        .col-deduction {
            width: 7%;
        }

        .col-adjustment {
            width: 7%;
        }

        .col-net {
            width: 7%;
        }

        .col-status {
            width: 8%;
        }

        .status {
            display: inline-block;
            padding: 3px 5px;
            border-radius: 3px;
            font-size: 7px;
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

        .status-pending {
            background: #fcf8e3;
        }

        .status-default {
            background: #eeeeee;
        }

        .footer {
            margin-top: 12px;
            text-align: right;
            font-size: 8px;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <div class="header">
        <h2>Salary Details Report</h2>

        <p>
            Generated Date:
            {{ now()->format('d-m-Y H:i') }}
        </p>
    </div>


    {{-- Filter Details --}}
    @if(
        !empty($filters['period_type']) ||
        !empty($filters['start_date']) ||
        !empty($filters['end_date']) ||
        !empty($filters['status'])
    )

        <div class="filter-info">

            <table>

                <tr>

                    <td class="filter-label">
                        Period Type:
                    </td>

                    <td class="filter-value">
                        {{ !empty($filters['period_type']) ? ucfirst($filters['period_type']) : 'All' }}
                    </td>

                    <td class="filter-label">
                        Status:
                    </td>

                    <td class="filter-value">
                        {{ !empty($filters['status']) ? ucfirst($filters['status']) : 'All' }}
                    </td>

                </tr>

                <tr>

                    <td class="filter-label">
                        Start Date:
                    </td>

                    <td class="filter-value">
                        {{ !empty($filters['start_date']) ? $filters['start_date'] : 'All' }}
                    </td>

                    <td class="filter-label">
                        End Date:
                    </td>

                    <td class="filter-value">
                        {{ !empty($filters['end_date']) ? $filters['end_date'] : 'All' }}
                    </td>

                </tr>

            </table>

        </div>

    @endif


    {{-- Salary Table --}}
    <table class="salary-table">

        <thead>

            <tr>

                <th class="col-sno">
                    S.No
                </th>

                <th class="col-period">
                    Salary Period
                </th>

                <th class="col-employee">
                    Employee
                </th>

                <th class="col-type">
                    Salary Type
                </th>

                <th class="col-base">
                    Base Salary
                </th>

                <th class="col-days">
                    Full Days
                </th>

                <th class="col-days">
                    Half Days
                </th>

                <th class="col-days">
                    Absent Days
                </th>

                <th class="col-days">
                    Leave Days
                </th>

                <th class="col-worked">
                    Worked Days
                </th>

                <th class="col-gross">
                    Gross Salary
                </th>

                <th class="col-deduction">
                    Deduction
                </th>

                <th class="col-adjustment">
                    Adjustment
                </th>

                <th class="col-net">
                    Net Salary
                </th>

                <th class="col-status">
                    Status
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($salaryDetails as $index => $row)

                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>


                    <td class="text-center">

                        @if($row->get_salaryperiod)

                            {{ ucfirst($row->get_salaryperiod->period_type) }}

                            <br>

                            {{ \Carbon\Carbon::parse($row->get_salaryperiod->start_date)->format('d-m-Y') }}

                            <br>

                            to

                            <br>

                            {{ \Carbon\Carbon::parse($row->get_salaryperiod->end_date)->format('d-m-Y') }}

                        @else

                            -

                        @endif

                    </td>


                    <td class="text-left">

                        @if($row->get_employee)

                            {{ $row->get_employee->employee_code }}

                            <br>

                            {{ $row->get_employee->name }}

                        @else

                            -

                        @endif

                    </td>


                    <td class="text-center">
                        {{ ucfirst($row->salary_type ?? '-') }}
                    </td>


                    <td class="text-right">
                        {{ number_format($row->base_salary ?? 0, 2) }}
                    </td>


                    <td class="text-center">
                        {{ $row->full_days ?? 0 }}
                    </td>


                    <td class="text-center">
                        {{ $row->half_days ?? 0 }}
                    </td>


                    <td class="text-center">
                        {{ $row->absent_days ?? 0 }}
                    </td>


                    <td class="text-center">
                        {{ $row->leave_days ?? 0 }}
                    </td>


                    <td class="text-center">
                        {{ $row->worked_days ?? 0 }}
                    </td>


                    <td class="text-right">
                        {{ number_format($row->gross_salary ?? 0, 2) }}
                    </td>


                    <td class="text-right">
                        {{ number_format($row->deduction ?? 0, 2) }}
                    </td>


                    <td class="text-right">
                        {{ number_format($row->adjustment ?? 0, 2) }}
                    </td>


                    <td class="text-right">
                        <strong>
                            {{ number_format($row->net_salary ?? 0, 2) }}
                        </strong>
                    </td>


                    <td class="text-center">

                        @if($row->status === 'calculated')

                            <span class="status status-calculated">
                                Calculated
                            </span>

                        @elseif($row->status === 'approved')

                            <span class="status status-approved">
                                Approved
                            </span>

                        @elseif($row->status === 'paid')

                            <span class="status status-paid">
                                Paid
                            </span>

                        @elseif($row->status === 'pending')

                            <span class="status status-pending">
                                Pending
                            </span>

                        @else

                            <span class="status status-default">
                                {{ ucfirst($row->status ?? '-') }}
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="14" class="text-center">
                        No salary details found.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    <div class="footer">

        Total Records:
        {{ $salaryDetails->count() }}

    </div>

</body>

</html>
