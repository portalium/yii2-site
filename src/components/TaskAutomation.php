<?php

namespace portalium\site\components;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\base\BaseObject;
use portalium\site\Module;
use diginova\task\models\Task;
use diginova\task\models\TaskData;
use diginova\task\models\TaskGroup;
use diginova\task\models\TaskAssignee;
use diginova\task\models\TaskTypeForm;
use diginova\task\models\TaskTypeHtml;

class TaskAutomation extends BaseObject
{
    public function init()
    {
        parent::init();
    }

    public function onUserCreate($event)
    {
        ['id' => $id] = $event->payload;
        $auth = Yii::$app->authManager;
        $role = Yii::$app->setting->getValue('admin::user_role');
        $role = (isset($role) && $role != '' && $role != '0') ? $auth->getRole($role) : $auth->getRole('user');
        
        if ($auth->getAssignment('user', $id)) {
            return 'User already assigned';
        }
        $auth->assign($role, $id);
    }
}
