<?php

namespace Rubenrl\Strategy;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{

    protected $sender;
    protected $sent = [];
    protected $transport;
    protected $filename;
    protected $username;
    protected $host;
    protected $password;
    protected $port;

    public function __construct($transport = 'smtp')
    {
        $this->transport = $transport;
    }

    public function setSender($email)
    {
        $this->sender = $email;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @throws Exception
     */
    public function send($recipient, $subject, $body)
    {

        if ($this->transport == 'smtp'){

            $phpMailer = new PHPMailer(true);

            $phpMailer->isSMTP();
            $phpMailer->Host       = $this->host;
            $phpMailer->SMTPAuth   = true;
            $phpMailer->Username   = $this->username;
            $phpMailer->Password   = $this->password;
            $phpMailer->Port       = $this->port;

            $phpMailer->setFrom($this->sender);
            $phpMailer->addAddress($recipient);
            $phpMailer->Subject = $subject;
            $phpMailer->Body = $body;
            $phpMailer->AltBody = $body;

            return $phpMailer->send();
        }

        if ($this->transport == 'array'){
            $this->sent[] = compact('recipient', 'subject', 'body');
        }

        if ($this->transport == 'file'){
            $data = [
                'New Email',
                "Recipient: {$recipient}",
                "Subject: {$subject}",
                "Body: {$body}",
            ];

            file_put_contents($this->filename, "\n\n".implode("\n",  $data), FILE_APPEND);
        }
    }

    public function sent(): array
    {
        return $this->sent;
    }


}