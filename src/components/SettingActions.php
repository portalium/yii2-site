<?php

namespace portalium\site\components;

use Yii;
use yii\base\BaseObject;

class SettingActions extends BaseObject
{
    public function changedSetting($event)
    {
        $setting = $event->payload['data'];
        if ($setting->name === 'site::timezone' && !empty($setting->value)) {
            Yii::$app->timeZone = $setting->value;
            Yii::$app->formatter->defaultTimeZone = $setting->value;
        }
    }
}
