<?php

namespace portalium\site\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Brand extends Widget
{
    public $logo    = false;
    public $title   = false;
    public $auto    = true;
    public $options;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $img = Yii::$app->setting->getValue('app::logo');
        $brand =  ($this->title) ? Html::encode(Yii::$app->setting->getValue('app::title')):"";
        if($this->auto && isset($img['name'])){
            $brand = Html::img(Yii::$app->request->baseUrl.'/data/'.strval($img['name']), $this->options);
        }else{
            $brand = (isset($img['name']) && $this->logo) ? Html::img(Yii::$app->request->baseUrl.'/data/'.strval($img['name']), $this->options):"";
            $brand .=  ($this->title) ? Html::encode(Yii::$app->setting->getValue('app::title')):"";
        }
        return $brand;
    }
}
