@php
use App\Models\Student;
use App\Models\StudentsParent;
@endphp
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

	<table class="pricing-table">
	  <tr>
	  	<th>Sl No</th>
	    <th>Class name</th>
	    <th>Student Name</th>
	    <th>Student ID</th>
	    <th>Parent Name</th>
	    <th>Parent Phone</th>
	  </tr>
	   <?php 
       $sl=0;
       if($contentData['data']){
       foreach($contentData['data'] as $single){
           $parentInfo = Student::with('parent')
                        ->with('class')
                        ->where('user_id', $single->student_id)
                        ->first();
                        
            $parentDetails = StudentsParent::where('user_id', $parentInfo->parent->id)->first();
            $sl++;
            ?>
		  <tr>
		  	<td>{{ $sl }}</td>
		    <td>{{ (!empty($parentInfo->class->name) ? $parentInfo->class->name : '') }}</td>
		    <td>{{ (!empty($single->student->name) ? $single->student->name : '') }}</td>
            <td>{{ (!empty($parentInfo->student_id) ? $parentInfo->student_id : '') }}</td>
            <td>{{ (!empty($parentInfo->parent->name) ? $parentInfo->parent->name : '') }}</td>
		    <td>{{ (!empty($parentDetails->phone) ? $parentDetails->phone : '') }}</td>
		  </tr>
          <?php }
          }else{ ?>
            <tr>
                <th colspan="5" >No student was absent today.</th>
            </tr>
          <?php } ?>
	</table>
</body>
</html>