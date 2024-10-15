<!DOCTYPE html>
<html>
<head>
    <title>Trial Class Report</title>
    <style>
        table {
            font-family: 'Poppins';
            border-collapse: collapse;
            width: 100%;
        }
        
        td,
        th {
            text-align: left;
            padding: 5px 5px;
        }
        
        table th {
            font-size: 14px;
            font-weight: 600;
        }
        
        table td {
            font-size: 13px;
            font-weight: 500;
        }        
        .report-table td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 5px 5px;
        }
    </style>
</head>
<body>
    <h1>Daily Trial Class Report</h1>
    <table class="report-table">
        <thead>
            <tr>
                <th style="text-align: center">Date</th>
                <th style="text-align: center">Total</th>
                <th style="text-align: center">Registered</th>
                <th style="text-align: center">Attended</th>
                <th style="text-align: center">Absent</th>
                <th style="text-align: center">Wants to Reschedule</th>
                <th style="text-align: center">Not Reachable</th>
                <th style="text-align: center">Will Attend</th>
                <th style="text-align: center">Rescheduled</th>
                <th style="text-align: center">Admitted</th>
                <th style="text-align: center">Will Admit Later</th>
                <th style="text-align: center">Payment Pending</th>
                <th style="text-align: center">Decision Pending</th>
                <th style="text-align: center">Refused Admission</th>
                <th style="text-align: center">Not Interested</th>
                <th style="text-align: center">Invalid</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trial_class_reports as $report)
            <tr>
                <td style="text-align: center">{{ $report->date }}</td>
                <td style="text-align: center">{{ $report->TOT }}</td>
                <td style="text-align: center">{{ $report->REG }}</td>
                <td style="text-align: center">{{ $report->ATT }}</td>
                <td style="text-align: center">{{ $report->ABS }}</td>
                <td style="text-align: center">{{ $report->WTR }}</td>
                <td style="text-align: center">{{ $report->NOR }}</td>
                <td style="text-align: center">{{ $report->WAT }}</td>
                <td style="text-align: center">{{ $report->RES }}</td>
                <td style="text-align: center">{{ $report->ADM }}</td>
                <td style="text-align: center">{{ $report->WAL }}</td>
                <td style="text-align: center">{{ $report->PAP }}</td>
                <td style="text-align: center">{{ $report->DEP }}</td>
                <td style="text-align: center">{{ $report->REF }}</td>
                <td style="text-align: center">{{ $report->NOI }}</td>
                <td style="text-align: center">{{ $report->INV }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
