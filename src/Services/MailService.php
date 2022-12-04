<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;



class MailService
{


    public function __construct(private MailerInterface $mailer){}

    public function  sendEmail(string $from ,
                               string $to,
                               string $subject,
                               string $content

                               //string $content ,

    ):void{

        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->text($content);



        $this->mailer->send($email);

    }


}