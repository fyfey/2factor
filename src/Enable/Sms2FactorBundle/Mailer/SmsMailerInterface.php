<?php

namespace Enable\Sms2FactorBundle\Mailer;

interface SmsMailerInterface
{
    public function send(array $phoneNumbers, $message, $fromName, $debug = false);
}
