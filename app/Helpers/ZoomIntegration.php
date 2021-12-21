<?php

namespace App\Helpers;
use MacsiDigital\Zoom\Facades\Zoom;
class ZoomIntegration
{
   
    public static function  generateZoomToken()
    {
  
        $email = 'fewgenesis@gmail.com';
       
        $meeting = Zoom::meeting()->make([
            "topic" => 'Appointment',
            "type" => 2,
            "start_time" =>'2025-12-15T5:00',
            "duration" => 60,
            "schedule_for" => $email,
            "timezone" => 'Africa/Casablanca',
            "password" => '123456',
            "agenda" => 'Patient Appointment',
            "recurrence" => [],
            "settings" => [
                "host_video"=> true,
                "participant_video" => true,
                "cn_meeting" => false,
                "in_meeting" => false,
                "join_before_host" => true,
                "mute_upon_entry" => false,
                "watermark" => false,
                "use_pmi" => false,
                "approval_type" => 0,
                "registration_type" => 1,
                "audio" => 'both',
                "auto_recording" => 'none',
                "enforce_login" => false,
                "enforce_login_domains" => null,
                "alternative_hosts" => null,
                "registrants_email_notification" => false,
            ],
        ]);

        $user = Zoom::user()->find($email)->meetings()->save($meeting);

        if($user){
            $meetinglink = $user->join_url;
            $parts = parse_url($meetinglink);
            parse_str($parts['query'], $query);


            return ["pwd"=>$query['pwd'],"id"=>$user->id];

        }else{
            return 'nothing';
        }
    }
}