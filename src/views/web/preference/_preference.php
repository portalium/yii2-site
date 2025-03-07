<?php

use portalium\site\Module;
use portalium\site\models\Form;
use portalium\site\helpers\ActiveForm as PreferenceForm;

?>

<?php foreach ($settings as $setting) : ?>
    <?php if(Form::TYPE_INPUTHIDDEN != $setting->type): ?>
        <?= PreferenceForm::field($form, $setting, $setting->module. '-' .$setting->id, Module::t($setting->label)) ?>
    <?php endif; ?>
<?php endforeach; ?>
