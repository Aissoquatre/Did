<?php

namespace Did\Mail;

use Did\Kernel\Environment;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class Mailer
 *
 * @uses Mailer
 *
 * @package Did\Mail
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
class Mailer
{
    protected $setFrom = ['address' => '', 'name' => ''];
    protected $replyTo = ['address' => '', 'name' => ''];

    /**
     * @var null|Exception
     */
    protected $exception = null;

    /**
     * @uses sendMail
     *
     * @param array|string $email
     * @param string       $subject
     * @param string       $message
     *
     * @return bool
     */
    public function sendMail($email, string $subject, string $message): bool
    {
        try {
            $mail = new PHPMailer();

            $mail->CharSet = 'UTF-8';

            $mail->isSMTP();
            $mail->SMTPDebug  = Environment::get()->findVar('MAIL_SMTPDEBUG')  ?? 0;
            $mail->Host       = Environment::get()->findVar('MAIL_HOST');
            $mail->SMTPAuth   = Environment::get()->findVar('MAIL_SMTPAUTH')   ?? true;
            $mail->Username   = Environment::get()->findVar('MAIL_MAIL');
            $mail->Password   = Environment::get()->findVar('MAIL_PASSWORD');
            $mail->SMTPSecure = Environment::get()->findVar('MAIL_SMTPSECURE') ?? 'tls';
            $mail->Port       = Environment::get()->findVar('MAIL_PORT')       ?? 587;

            $mail->setFrom($this->setFrom['address'], $this->setFrom['name']);

            if (!empty($this->replyTo['address'])) {
                $mail->addReplyTo($this->replyTo['address'], $this->replyTo['name']);
            }

            if (!is_array($email)) {
                $email = [$email];
            }

            foreach ($email as $singleAddress) {
                $mail->addAddress($singleAddress);
            }

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = str_replace('<br>', "\r\n", $message);

            return $mail->send();
        } catch (Exception $e) {
            $this->exception = $e;

            return false;
        }
    }

    /**
     * @uses getSetFrom
     *
     * @return array
     */
    public function getSetFrom(): array
    {
        return $this->setFrom;
    }

    /**
     * @uses setSetFrom
     *
     * @param string $address
     * @param string $name
     *
     * @return Mailer
     */
    public function setSetFrom(string $address, string $name): Mailer
    {
        $this->setFrom['address'] = $address;
        $this->setFrom['name']    = $name;
        return $this;
    }

    /**
     * @uses getReplyTo
     *
     * @return array
     */
    public function getReplyTo(): array
    {
        return $this->replyTo;
    }

    /**
     * @uses setReplyTo
     *
     * @param string $address
     * @param string $name
     *
     * @return Mailer
     */
    public function setReplyTo(string $address, string $name): Mailer
    {
        $this->replyTo['address'] = $address;
        $this->replyTo['name']    = $name;
        return $this;
    }
}
