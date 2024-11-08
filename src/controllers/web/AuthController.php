<?php

namespace portalium\site\controllers\web;

use Exception;
use InvalidArgumentException;
use portalium\site\models\ResendVerificationEmailForm;
use Yii;
use portalium\site\Module;
use yii\filters\AccessControl;
use yii\base\InvalidParamException;
use portalium\site\models\LoginForm;
use yii\web\BadRequestHttpException;
use portalium\site\models\SignupForm;
use portalium\user\models\User;
use portalium\site\models\ResetPasswordForm;
use portalium\web\Controller as WebController;
use portalium\site\models\PasswordResetRequestForm;
use portalium\site\models\VerifyEmailForm;

class AuthController extends WebController
{
    public $layout = '@portalium/theme/layouts/main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup', 'request-password-reset', 'reset-password'],
                'rules' => [
                    [
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    //beforeAction
    public function beforeAction($action)
    {
        if (Yii::$app->setting->getValue('auth::layout') != '')
            $this->layout = '@portalium/theme/layouts/' . Yii::$app->setting->getValue('auth::layout');

        return parent::beforeAction($action);
    }

    /*  public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ]
        ];
    }
*/

    public function actionIndex()
    {
        return $this->redirect('login');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->setting->getValue('app::language')) {
                Yii::$app->session->set('lang', Yii::$app->setting->getValue('app::language'));
            }
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
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
            $userModel->status = Yii::$app->setting->getValue('site::userStatus');
            $userModel->save();

            return $this->goHome();
        }
        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSignup()
    {
        if (Yii::$app->setting->getValue('form::signup')) {
            $model = new SignupForm();
            if ($model->load(Yii::$app->request->post())) {
                if ($user = $model->signup()) {
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->goHome();
                    }
                }
            }
            return $this->render('signup', [
                'model' => $model,
            ]);
        }
        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->addFlash('success', Module::t('Check your email for further instructions.'));
                return $this->goHome();
            } else {
                Yii::$app->session->addFlash('error', Module::t('Sorry, we are unable to reset password for the provided email address.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->addFlash('success', Module::t('New password saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
