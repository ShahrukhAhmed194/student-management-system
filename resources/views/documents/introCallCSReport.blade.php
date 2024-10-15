<!DOCTYPE html>
<html>
<head>
    <title>Intro Call CS Report</title>
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
    <h1>Intro Call CS Report</h1>
    <table class="report-table">
        <thead>
            <tr>
                <th style="text-align: center">ID</th>
                <th style="text-align: center">Name</th>
                <th style="text-align: center">Registered</th>
                <th style="text-align: center">Intro Call</th>
                <th style="text-align: center">Diff</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($intro_call_cs_reports as $report)
            <tr>
                <td style="text-align: center">{{ $report->id }}</td>
                <td style="text-align: center">{{ $report->name }}</td>
                <td style="text-align: center">{{ $report->registered }}</td>
                <td style="text-align: center">{{ $report->intro_call }}</td>
                <td style="text-align: center">{{ $report->diff }} Mins</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
