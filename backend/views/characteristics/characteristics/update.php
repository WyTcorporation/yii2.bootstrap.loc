<?php

use yii\helpers\Html;

/* @var $language_id */
/* @var $content_id */
/* @var $type_characteristics_id */
/* @var $params */
/* @var $translation */
/* @var $translations */
/* @var $this yii\web\View */
/* @var $model backend\models\characteristics\Characteristics */

$model->language_id = $language_id;
$model->content_id = $content_id;
$model->type_id = $type_characteristics_id;

$this->title = Yii::t('backend', 'Update Characteristics') .': '. $model->translation->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Characteristics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->translation->content, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/buttons', 'Update');
?>
<div class="characteristics-update">

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'translation' => $translation,
        'translations' => $translations,
    ]) ?>

</div>
