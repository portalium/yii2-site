<?php

use yii\db\Migration;
use portalium\site\models\Form;
use Yii;
use yii\helpers\ArrayHelper;

class m010101_010102_site_setting extends Migration
{
    public function up()
    {
        $roles = ArrayHelper::map(
            Yii::$app->authManager->getRoles(),
            'name',
            'name'
        );

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'default::role',
            'label' => 'Default Role',
            'value' => 'admin',
            'type' => Form::TYPE_DROPDOWNLIST,
            'config' => json_encode([
                'model' => [
                    'class' => 'portalium\site\models\DbManager', 
                    'map' => [
                        'key' => 'name' ,
                        'value' => 'name'
                    ]
                ]
            ])
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'admin::user_role',
            'label' => 'Default User Role',
            'value' => '0',
            'type' => Form::TYPE_DROPDOWNLIST,
            'config' => json_encode([
                'model' => [
                    'class' => 'portalium\site\models\DbManager', 
                    'map' => [
                        'key' => 'name' ,
                        'value' => 'name'
                    ]
                ]
            ])
        ]);
    }

    public function down()
    {
        $this->dropTable('site_setting');
    }
}
