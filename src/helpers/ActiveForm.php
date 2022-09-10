<?php

namespace portalium\site\helpers;

use ReflectionClass;
use yii\helpers\Json;
use portalium\site\Module;
use yii\helpers\ArrayHelper;
use portalium\site\models\Form;
use portalium\content\models\Content;

class ActiveForm
{
    private static $typeMethodName= [
        Form::TYPE_INPUT => 'input',
        Form::TYPE_INPUTTEXT => 'textInput',
        Form::TYPE_INPUTPASSWORD => 'passwordInput',
        Form::TYPE_INPUTFILE => 'fileInput',
        Form::TYPE_INPUTHIDDEN => 'hiddenInput',
        Form::TYPE_TEXTAREA => 'textarea',
        Form::TYPE_CHECKBOX => 'checkbox',
        Form::TYPE_CHECKBOXLIST => 'checkboxList',
        Form::TYPE_RADIO => 'radio',
        Form::TYPE_RADIOLIST => 'radioList',
        Form::TYPE_LISTBOX => 'listBox',
        Form::TYPE_DROPDOWNLIST => 'dropdownList',
        Form::TYPE_WIDGET => 'widget'
    ];

    public static function configT($model)
    {
        $items = Json::decode($model->config,true);
        return (is_array($items)) ? array_map(function($item) use($model) {
            return Module::settingT($model->module, $item);
            }, $items) : $model->config;
    }

    public static function field($form, $model, $index, $label)
    {
        $method = self::getMethodName($model->type);
        if(in_array($model->type, [Form::TYPE_INPUTFILE, Form::TYPE_TEXTAREA, Form::TYPE_CHECKBOX, Form::TYPE_CHECKBOXLIST, Form::TYPE_RADIO, Form::TYPE_RADIOLIST, Form::TYPE_LISTBOX, Form::TYPE_DROPDOWNLIST]))
            return $form->field($model, "[$index]value")->$method(self::configT(self::getConfigData($model)))->label($label);

        if(in_array($model->type, [Form::TYPE_INPUTTEXT, Form::TYPE_INPUTPASSWORD]))
            return $form->field($model, "[$index]value")->$method()->label($label);
        
        if(in_array($model->type, [Form::TYPE_INPUT]))
            return $form->field($model, "[$index]value")->$method($model->config)->label($label);

        if(in_array($model->type, [Form::TYPE_WIDGET])){
            $data = self::getConfigData($model);
            return $form->field($model, "[$index]value")->$method($data['class'], $data['options'])->label($label);
        }
    }

    private static function getMethodName($type)
    {
        return self::$typeMethodName[$type];
    }

    private static function getConfigData($model)
    {
        $items = Json::decode($model->config,true);

        if(isset($items['widget'])){
            $class = $items['widget'];
            $options = $items['options'];
            return ['class' => $class, 'options' => $options];
        }

        if(!isset($items['model']))
            return $model;

        $class  = $items['model']['class'];

        $where = isset($items['model']['where']) ? $items['model']['where'] : [];
        $data   = $class::find()->where($where)->all();

        $model->config = Json::encode(ArrayHelper::map( $data,
            $items['model']['map']['key'],
            $items['model']['map']['value']
        ),true);

        return $model;
    }
}
