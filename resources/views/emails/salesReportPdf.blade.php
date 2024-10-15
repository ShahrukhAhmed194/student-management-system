<!DOCTYPE html>
<html>
<head>
    <title>Dreamers Academy</title>
</head>
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
        
        .details-table {
            margin-bottom: 25px;
        }
        
        .details-table td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 5px 5px;
        }
        
        .pricing-table td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 5px 5px;
        }
    </style>
<body>
    <div>
        <h3 style="text-align: center">Sales Report</h3>
    </div>
	<table class="pricing-table">
        <tr>
            <th scope="col" style="text-align: center">Date</th>
            <th scope="col" style="text-align: center">Mushfiq</th>
            <th scope="col" style="text-align: center">Fahmida</th>
            <th scope="col" style="text-align: center">Shammi</th>
	    <th scope="col" style="text-align: center">Mehjabin</th>
	    <th scope="col" style="text-align: center">Sakil</th>
	    <th scope="col" style="text-align: center">Anjon</th>
	    <th scope="col" style="text-align: center">YSSE</th>
            <th scope="col" style="text-align: center">Total Sales</th>
        </tr>
	   <?php 
       $sl=0;

       if($contentData['data']){
        foreach($contentData['data'] as $single){
                $sl++;
                ?>
            <tr>
                <td style="text-align: center">{{ $single->date }}</td>
                <td style="text-align: center">{{ $single->Mushfiq }}</td>
                <td style="text-align: center">{{ $single->Fahmida }}</td>
                <td style="text-align: center">{{ $single->Shammi }}</td>
                <td style="text-align: center">{{ $single->Mehjabin }}</td>
		        <td style="text-align: center">{{ $single->Sakil }}</td> 
	            <td style="text-align: center">{{ $single->Anjon }}</td>   
	            <td style="text-align: center">{{ $single->YSSE }}</td>   
		        <td style="text-align: center">{{ $single->Mushfiq + $single->Fahmida + $single->Shammi + $single->Mehjabin + $single->Sakil + $single->Anjon + $single->YSSE }}</td>
            </tr>
            <?php }
            ?>
            
            @if($contentData['reportsTotalSalesSum'])
            <tr>
                <th style="text-align: center">Total</th>
                <th style="text-align: center">{{ (!empty($contentData['reportsTotalSalesSum'][0]->mushfiqTotalSale) ? $contentData['reportsTotalSalesSum'][0]->mushfiqTotalSale : 0) }}</th>
                <th style="text-align: center">{{ (!empty($contentData['reportsTotalSalesSum'][0]->fahmidaTotalSale) ? $contentData['reportsTotalSalesSum'][0]->fahmidaTotalSale : 0) }}</th>
                <th style="text-align: center">{{ (!empty($contentData['reportsTotalSalesSum'][0]->shammiTotalSale) ? $contentData['reportsTotalSalesSum'][0]->shammiTotalSale : 0) }}</th>
                <th style="text-align: center">{{ (!empty($contentData['reportsTotalSalesSum'][0]->mehjabinTotalSale) ? $contentData['reportsTotalSalesSum'][0]->mehjabinTotalSale : 0) }}</th>
                <th style="text-align: center">{{ (!empty($contentData['reportsTotalSalesSum'][0]->shakilTotalSale) ? $contentData['reportsTotalSalesSum'][0]->shakilTotalSale : 0) }}</th>
                <th style="text-align: center">{{ (!empty($contentData['reportsTotalSalesSum'][0]->anjonTotalSale) ? $contentData['reportsTotalSalesSum'][0]->anjonTotalSale : 0) }}</th>
                <th style="text-align: center">{{ (!empty($contentData['reportsTotalSalesSum'][0]->YSSETotalSale) ? $contentData['reportsTotalSalesSum'][0]->YSSETotalSale : 0) }}</th>
                <th style="text-align: center">{{ ($contentData['reportsTotalSalesSum'][0]->mushfiqTotalSale + $contentData['reportsTotalSalesSum'][0]->fahmidaTotalSale + $contentData['reportsTotalSalesSum'][0]->shammiTotalSale + $contentData['reportsTotalSalesSum'][0]->mehjabinTotalSale + $contentData['reportsTotalSalesSum'][0]->shakilTotalSale + $contentData['reportsTotalSalesSum'][0]->anjonTotalSale + $contentData['reportsTotalSalesSum'][0]->YSSETotalSale ) }}</th>
            </tr>
            @endif
            <?php
          }else{ ?>
            <tr>
                <th colspan="5" style="text-align: center">No record found.</th>
            </tr>
          <?php } ?>
	</table>
</body>
</html>
