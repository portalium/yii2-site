<?php

namespace portalium\site;

use Yii;
use portalium\user\Module as UserModule;
use portalium\site\components\TaskAutomation;

class Module extends \portalium\base\Module
{
    const EVENT_ON_LOGIN = 'siteAfterLogin';
    const EVENT_ON_SIGNUP = 'siteAfterSignup';

    public $apiRules = [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => [
                'site/auth',
            ]
        ],
    ];

    public static $tablePrefix = 'site_';

    public function getMenuItems(){
        $menuItems = [
            [
                [
                    'menu' => 'web',
                    'type' => 'widget',
                    'label' => 'portalium\site\widgets\LoginButton',
                    'name' => 'Login',
                ],
                [
                    'menu' => 'web',
                    'type' => 'widget',
                    'label' => 'portalium\site\widgets\Language',
                    'name' => 'Language',
                ],
                [
                    'menu' => 'web',
                    'type' => 'action',
                    'route' => '/site/setting/index',
                ]
            ],
        ];
        return $menuItems;
    }

    public static function moduleInit()
    {
        self::registerTranslation('site','@portalium/site/messages',[
            'site' => 'site.php',
        ]);
    }

    public function registerComponents()
    {
        return [
            'theme' => [
                'class' => 'portalium\theme\Theme',
            ],
            'setting' => [
                'class' => 'portalium\site\components\Setting',
            ]
        ];
    }

    public static function t($message, array $params = [])
    {
        return parent::coreT('site', $message, $params);
    }

    public static function settingT($category, $message, array $params = [])
    {
        self::registerTranslation($category,'@portalium/'. $category .'/messages',[
            $category => $category.'.php',
        ]);

        return parent::coreT($category, $message, $params);
    }

    public function registerEvents()
    {
        Yii::$app->on(UserModule::EVENT_USER_CREATE, [new TaskAutomation(), 'onUserCreate']);
        Yii::$app->on(self::EVENT_ON_SIGNUP, [new TaskAutomation(), 'onUserCreate']);
    }
}
