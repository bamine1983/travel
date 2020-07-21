<?php

namespace App\Utilities;

class EmailServiceClass //no need to extend anything
{

    private $mailerService; //dependency as private property

    //we're passing dependencies via constructor
    public function __construct(\Swift_Mailer $mailerService) 
    { 
        $this->mailerService = $mailerService;
    }

    public function sendEmail($subject, $to, $body)
    {
        $msg = (new \Swift_Message());

        $msg->setSubject($subject);
        $msg->setTo($to);
        $msg->setBody($body);
        $msg->setContentType('text/html');
        $msg->setCharset('utf-8');
        $msg->setFrom('no-reply@travelmarketplace.com');
        //now you can access mailer service like that
        return $this->mailerService->send($msg);
    }
}