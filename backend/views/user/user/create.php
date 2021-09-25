<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\user\User */
/* @var $profile backend\models\user\UserProfile */

$this->title = Yii::t('backend', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
        'profile' => $profile,
    ]) ?>

</div>

