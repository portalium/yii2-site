<?php

namespace portalium\site\controllers\api;


use portalium\site\Module;
use Yii;
use portalium\user\models\User;
use portalium\site\models\SignupForm;
use portalium\site\models\LoginForm;
use portalium\rest\Controller as RestController;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use InvalidArgumentException;
use portalium\site\models\VerifyEmailForm;

class AuthController extends RestController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['login', 'signup'];

        return $behaviors;
    }
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {

            $userId = Yii::$app->user->id;
            $userModel = User::findOne($userId);
            $userModel->email_verify = User::EMAIL_VERIFY;
            $userModel->save();

            return $this->goHome();
        }
        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    public function actionLogin()
    {
        if (!Yii::$app->setting->getValue(['api::login']))
            return $this->error(['APILogin' => Module::t("Login denied with API")]);

        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            if ($model->login()) {
                $user = User::findIdentity(Yii::$app->user->identity->id);
                return $this->getUserData($user);
            } else
                return $this->modelError($model);
        } else {
            return $this->error(['LoginForm' => Module::t("Username (username) and Password (password) required.")]);
        }
    }

    public function actionSignup()
    {
        if (!Yii::$app->setting->getValue('api::signup'))
        
            return $this->error(['APISigup' => Module::t("Signup denied with API")]);

        $model = new SignupForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            if ($user = $model->signup()) {
                return $this->getUserData($user);
            } else
                return $this->modelError($model);
        } else {
            return $this->error(['SignupForm' => Module::t("Username (username), Password (password) and Email (email) required.")]);
        }
    }

    protected function getUserData($user)
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'date_create' => $user->date_create,
            'access_token' => $user->access_token
        ];
    }
}
