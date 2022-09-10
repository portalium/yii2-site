<?php

namespace portalium\site\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use portalium\site\Module;
use portalium\theme\widgets\Nav;

class Language extends Widget
{
    public $options;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $languages = Yii::$app->setting->getConfig('app::language');
        $langItems = [];

        foreach ($languages as $key => $value){
            $langItems[] = [
                'label' => Module::t($value),
                'url' => ['/site/home/lang','lang' => $key]
            ];
        }

        $menuItems[] = [
            'label' => Module::t($languages[Yii::$app->language]),
            'url' => ['/site/home/lang','lang' => Yii::$app->language],
            'items' => $langItems,
        ];

        return Nav::widget([
            'options' => $this->options,
            'items' => $menuItems,
        ]);
    }
}
