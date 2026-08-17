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
            width: 15%;
        }

        .filter-value {
            width: 35%;
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

        .col-sno {
            width: 5%;
        }

        .col-salary {
            width: 13%;
        }

        .col-status {
            width: 10%;
        }

        .col-date {
            width: 10%;
        }

        .col-amount {
            width: 12%;
        }

        .col-method {
            width: 13%;
        }

        .col-reference {
            width: 18%;
        }

        .col-remarks {
            width: 19%;
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

        .status-cancelled {
            background: #f2dede;
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
        <h2>Salary Payment Report</h2>
        <p>Generated Date: {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    {{-- Filter Details --}}
    @if(
        !empty($filters['payment_method']) ||
        !empty($filters['payment_date_from']) ||
        !empty($filters['payment_date_to'])
    )

        <div class="filter-info">
            <table>
                <tr>
                    <td class="filter-label">Payment Method:</td>
                    <td class="filter-value">
                        {{ !empty($filters['payment_method']) ? ucfirst(str_replace('_', ' ', $filters['payment_method'])) : 'All' }}
                    </td>
                    <td class="filter-label">Payment Date From:</td>
                    <td class="filter-value">
                        {{ !empty($filters['payment_date_from']) ? $filters['payment_date_from'] : 'All' }}
                    </td>
                </tr>
                <tr>
                    <td class="filter-label">Payment Date To:</td>
                    <td class="filter-value">
                        {{ !empty($filters['payment_date_to']) ? $filters['payment_date_to'] : 'All' }}
                    </td>
                    <td class="filter-label">Status:</td>
                    <td class="filter-value">Paid</td>
                </tr>
            </table>
        </div>

    @endif

    {{-- Salary Payment Table --}}
    <table class="salary-table">
        <thead>
            <tr>
                <th class="col-sno">S.No</th>
                <th class="col-salary">Net Salary</th>
                <th class="col-status">Status</th>
                <th class="col-date">Payment Date</th>
                <th class="col-amount">Payment Amount</th>
                <th class="col-method">Payment Method</th>
                <th class="col-reference">Transaction Reference</th>
                <th class="col-remarks">Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salaryPayments as $index => $row)
                <tr>

                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-right">
                        @if($row->get_salarydetail)
                            {{ number_format($row->get_salarydetail->net_salary ?? 0, 2) }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($row->get_salarydetail)
                            @if($row->get_salarydetail->status === 'calculated')
                                <span class="status status-calculated">Calculated</span>
                            @elseif($row->get_salarydetail->status === 'approved')
                                <span class="status status-approved">Approved</span>
                            @elseif($row->get_salarydetail->status === 'paid')
                                <span class="status status-paid">Paid</span>
                            @elseif($row->get_salarydetail->status === 'cancelled')
                                <span class="status status-cancelled">Cancelled</span>
                            @else
                                <span class="status status-default">
                                    {{ ucfirst($row->get_salarydetail->status ?? '-') }}
                                </span>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($row->payment_date)
                            {{ \Carbon\Carbon::parse($row->payment_date)->format('d-m-Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($row->amount ?? 0, 2) }}</td>
                    <td class="text-center">
                        @if($row->payment_method === 'cash')
                            Cash
                        @elseif($row->payment_method === 'bank_transfer')
                            Bank Transfer
                        @elseif($row->payment_method === 'upi')
                            UPI
                        @else
                            {{ ucfirst($row->payment_method ?? '-') }}
                        @endif
                    </td>
                    <td class="text-left"> {{ $row->transaction_reference ?? '-' }}</td>
                    <td class="text-left">{{ $row->remarks ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center"> No salary payments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer">
        Total Records: {{ $salaryPayments->count() }}
    </div>
</body>
</html>
