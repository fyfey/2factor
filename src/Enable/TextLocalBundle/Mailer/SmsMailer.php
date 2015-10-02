<?php

namespace Enable\TextLocalBundle\Mailer;

use AppBundle\Entity\User;
use Enable\TextLocalBundle\lib\Textlocal;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Scheb\TwoFactorBundle\Mailer\AuthCodeMailerInterface;

class SmsMailer implements AuthCodeMailerInterface
{
    private $textlocal;
    private $mailer;
    private $smsDisabled;
    private $deliveryPhoneNumber;
    private $senderAddress;

    public function __construct(Textlocal $textlocal, \Swift_Mailer $mailer, $smsDisabled, $smsDebug, $deliveryPhoneNumber, $senderAddress, $logger) {
        $this->textlocal           = $textlocal;
        $this->mailer              = $mailer;
        $this->smsDisabled         = $smsDisabled;
        $this->smsDebug            = $smsDebug;
        $this->deliveryPhoneNumber = $deliveryPhoneNumber;
        $this->senderAddress       = $senderAddress;
        $this->logger              = $logger;
    }

    public function sendAuthCode(TwoFactorInterface $user)
    {
        $msg = 'Your one-time code is '.$user->getEmailAuthCode();

        $fromName = 'SMSAuth';

        $this->sendSMS($user, $msg, $fromName);
    }

    protected function sendSms(User $user, $msg, $fromName)
    {
        if ($this->deliveryPhoneNumber !== null) {
            $number = $this->deliveryPhoneNumber;
        } else {
            $number = $user->getMobileNumber();
        }
        $email = $user->getEmail();

        if (!$number) {
            return $this->sendMail($email, $msg, $fromName);
        }


        if ($this->smsDisabled) {
            $this->sendMail($email, $msg, $fromName);
        } else {
            $response = $this->textlocal->sendSms(array($number), $msg, $fromName, null, $this->smsDebug);
            $this->logger->debug('SMS response: '.print_r($response, true));

            if ($response['status'] !== 'success') {
                $this->sendMail($email, $msg, $fromName);
            }
        }
    }

    protected function sendMail($email, $msg, $from)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject("[SMS - ".$from."]")
            ->setFrom($this->senderAddress)
            ->SetTo($email);
        $message->setBody($msg, 'text/html');

        return $this->mailer->send($message);
    }
}
