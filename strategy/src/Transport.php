<?php

namespace Rubenrl\Strategy;

abstract class Transport
{
    abstract public function send($recipient, $subject, $body, $sender);
}