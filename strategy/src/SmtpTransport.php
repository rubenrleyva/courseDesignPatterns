<?php

namespace Rubenrl\Strategy;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SmtpTransport extends Transport
{
    protected $host;
    protected $username;
    protected $password;
    protected $port;

    public function __construct($host, $username, $password, $port)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
    }

    /**
     * @throws Exception
     */
    public function send($recipient, $subject, $body, $sender): bool
    {
        $phpMailer = new PHPMailer(true);

        $phpMailer->isSMTP();
        $phpMailer->Host       = $this->host;
        $phpMailer->SMTPAuth   = true;
        $phpMailer->Username   = $this->username;
        $phpMailer->Password   = $this->password;
        $phpMailer->Port       = $this->port;

        $phpMailer->setFrom($sender);
        $phpMailer->addAddress($recipient);
        $phpMailer->Subject = $subject;
        $phpMailer->Body = $body;
        $phpMailer->AltBody = $body;

        return $phpMailer->send();
    }
}