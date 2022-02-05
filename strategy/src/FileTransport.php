<?php

namespace Rubenrl\Strategy;

class FileTransport extends Transport
{
    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function send($recipient, $subject, $body, $sender)
    {
        $data = [
            'New Email',
            "Recipient: {$recipient}",
            "Subject: {$subject}",
            "Body: {$body}",
        ];

        file_put_contents($this->filename, "\n\n".implode("\n",  $data), FILE_APPEND);
    }
}