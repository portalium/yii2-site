<?php

namespace portalium\site\components;

use yii\base\Component;

class Site extends Component
{
    public $mailer;

    public function init(): void
    {
        parent::init();
        $this->mailer = new Mailer();
    }
}
