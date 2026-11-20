<?php

namespace portalium\site\controllers\api;

use portalium\site\models\Setting;
use portalium\site\Module;
use Yii;
use yii\web\HttpException;
use portalium\user\models\User;
use portalium\site\models\SignupForm;
use portalium\site\models\LoginForm;
use portalium\rest\ActiveController as RestActiveController;
use yii\web\ForbiddenHttpException;

class SettingController extends RestActiveController
{
    public $modelClass = 'portalium\site\models\Setting';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            'searchModel' => $this->modelClass,
        ];
        $actions['index']['prepareDataProvider'] = function ($action) {
            if(!Yii::$app->user->can('siteAPISettingIndex'))
                throw new ForbiddenHttpException('You are not allowed to access this page.');

            $model = new $this->modelClass;
            $query = $model::find();
            $dataProvider = new \portalium\data\ActiveDataProvider([
                'query' => $query,
            ]);

            return $dataProvider;
        };
        return $actions;
    }

    /**
     * Access control for the inherited view/create/update/delete actions. checkAccess() was
     * previously empty, letting any user change settings (e.g. site::user_role) to escalate privileges.
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if ($action === 'index') {
            return;
        }
        $allowed = $action === 'view'
            ? Yii::$app->user->can('siteAPISettingIndex') || Yii::$app->user->can('siteWebSettingIndex')
            : Yii::$app->user->can('siteWebSettingUpdate');
        if (!$allowed) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
    }

    protected function verbs()
    {
        return array_merge(parent::verbs(), [
            'privacy' => ['GET'],
            'support' => ['GET'],
            'app-info' => ['GET'],
        ]);
    }

    /**
     * privacy, support and app-info are open to every authenticated user (e.g. the mobile app),
     * unlike the admin-only CRUD actions above. checkAccess() is not called for them on purpose.
     */
    public function actionPrivacy()
    {
        return [
            'privacy_policy_url' => $this->getSettingValue('site::privacy_policy_url'),
        ];
    }

    public function actionSupport()
    {
        return [
            'support_url' => $this->getSettingValue('site::support_url'),
        ];
    }

    public function actionAppInfo()
    {
        return [
            'privacy_policy_url' => $this->getSettingValue('site::privacy_policy_url'),
            'support_url' => $this->getSettingValue('site::support_url'),
        ];
    }

    private function getSettingValue($name)
    {
        try {
            $value = Yii::$app->setting->getValue($name);
        } catch (\Throwable $e) {
            Yii::warning("Setting '{$name}' could not be read: " . $e->getMessage(), __METHOD__);
            return null;
        }

        return ($value === '' || $value === null) ? null : $value;
    }
}
