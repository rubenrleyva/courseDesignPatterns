<?php

namespace Rubenrl\Strategy;

class ArrayTransport extends Transport
{
    protected $sent = [];

    public function send($recipient, $subject, $body, $sender): array
    {
        return $this->sent[] = compact('recipient', 'subject', 'body');
    }

    public function sent(): array
    {
        return $this->sent;
    }
}