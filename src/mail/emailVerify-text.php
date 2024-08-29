<?php

use yii\helpers\Url;

use portalium\site\helpers\Route;

/** @var yii\web\View $this */
/** @var common\models\User $user */


$verifyLink = Route::createUrlWeb('site/auth/verify-email' , [ 'token' => $user->verification_token]);
?>
    Hello <?= $user->username ?>,

    Follow the link below to verify your email:
       
<?= $verifyLink ?>