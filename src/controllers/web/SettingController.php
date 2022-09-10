<?php

namespace portalium\site\controllers\web;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use portalium\web\Controller as WebController;
use portalium\site\Module;
use portalium\site\models\SettingSearch;
use portalium\site\models\Setting;

class SettingController extends WebController
{
    public function actionIndex()
    {
        if(!Yii::$app->user->can('siteWebSettingIndex')){
            throw new \yii\web\ForbiddenHttpException(Module::t('You are not allowed to access this page.'));
        }
        $settings = Setting::find()
            ->orderBy(['module' => SORT_ASC,'id' => SORT_ASC,'name'=>SORT_ASC])
            ->indexBy('id')
            ->all();
       
        return $this->render('index', [
            'settings' => $settings,
        ]);
    }

    public function actionUpdate()
    {
        if(!Yii::$app->user->can('siteWebSettingUpdate')){
            throw new \yii\web\ForbiddenHttpException(Module::t('You are not allowed to access this page.'));
        }
        $settings = Setting::find()->indexBy('id')->all();
        Yii::warning(Yii::$app->request->post());
        if (Model::loadMultiple($settings, Yii::$app->request->post()) && Model::validateMultiple($settings)) {
            foreach ($settings as $setting) {
                Yii::warning($setting->id.':'.$setting->value);
                $setting->save(false);
            }
            Yii::$app->session->setFlash('success', Module::t('Settings saved.'));
        }else{
            Yii::$app->session->setFlash('error', Module::t('There are an error. Settings not saved.'));
        }

        return $this->redirect('index');
    }
}
