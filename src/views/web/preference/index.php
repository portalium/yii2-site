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


/** @var yii\web\View $this */
/** @var portalium\site\models\PreferenceSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title =Module::t('Preference');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(['action' => Url::to(['preference/update']), 'id' => 'preference-update', 'method' => 'post', 'class' => 'form-horizontal']); ?>
<?php Panel::begin([
    'title' => Module::t('Preference'),
    'actions' => [
        'header' => [
        ],
        'footer' => [
            Html::submitButton(Module::t('Save'), ['class' => 'btn btn-success', 'id' => 'pereference-update-submit']),
        ]
    ]
]) ?>

<?php
$tabsData = [];
foreach ($settingsGroup as $module => $items) {
    $tabsData[] = [
        'label' => Yii::$app->getModule($module)->t(Module::t(Yii::$app->getModule($module)::$name)),
        'content' => $this->render('_preference', ['settings' => $items, 'form' => $form]),
    ];

}

echo \portalium\theme\widgets\Tabs::widget([
    'items' => $tabsData,
    'options' => [
        'class' => 'nav-tabs-custom', 'style' => 'margin-bottom: 10px;',
    ],
    'id' => 'preference-tabs',
]);
?>
<?php Panel::end() ?>
<?php ActiveForm::end(); ?>
<?php
$js = <<<JS

    $('#preference-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        $('#preference-update').attr('action', $('#preference-update').attr('action').replace(/#.*$/, ''));
        $('#preference-update').attr('action', $('#preference-update').attr('action') + $(this).attr('href'));
    });

JS;
$this->registerJs($js);
?>
