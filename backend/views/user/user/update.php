<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\user\User */
/* @var $profile backend\models\user\UserProfile */

$this->title = Yii::t('backend', 'Update User').': ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/buttons', 'Update');
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
        'profile' => $profile,
    ]) ?>

</div>
