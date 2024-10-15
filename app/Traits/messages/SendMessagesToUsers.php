<?php

namespace App\Traits\messages;

use App\Models\TrialClass;
use App\Traits\Utils;

trait SendMessagesToUsers
{
    protected $student_dao;

    use Utils;

    public function getMessageForAssignedCustomerSupportExecutiveOfTrialClass($trial_id){
       $trial_class = TrialClass::find($trial_id);
       $has_device = ($trial_class->hasDevice == 1 ? 'Yes' : 'No');
       $track = $this->getTrackFromAge($trial_class->age);
       $route = url('/')."/trial-class"."/".$trial_class->id."/edit?backlink=".url('/')."/trial-class";

       return ($trial_class->student_name." ".$trial_class->status." \nFrom : ".$trial_class->country." \nContact : ".$trial_class->phone." \n \nEmail : ".$trial_class->email." \nInstructor : ".$trial_class->schedule?->teacher->name." (". $track .") \nHas Device : ".$has_device." \nAssigned Sales Person : ".$trial_class->salesTeam?->user->name." \nCo-ordinator : ".$trial_class->schedule->coordinator?->name." \nLink : ".$route);
    }

    public function generatePaymentDueMessageForParent($children)
    {
        $message = "<b>Sorry! Your account has been temporarily blocked because of payment due.</b><br><br>";
        $message .= "Payment Due Information:<br><br>";
        foreach($children as $child){
            $message .= "Student Name: {$child->name}<br>";
            $message .= "Due For The Month(s): {$child->due_for_months}<br>";
            $message .= "Fees: {$child->payable_amount}<br>";
            $message .= "Total Due: {$child->payable_amount} * {$child->due_installments} =".$child->payable_amount * $child->due_installments."<br><br>";
        }

        $message .= "Payment Methods:<br>";
        $message .= "Bkash: 01301528308 (MERCHANT)<br><br>";
        $message .= "If you have already paid, please share your payment details with us and we will unblock your account asap.<br><br>";
        $message .= "Contact: +880 1897-717788<br>";

        return $message;
    }

    public function generatePaymentDueMessageForStudent($student)
    {
        $message = "<b>Sorry! Your account has been temporarily blocked because of payment due.</b><br><br>";
        $message .= "Payment Due Information:<br><br>";
        $message .= "Student Name: {$student[0]->name}<br>";
        $message .= "Due For The Month(s): {$student[0]->due_for_months}<br>";
        $message .= "Fees: {$student[0]->payable_amount}<br>";
        $message .= "Total Due: {$student[0]->payable_amount} * {$student[0]->due_installments} =".$student[0]->payable_amount * $student[0]->due_installments."<br><br>";
        $message .= "Payment Methods:<br>";
        $message .= "Bkash: 01301528308 (MERCHANT)<br><br>";
        $message .= "If you have already paid, please share your payment details with us and we will unblock your account asap.<br><br>";
        $message .= "Contact: +880 1897-717788";

        return $message;
    }

    public function generateErrorMessageForNonAdmittedStudents()
    {
        return "You are no longer an admitted student of Dreamers and cannot login";
    }

}