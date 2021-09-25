<?php

use yii\helpers\Html;

/* @var $params */
/* @var $translation */
/* @var $translations */
/* @var $language */

/* @var $this yii\web\View */
/* @var $model backend\models\pages\Pages */

$this->title = Yii::t('backend', 'Update Pages').': ' . $translations[$language]['name']->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/buttons', 'Update');
?>
<div class="pages-update">

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'translation' => $translation,
        'translations' => $translations,
    ]) ?>

</div>
