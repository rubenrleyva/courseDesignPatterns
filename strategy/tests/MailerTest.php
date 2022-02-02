<?php

namespace Rubenrl\Strategy\Tests;

use Rubenrl\Strategy\Mailer;
use StephaneCoinon\Mailtrap\Client;
use StephaneCoinon\Mailtrap\Inbox;
use StephaneCoinon\Mailtrap\Model;

class MailerTest extends TestCase
{

    /** @test */
    function it_sends_emails_using_smtp()
    {

        // Instantiate Mailtrap API client
        $client = new Client('d898993e13fb2942f60212115daed9a1');

        // Boot API models
        Model::boot($client);

        // Fetch an inbox by its id
        $inbox = Inbox::find(1620526);

        // Get all messages in an inbox
        $messages = $inbox->messages();

        $mailer = new Mailer;
        $mailer->setSender('rubenrleyva@outlook.com');

        $sent = $mailer->send('rubenrleyva@outlook.com', 'An example message', 'The content of the message');

        $this->assertTrue($sent);

        // Get the last (newest) message in an inbox
        $newestMessage = $inbox->lastMessage();

        $this->assertNotNull($newestMessage);
        $this->assertSame(['rubenrleyva@outlook.com'], $newestMessage->recipientEmails());
        $this->assertSame('An example message', $newestMessage->subject());
        $this->assertSame('The content of the message', trim($newestMessage->textBody()));
    }


}