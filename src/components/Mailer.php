<?php

namespace portalium\site\components;

use Yii;
use portalium\components\Mailer as CoreMailer;
use Symfony\Component\Mailer\Transport\Smtp\SmtpTransport;

class Mailer extends CoreMailer
{
    public $smtpCredentialsMissing = false;

    public function init()
    {
        parent::init();

        $username = Yii::$app->setting->getValue('smtp::username');
        $password = Yii::$app->setting->getValue('smtp::password');

        $transport = [
            'class' => SmtpTransport::class,
            'host' => Yii::$app->setting->getValue('smtp::server'),
            'username' => $username,
            'password' => $password,
            'port' => Yii::$app->setting->getValue('smtp::port'),
            'encryption' => Yii::$app->setting->getValue('smtp::encryption'),
            'scheme' => 'smtp'
        ];

        $this->setTransport($transport);

        if (empty($username) || empty($password)) {
            $this->smtpCredentialsMissing = true;
        }
    }

    public function send($message)
    {
        if ($this->smtpCredentialsMissing) {
            return false;
        }

        return parent::send($message);
    }
}