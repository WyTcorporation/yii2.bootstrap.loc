<?php

use yii\helpers\Html;

/* @var $params */
/* @var $translation */
/* @var $translations */


/* @var $this yii\web\View */
/* @var $model backend\models\pages\Pages */

$this->title = Yii::t('backend', 'Create Pages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-create">
    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'translation' => $translation,
        'translations' => $translations,
    ]) ?>

</div>
