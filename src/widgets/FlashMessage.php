<?php

namespace portalium\site\widgets;

use Yii;

use portalium\bootstrap5\Alert;
use portalium\bootstrap5\Widget;

class FlashMessage extends \portalium\theme\widgets\Toast
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the toast background color (gradient or color)
     */
    public $alertTypes = [
        'error'   => 'linear-gradient(to right, #ff5f6d, #ffc371)',
        'danger'  => 'linear-gradient(to right, #ff5f6d, #ffc371)',
        'success' => 'linear-gradient(to right, #00b09b, #96c93d)',
        'info'    => 'linear-gradient(to right, #2193b0, #6dd5ed)',
        'warning' => 'linear-gradient(to right, #f7971e, #ffd200)'
    ];
    /**
     * @var array the options for rendering the close button tag.
     */
    public $closeButton = [];

    public $autoDismiss = true;

    public $dismissDuration = 5000;

    public function init()
    {
        parent::init();
        // Set duration from dismissDuration for toast
        $this->duration = $this->dismissDuration;
        // Set close from closeButton
        $this->close = !empty($this->closeButton);
        // Toast widget handles the flash messages via run() method
    }
}
