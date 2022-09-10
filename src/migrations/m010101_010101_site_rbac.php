<?php
use yii\db\Migration;

class m010101_010101_site_rbac extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        // add "viewUser" permission
        $siteWebSettingIndex = $auth->createPermission('siteWebSettingIndex');
        $siteWebSettingIndex->description = 'siteWebSettingIndex';
        $auth->add($siteWebSettingIndex);

        // add "viewGroup" permission
        $siteWebSettingUpdate = $auth->createPermission('siteWebSettingUpdate');
        $siteWebSettingUpdate->description = 'siteWebSettingUpdate';
        $auth->add($siteWebSettingUpdate);

    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        $auth->remove($auth->getPermission('siteWebSettingIndex'));
        $auth->remove($auth->getPermission('siteWebSettingUpdate'));

    }
}