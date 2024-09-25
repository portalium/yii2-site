<?php

namespace portalium\site\helpers;

use Yii;



class Route 
{

    public static function createUrlWeb($route, $params= []){
        $url= Yii::$app->urlManager->createAbsoluteUrl(array_merge([$route], $params));
        return str_replace('/api' , '' ,$url);
    }





}