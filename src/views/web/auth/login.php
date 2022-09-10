<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use portalium\site\Module;

$this->title = Module::t('Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Module::t('Please fill out the following fields to login:') ?></p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox()->label(Module::t('Remember Me')) ?>
                <div style="color:#999;margin:1em 0">
                    <?= Html::a(Module::t('Forgot Password!'), ['/site/auth/request-password-reset']) ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton(Module::t('Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>