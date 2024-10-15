<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Invoice</title>
</head>

<body>
    <div style="max-width: 850px; margin: auto">
        <table style="width: 100%; margin-top: 20px">
            <tbody>
                <tr>
                    <td width="40%" style="font-size: 30px;">
                        Invoice
                    </td>
                    <td width="60%" style="text-align: right;">
                        <div style="font-size: 20px">
                            Dreamers Academy
                        </div>
                        <div style="font-size: 12px">
                            Mega Dori, Lift#4, H#57/A, R#15/A, Dhanmondi
                        </div>
                        <div style="font-size: 12px">
                            ++880 1897-717780, ++880 1897-717781
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%">
            <tbody>
                <tr>
                    <td width="50%" style="padding-top: 20px">
                        <div>
                            <strong>Student Name:</strong> {{ $payment->student->user->name }}    
                        </div>
                        <div style="margin-top: 10px">
                            <strong>Guardian Name:</strong> {{ $payment->student->parent->name }}    
                        </div>
                        <div style="margin-top: 10px">
                            <strong>Email:</strong> {{ $payment->student->parent->email }}    
                        </div>
                    </td>
                    <td width="50%" style="text-align: right;">
                        <div>
                            <strong>Invoice ID:</strong> {{ $payment->invoice_id }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%; margin-top: 20px; border: 1px solid #000; border-collapse: collapse;" border="1">
            <tbody>
                <tr style="background-color: #85C1E9; text-align: center;">
                    <td style="padding-top: 10px; padding-bottom: 10px">
                        <strong>Course</strong>
                    </td>
                    <td><strong>Payment Date</strong></td>
                    <td><strong>Payment Details</strong></td>
                    <td><strong>Amount</strong></td>
                </tr>
                <tr style="height: 300px" valign="top">
                    <td width="10%" style="padding-top: 10px; padding-left: 10px; padding-right: 10px">
                        Coding for Kids
                    </td>
                    <td width="20%" style="padding-top: 10px; padding-left: 10px; padding-right: 10px">
                        {{ date('d M, Y', strtotime($payment->date)) }}
                    </td>
                    <td width="40%" style="padding-top: 10px; padding-left: 10px; padding-right: 10px">
                        <div>
                            Transaction Type: {{ $payment->transaction_type }}
                        </div>
                        <div>
                            Transaction ID: {{ $payment->transaction_id }}
                        </div>
                        <div>
                            Installment: {{ $payment->installment }}
                        </div>
                        <div>
                        @php 
                        $showMonth = '';
                        if($payment->for_month){
                        $for_months = json_decode($payment->for_month, true); 
                         foreach ($for_months as $month){
                             $showMonth.=  $month .', ';
                         }
                        }
                        @endphp 
                            For the Month: {{ rtrim($showMonth, ', ') }}
                        </div>
                        <div>
                            Purpose: {{ $payment->transaction_purpose }}
                        </div>
                    </td>
                    <td width="20%" style="text-align: center; padding-top: 10px; padding-left: 10px; padding-right: 10px">
                        {{ $payment->fees }}&nbsp; ({{ $payment->currency }})
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right; padding-right: 10px; padding-top: 10px; padding-bottom: 10px">
                        <strong>Total Paid</strong>
                    </td>
                    <td style="text-align: center;">
                        {{ $payment->fees }}&nbsp; ({{ $payment->currency }})
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="font-size: 10px; text-align: center; margin-top: 20px">
            <i>This is a system generated invoice and does not require a signature.</i>
        </div>
    </div>
</body>
</html>