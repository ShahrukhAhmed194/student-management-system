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
    <h1>Upcoming Trial Class Schedule Report</h1>
    <table class="report-table">
        <thead>
            <tr>
                <th style="text-align: center">Date</th>
                <th style="text-align: center">Day</th>
                <th style="text-align: center">Schedules</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($upcomming_trial_classes as $report)
            <tr>
                <td style="text-align: center">{{ $report->Date }}</td>
                <td style="text-align: center">{{ $report->Day }}</td>
                <td style="text-align: center">{{ $report->Schedules }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
