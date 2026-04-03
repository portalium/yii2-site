<?php

namespace portalium\site\widgets;

use Yii;

use portalium\bootstrap5\Widget;
use portalium\site\bundles\ToastifyAsset;
use yii\helpers\Html;
use yii\helpers\Json;

class FlashMessage extends Widget
{
    /**
     * @var int Duration of the toast display in milliseconds.
     */
    public $duration = 4000;

    /**
     * @var array Additional color overrides for toast types.
     */
    public $colors = [];

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
     * @var string Position of the toast: 'left' or 'right'.
     */
    public $position = 'right';

    /**
     * @var string Gravity of the toast: 'top' or 'bottom'.
     */
    public $gravity = 'top';

    /**
     * @var bool Whether to show the close button on the toast.
     */
    public $close = true;

    /**
     * @var array Offset for the toast position as ['x' => int, 'y' => int].
     */
    public $offset = ['x' => 0, 'y' => 0];

    /**
     * @var bool Whether to stop the toast timer when focused.
     */
    public $stopOnFocus = true;

    /**
     * @var bool|array Legacy option to control close button rendering
     * If set to false, the close button will be disabled.
     */
    public $closeButton = [];

    /**
     * @var bool Whether the toast should auto-dismiss after `duration` milliseconds.
     * If false, `duration` is treated as 0 and the toast will stay until manually closed.
     */
    public $autoDismiss = true;

    public function init()
    {
        parent::init();
        ToastifyAsset::register($this->view);

        // Apply auto-dismiss behavior. If autoDismiss is disabled, force duration to 0.
        if (!$this->autoDismiss) {
            $this->duration = 0;
        }

        // Legacy support: if closeButton is explicitly set to false, disable the close icon.
        if ($this->closeButton === false) {
            $this->close = false;
        }

        // Toast widget handles the flash messages via run() method
    }

    public function run()
    {
        $flashes = Yii::$app->session->getAllFlashes();
        if (empty($flashes)) {
            return;
        }

        $toastData = [];
        foreach ($flashes as $type => $messages) {
            foreach ((array)$messages as $message) {
                $toastData[] = [
                    'text' => $message,
                    'type' => $type,
                    'duration' => $this->duration,
                ];
            }
        }

        Yii::$app->session->removeAllFlashes();

        $options = [
            'colors' => $this->colors,
            'alertTypes' => $this->alertTypes,
            'position' => $this->position,
            'gravity' => $this->gravity,
            'close' => $this->close,
            'offset' => $this->offset,
            'stopOnFocus' => $this->stopOnFocus,
        ];

        return Html::tag('div', '', [
            'class' => 'portalium-flash-toastify',
            'data-toasts' => Json::htmlEncode($toastData),
            'data-options' => Json::htmlEncode($options),
        ]);
    }
}
