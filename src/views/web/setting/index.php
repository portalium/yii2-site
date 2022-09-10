<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

use portalium\site\Module;
use portalium\site\models\Setting;
use portalium\site\models\Form;
use portalium\site\helpers\ActiveForm as SettingForm;
use portalium\theme\widgets\Panel;

$this->title = Module::t('Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['action' => Url::to(['setting/update']), 'id' => 'setting-update', 'method' => 'post', 'class' => 'form-horizontal']); ?>
<?php Panel::begin([
    'title' => Module::t('Settings'),
    'actions' => [
        'header' => [
        ],
        'footer' => [
            Html::submitButton(Module::t('Save'), ['class' => 'btn btn-success']),
        ]
    ]
]) ?>
<?php foreach ($settings as $index => $setting) : ?>
    <?php if(Form::TYPE_INPUTHIDDEN != $setting->type): ?>
            <?= SettingForm::field($form, $setting, $index, Module::settingT($setting->module, $setting->label)) ?>
    <?php endif; ?>
<?php endforeach; ?>
<?php Panel::end() ?>
<?php ActiveForm::end(); ?>
