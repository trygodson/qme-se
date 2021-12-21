<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Mail;


class  CustomNotification
{
    public static function sendmail($body,$toname,$toemail,$subject)
    {

            $data = array('name'=>$toname, 'body' => $body,'footer');
            Mail::send('emails.mail', $data, function($message) use ($toname, $toemail,$subject)
        {
            $message->to($toemail, $toname)
            ->subject($subject);
            $message->from('pelemovictor0@gmail.com',"One Medy");
        }
            );
    }

}

