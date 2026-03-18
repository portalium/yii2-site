<?php

namespace portalium\site\bundles;

use yii\web\AssetBundle;

class ToastifyAsset extends AssetBundle
{
    public $sourcePath = '@vendor/portalium/yii2-site/src/assets/';

    public $css = [
        'plugins/toastify/css/toastify.css',
    ];

    public $js = [
        'plugins/toastify/js/toastify.js',
    ];

    public $depends = [
        'portalium\site\bundles\AppAsset',
    ];
}
