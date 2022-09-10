<?php

namespace portalium\site\controllers\api;

use portalium\site\models\Setting;
use portalium\site\Module;
use Yii;
use yii\web\HttpException;
use portalium\user\models\User;
use portalium\site\models\SignupForm;
use portalium\site\models\LoginForm;
use portalium\rest\Controller as RestController;

class AuthController extends RestController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['login','signup'];

        return $behaviors;
    }

    public function actionLogin()
    {
        if(!Setting::findOne(['name' => 'api::login'])->value)
            return $this->error(['APILogin' => Module::t("Login denied with API")]);

        $model = new LoginForm();
        if($model->load(Yii::$app->getRequest()->getBodyParams(),'')) {
            if ($model->login()) {
                $user = User::findIdentity(Yii::$app->user->identity->id);
                return $this->getUserData($user);
            } else
                return $this->modelError($model);
        }else{
            return $this->error(['LoginForm' => Module::t("Username (username) and Password (password) required.")]);
        }
	}

	public function actionSignup()
	{
	    if(!Setting::findOne(['name' => 'api::signup'])->value)
            return $this->error(['APISigup' => Module::t("Signup denied with API")]);

        $model = new SignupForm();

        if($model->load(Yii::$app->getRequest()->getBodyParams(),'')) {
            if($user = $model->signup()){
                return $this->getUserData($user);
            }
            else
                return $this->modelError($model);
        }else{
            return $this->error(['SignupForm' => Module::t("Username (username), Password (password) and Email (email) required.")]);
        }
	}

    protected function getUserData($user) {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'created_at' => $user->created_at,
            'access_token' => $user->access_token
        ];
    }
}
