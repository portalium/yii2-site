<?php

use portalium\site\bundles\AppAsset;
use yii\helpers\Html;
use yii\captcha\Captcha;
use portalium\theme\widgets\ActiveForm;
use portalium\site\Module;

$this->title = Module::t('Signup');
AppAsset::register($this);
?>
<div class="site-signup">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h3 mb-3 fw-normal text-center"><?= Html::encode($this->title) ?></h1>

                    <?php $form = ActiveForm::begin([
                        'id' => 'form-signup',
                        'options' => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'horizontalCssClasses' => [
                                'label' => 'col-sm-4',
                                'wrapper' => 'col-sm-8',
                            ],
                            'template' => "{input}\n{hint}\n{error}",
                            'labelOptions' => ['style' => 'margin-top: 10px;'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'username', ['options' => ['class' => 'form-attribute mb-3 row']])->textInput(['autofocus' => true, 'class' => 'form-control form-control-lg', 'placeholder' => Module::t('Username')]) ?>
                    <?= $form->field($model, 'email', ['options' => ['class' => 'form-attribute mb-3 row']])
                        ->textInput(['class' => 'form-control form-control-lg', 'placeholder' => Module::t('Email')]) ?>
                    <?= $form->field($model, 'password', ['options' => ['class' => 'form-attribute mb-3 row']])->passwordInput(['class' => 'form-control form-control-lg', 'placeholder' => Module::t('Password')]) ?>
                    <?= $form->field($model, 'verifyCode')->widget(
                        \himiklab\yii2\recaptcha\ReCaptcha3::className(),
                        [
                            'siteKey' => '6LdtOVspAAAAAGGnMu_yPK2hlyyNAjmiQJz0v7Ws', // unnecessary is reCaptcha component was set up
                            'action' => 'signup',
                        ]
                    ) ?>
                    <div class="d-grid" style="margin-left:10px; margin-right:10px;">
                        <?= '<div class = "clearfix"></div>' . Html::submitButton(Module::t('Signup'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
