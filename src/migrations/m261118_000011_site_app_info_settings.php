<?php

use yii\db\Migration;
use portalium\site\Module;
use portalium\site\models\Form;

class m261118_000011_site_app_info_settings extends Migration
{
    public function safeUp()
    {
        $this->insert(Module::$tablePrefix . 'setting', [
            'module' => 'site',
            'name' => 'site::privacy_policy_url',
            'label' => 'Privacy Policy URL',
            'value' => '',
            'type' => Form::TYPE_INPUTTEXT,
            'is_preference' => 0,
            'config' => json_encode([
                'help' => 'Public URL of the privacy policy page shown in the mobile app.'
            ])
        ]);

        $this->insert(Module::$tablePrefix . 'setting', [
            'module' => 'site',
            'name' => 'site::support_url',
            'label' => 'Support URL',
            'value' => '',
            'type' => Form::TYPE_INPUTTEXT,
            'is_preference' => 0,
            'config' => json_encode([
                'help' => 'Public URL of the support page shown in the mobile app.'
            ])
        ]);
    }

    public function safeDown()
    {
        $this->delete(Module::$tablePrefix . 'setting', [
            'name' => [
                'site::privacy_policy_url',
                'site::support_url',
            ],
        ]);
    }
}
