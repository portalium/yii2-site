<?php

namespace portalium\site\components;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use portalium\site\models\Setting as Settings;

class Setting extends Component
{
    public function getConfig($name)
    {
        return self::decode(self::findSetting($name)->config);
    }

    public function getAll()
    {
        return ArrayHelper::map(Settings::find()->asArray()->all(),'name','value');
    }

    public function getValue($name)
    {
        return self::decode(self::findSetting($name)->value);
    }

    public static function getSetting($name)
    {
        return self::findSetting($name);
    }

    private function decode($value)
    {
        return (is_object(json_decode($value))) ? json_decode($value, true): $value;
    }

    private function findSetting($name)
    {
        if (($setting = Settings::findOne(['name' => $name])) !== null) {
            return $setting;
        }

        throw new NotFoundHttpException(Module::t('The requested setting does not exist.'));
    }
}
