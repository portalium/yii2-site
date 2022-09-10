<?php

use yii\db\Migration;
use portalium\site\models\Form;

class m010101_010101_site_setting extends Migration
{
    public function up()
    {
        $this->createTable('site_setting', [
            'id' => $this->primaryKey(),
            'module' => $this->string(64)->notNull(),
            'name' => $this->string(64)->notNull(),
            'label' => $this->string(64)->notNull(),
			'value' => $this->text(),
            'type' => $this->tinyInteger(1)->notNull(),
            'config' => $this->text(),
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'app::title',
            'label' => 'Title',
            'value' => 'Portalium',
            'type' => Form::TYPE_INPUTTEXT,
            'config' => ''
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'app::language',
            'label' => 'Language',
            'value' => 'en-US',
            'type' => Form::TYPE_DROPDOWNLIST,
            'config' => json_encode([ 'en-US' => 'English','tr-TR' => 'Turkish'])
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'page::home',
            'label' => 'Home Page',
            'value' => '0',
            'type' => Form::TYPE_DROPDOWNLIST,
            'config' => json_encode([
                'model' => [
                    'class' => 'portalium\content\models\Content', 
                    'map' => [
                        'key' => 'id_content' ,
                        'value' => 'name'
                    ],
                    'where' => [
                        'status' => '10'
                    ]
                ]
            ])
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'app::logo',
            'label' => 'Application Logo',
            'value' => '0',
            'type' => Form::TYPE_WIDGET,
            'config' => json_encode([
                'widget' => '\portalium\storage\widgets\FilePicker',
                'options' => [
                    'multiple' => 0,
                    'returnAttribute' => ['name']
                ]
            ])
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'form::signup',
            'label' => 'Signup Form',
            'value' => '1',
            'type' => Form::TYPE_RADIOLIST,
            'config' => json_encode([ 1 => 'Show', 0 => 'Hide'])
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'form::login',
            'label' => 'Login Form',
            'value' => '1',
            'type' => Form::TYPE_RADIOLIST,
            'config' => json_encode([ 1 => 'Show', 0 => 'Hide'])
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'form::contact',
            'label' => 'Contact Form',
            'value' => '1',
            'type' => Form::TYPE_RADIOLIST,
            'config' => json_encode([ 1 => 'Show', 0 => 'Hide'])
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'api::signup',
            'label' => 'API Signup',
            'value' => '1',
            'type' => Form::TYPE_RADIOLIST,
            'config' => json_encode([ 1 => 'Allow', 0 => 'Deny'])
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'api::login',
            'label' => 'API Login',
            'value' => '1',
            'type' => Form::TYPE_RADIOLIST,
            'config' => json_encode([ 1 => 'Allow', 0 => 'Deny'])
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'email::address',
            'label' => 'Email Address',
            'value' => 'info@portalium.dev',
            'type' => Form::TYPE_INPUT,
            'config' => 'email'
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'email::displayname',
            'label' => 'Email Display Name',
            'value' => 'Portal',
            'type' => Form::TYPE_INPUTTEXT,
            'config' => ''
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'smtp::server',
            'label' => 'SMTP Server',
            'value' => 'smtp.gmail.com',
            'type' => Form::TYPE_INPUTTEXT,
            'config' => ''
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'smtp::port',
            'label' => 'SMTP Port',
            'value' => '465',
            'type' => Form::TYPE_INPUTTEXT,
            'config' => ''
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'smtp::username',
            'label' => 'SMTP Username',
            'value' => '',
            'type' => Form::TYPE_INPUTTEXT,
            'config' => ''
        ]);

        $this->insert('site_setting',[
            'module' => 'site',
            'name' => 'smtp::password',
            'label' => 'SMTP Password',
            'value' => '',
            'type' => Form::TYPE_INPUTPASSWORD,
            'config' => ''
        ]);

        $this->insert('site_setting', [
            'module' => 'site',
            'name' => 'smtp::encryption',
            'label' => 'SMTP Encryption',
            'value' => 'ssl',
            'type' => Form::TYPE_RADIOLIST,
            'config' => json_encode(['ssl' => 'SSL','tls' => 'TLS'])
        ]);

    }

    public function down()
    {
        $this->dropTable('site_setting');
    }
}
