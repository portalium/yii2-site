<?php

use portalium\site\Module;
use portalium\site\models\Form;
use portalium\site\helpers\ActiveForm as SettingForm;

?>

<?php foreach ($settings as $setting) : ?>
    <?php if(Form::TYPE_INPUTHIDDEN != $setting->type): ?>
            <?= SettingForm::field($form, $setting, $setting->module. '-' .$setting->id, Module::t($setting->label)) ?>
    <?php endif; ?>
<?php endforeach; ?>