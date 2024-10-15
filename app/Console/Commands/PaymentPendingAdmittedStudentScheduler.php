<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Student;
use App\Traits\WhatsAppNotification;
use Illuminate\Support\Facades\DB;

class PaymentPendingAdmittedStudentScheduler extends Command
{
     use WhatsAppNotification;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:paymentpendingadmittedstudent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
            
	/*$students = DB::select("SELECT s.id, us.name as student_name, u.name as parent_name, p.phone, u.email, s.due_installments
				FROM students s
				JOIN users us ON (us.id = s.user_id)
				JOIN parents p ON (p.user_id = s.parent_id)
				JOIN users u ON (u.id = p.user_id)
				WHERE s.status = 1 AND s.payment_status = 'Pending' AND s.due_installments IS NOT NULL");
	 */

	$students = DB::select("SELECT s.id, us.name as student_name, u.name as parent_name, p.phone, u.email, s.due_installments, s.due_for_months, s.payable_amount
                                FROM students s
                                JOIN users us ON (us.id = s.user_id)
                                JOIN parents p ON (p.user_id = s.parent_id)
                                JOIN users u ON (u.id = p.user_id)
				WHERE s.status = 1 AND s.payment_status = 'Pending' and s.due_date <= '2024-05-17'
				and s.due_installments is not null");
	 
	foreach ($students as $single) {
		if (is_null($single->due_installments)) {
                   continue;
		}
		
                $contentData = [
                    'subject' => '[URGENT] Coding for Kids | Payment Due Reminder',
                    'message' => 'This is a gentle reminder to clear your monthly fees for "Coding for Kids" program.',
                    'studentName'    => $single->student_name,
                    'parentName'    => $single->parent_name,
                    'parentPhone'    => $single->phone,
                    'parentEmail'    => $single->email,
					'due_installments'    => $single->due_installments,
					'due_for_months' => $single->due_for_months,
					'payable_amount' => $single->payable_amount
				];
	    
		if($single->email){
                    //if(config('app.env') === 'production'){
                        /*Mail::to($single->email)
				->send(new \App\Mail\NotifyPendingPaymentAdmittedMailer($contentData));
			 */
		 	
			/*Mail::to('sharifducse@gmail.com')
                                ->send(new \App\Mail\NotifyPendingPaymentAdmittedMailer($contentData));
			 */
			//}
		}
			$totalDue = $contentData['payable_amount'] ." * " . $contentData['due_installments'] . " = " .$contentData['payable_amount']*$contentData['due_installments'];
			
                if($single->phone){
						$whatapp_msg = '*[URGENT] Coding for Kids | Payment Due Reminder*\n\n'.
							'This is a gentle reminder to clear your monthly fees for "Coding for Kids" program.\n\n'.
							'Student Name: ' . $contentData['studentName'] . '\n'.
							'Due For The Month(s): *' . $contentData['due_for_months'] . '*\n'.
							'Fees: *' . $contentData['payable_amount'] . '*\n'.
							'Total Due: *' . $totalDue . '*\n\n'.
							'\n'. 
							'Payment Methods: \n'.
							'Bkash: 01301528308 (MERCHANT)\n'.
							'Nagad: 01301507842\n\n'.
							'Note: If you have already paid, please share your payment details with us.\n\n'.
							'Regards,\nTeam Dreamers';
						
						
						/*$whatapp_msg = '[ALERT] Parent Account Details | Dreamers App\n\n'.
							'Dear '. $contentData['parentName']. ',\n'.
							'The following is your parent account details:\n'.
							'User name: '. $contentData['user_name']. '\n'.
							'Password: '. $contentData['password']. '\n'.
							'App Link: https://dreamers.lead.academy/login\n\n'.
							'What can you do with Dreamers App:\n'.
							'- Pay your monthly fees\n'.
							'- Check your childs class report\n'.
							'- Access class recordings\n\n'.
							'Note: we will soon send your childs account details as well.';
						*/
						
						/*$whatapp_msg = '[ALERT] Student Account Details | Dreamers App\n\n'.
							'The following is your child account details:\n'.
							'Child Name: '. $contentData['childName']. '\n'.
											'User Name: '. $contentData['userName']. '\n'.
											'Password: '. $contentData['password']. '\n'.
							'App Link: https://dreamers.lead.academy/login\n\n'.
							'Please, forward these details to your child.';
						*/

						//if(config('app.env') === 'production'){
						//$this->sendWANotification($contentData['parentPhone'], $whatapp_msg);
						// $this->sendWANotification('01715438290', $whatapp_msg);
						$this->sendWANotification($single->phone, $whatapp_msg);
								//}
					}
		//break;
	}
        return 0;
    }
}
