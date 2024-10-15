<?php

namespace App\Traits\messages;

trait CronJobMessages
{

    public function getWAMessageToNotifyParentForTrialClass($parent_content){
       return ("⭐️🔔 [Reminder] 🔔⭐️%0a%0aYour child has a Coding class on %0aDate: ".$parent_content->date."%0aTime: " . date('h:i A', strtotime($parent_content->time)) . " (Bangladesh Standard Time).%0aZoom Link : ".$parent_content->value_a."%0aLogin Details : " . $parent_content->class_login_details);
    }

}