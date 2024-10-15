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
    <h1>CS Wise Trial Class Status Report</h1>
    <table class="report-table">
        <thead>
            <tr>
                <th style="text-align: center">name</th>
                <th style="text-align: center">Registered</th>
                <th style="text-align: center">Absent</th>
                <th style="text-align: center">Wants to Reschedule</th>
                <th style="text-align: center">Not Reachable</th>
                <th style="text-align: center">Will Attend</th>
                <th style="text-align: center">Rescheduled</th>
                <th style="text-align: center">Not Interested</th>
            </tr>
        </thead>
        <tbody>
            @if($cs_wise_trial_classes)
                @foreach ($cs_wise_trial_classes as $report)
                <tr>
                    <td style="text-align: center">{{ $report->name }}</td>
                    <td style="text-align: center">{{ $report->REG }}</td>
                    <td style="text-align: center">{{ $report->ABS }}</td>
                    <td style="text-align: center">{{ $report->WTR }}</td>
                    <td style="text-align: center">{{ $report->NOR }}</td>
                    <td style="text-align: center">{{ $report->WAT }}</td>
                    <td style="text-align: center">{{ $report->RES }}</td>
                    <td style="text-align: center">{{ $report->NOI }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <th colspan="5" style="text-align: center">No record found.</th>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
