<?php

namespace Rubenrl\Strategy\Tests;

use PHPMailer\PHPMailer\Exception;
use Rubenrl\Strategy\ArrayTransport;
use Rubenrl\Strategy\FileTransport;
use Rubenrl\Strategy\SmtpTransport;
use StephaneCoinon\Mailtrap\Client;
use StephaneCoinon\Mailtrap\Inbox;
use StephaneCoinon\Mailtrap\Model;
use Rubenrl\Strategy\Mailer;

class MailerTest extends TestCase
{
    /** @test */
    public function it_stores_the_sent_emails_in_an_array()
    {
        $mailer = new Mailer($transport = new ArrayTransport());
        $mailer->setSender('example@outlook.com');

        $mailer->send('example@outlook.com', 'An example message', 'The content of the message');

        $sent = $transport->sent();

        $this->assertCount(1, $sent);
        $this->assertSame('example@outlook.com', $sent[0]['recipient']);
        $this->assertSame('An example message', $sent[0]['subject']);
        $this->assertSame('The content of the message', $sent[0]['body']);

    }

    /** @test */
    public function it_stores_the_sent_emails_in_a_log_file()
    {
        $filename = __DIR__ . '\storage\test.txt';
        @unlink($filename);

        $mailer = new Mailer(new FileTransport($filename));
        $mailer->setSender('example@outlook.com');

        //$mailer->setFilename($filename);
        $mailer->send('example@outlook.com', 'An example message', 'The content of the message');

        $content = file_get_contents($filename);

        $this->assertStringContainsStringIgnoringCase('Recipient: example@outlook.com', $content);
        $this->assertStringContainsStringIgnoringCase('Subject: An example message', $content);
        $this->assertStringContainsStringIgnoringCase('Body: The content of the message', $content);

    }

    /** @test
     * @throws Exception
     */
    public function it_sends_emails_using_smtp()
    {

        $client = new Client('d898993e13fb2942f60212115daed9a1');

        Model::boot($client);

        $inbox = Inbox::find('');

        $inbox->empty();

        $mailer = new Mailer(
            new SmtpTransport(
                'smtp.mailtrap.io',
                '-------------------',
                '-------------------',
                ''
            )
        );

        $mailer->setSender('example@outlook.com');

        $this->assertTrue($mailer->send('rubenrleyva@outlook.com', 'An example message', 'The content of the message'));

        $newestMessage = $inbox->lastMessage();

        $this->assertNotNull($newestMessage);
        $this->assertSame(['rubenrleyva@outlook.com'], $newestMessage->recipientEmails());
        $this->assertSame('An example message', $newestMessage->subject());

        $this->assertSame('The content of the message', trim($newestMessage->textBody()));
    }


}