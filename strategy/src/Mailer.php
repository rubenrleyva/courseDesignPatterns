<?php

namespace Rubenrl\Strategy;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{

    private $sender;

    public function setSender($email)
    {
        $this->sender = $email;
    }

    /**
     * @throws Exception
     */
    public function send($recipient, $subject, $body): bool
    {
        $phpMailer = new PHPMailer(true);

        $phpMailer->isSMTP();
        $phpMailer->Host       = 'smtp.mailtrap.io';
        $phpMailer->SMTPAuth   = true;
        $phpMailer->Username   = '3aec810bf70f8c';
        $phpMailer->Password   = '13ba04177cac32';
        $phpMailer->Port       = 2525;

        $phpMailer->setFrom($this->sender);
        $phpMailer->addAddress($recipient);
        $phpMailer->Subject = $subject;
        $phpMailer->Body = $body;
        $phpMailer->AltBody = $body;

        return $phpMailer->send();
    }


}