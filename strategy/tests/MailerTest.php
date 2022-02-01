<?php

namespace Rubenrl\Strategy\Tests;

class MailerTest extends TestCase
{

    /** @test */
    function it_sends_emails_using_smtp()
    {
        $mailer = new Mailer;
        $mailer->setSender('rubenrleyva@outlook.com');

        $sent = $mailer->send('rubenrleyva@outlook.com', 'An example message', 'The content of the mesage');

        $this->assertTrue($sent);
    }


}