<?php

namespace FrontOfficeBundle\Services;

class MailService
{
	protected $mailer;

	public function __construct($mailer)
	{
		$this->mailer=$mailer;
	}

	public function send($subject, $mailTo, $mailFrom, $body)
	{
		$mail= \Swift_Message::newInstance();

		$mail->setSubject($subject)
			 ->setTo($mailTo)
			 ->setFrom($mailFrom)
			 ->setBody($body);

		$this->mailer->send($mail);
	}
}