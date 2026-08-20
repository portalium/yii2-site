<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use portalium\theme\widgets\ActiveForm;

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
        'header' => [],
        'footer' => [
            Html::submitButton(Module::t('Save'), ['class' => 'btn btn-success', 'id' => 'setting-update-submit']),
        ]
    ]
]) ?>

<?php
$tabsData = [];
foreach ($settingsGroup as $module => $items) {
    $tabsData[] = [
        'label' => Yii::$app->getModule($module)->t(Yii::$app->getModule($module)::$name),
        'content' => $this->render('_setting', ['settings' => $items, 'form' => $form]),
    ];
}

echo \portalium\theme\widgets\Tabs::widget([
    'items' => $tabsData,
    'options' => [
        'class' => 'nav-tabs-custom',
        'style' => 'margin-bottom: 10px;'
    ],
    'id' => 'setting-tabs',
]);
?>
<?php Panel::end() ?>
<?php ActiveForm::end(); ?>

<?php
$js = <<<JS

    $('#setting-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        $('#setting-update').attr('action', $('#setting-update').attr('action').replace(/#.*$/, ''));
        $('#setting-update').attr('action', $('#setting-update').attr('action') + $(this).attr('href'));
    });

JS;
$this->registerJs($js);
?>