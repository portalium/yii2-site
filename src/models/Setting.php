<?php

namespace portalium\site\models;

use Yii;
use yii\db\ActiveRecord;
use portalium\base\Event;
use portalium\site\Module;
use portalium\site\models\Form;
use portalium\site\models\SettingValue;

class Setting extends ActiveRecord
{
    public static function tableName()
    {
        return '{{'. Module::$tablePrefix .'setting}}';
    }

    public function rules()
    {
        return [
            [['module','name','label','type'], 'required'],
            [['name'], 'string', 'max' => 200],
            ['type', 'default', 'value' => Form::TYPE_INPUT],
            ['type', 'in', 'range' => Form::getTypes()], 
            ['value', 'safe'],
        ];
    }

    public function init()
    {
        $this->on(self::EVENT_AFTER_UPDATE, function($event) {

            if($event->changedAttributes && Yii::$app->getModule($event->data['module']))
            {
                Event::trigger(Yii::$app->getModule($event->data['module']), Module::EVENT_SETTING_UPDATE, new Event(['payload' => [
                    'data' => $event->data,
                    'changedAttributes' => $event->changedAttributes
                ]]));
            }
        }, $this);
    }

    public function attributeLabels()
    {
        return [
            'id' => Module::t('ID'),
            'module' => Module::t('Module'),
            'name' => Module::t('Name'),
            'label' => Module::t('Label'),
            'value' => Module::t('Value'),
            'type' => Module::t('Type'),
            'config' => Module::t('Config')
        ];
    }
}
