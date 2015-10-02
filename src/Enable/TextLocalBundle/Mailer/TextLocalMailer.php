<?php

namespace Enable\TextLocalBundle\Mailer;

use Enable\TextLocalBundle\lib\Textlocal;

class TextLocalMailer implements SmsMailerInterface
{
    private $textLocal;

    public function __construct(TextLocal $textLocal)
    {
        $this->textLocal = $textLocal;
    }

    public function send(array $phoneNumbers, $msg, $fromName, $debug = false)
    {
        return $this->textLocal->sendSms($phoneNumbers, $msg, $fromName, null, $debug);
    }
}
