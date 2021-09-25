<?php

use yii\helpers\Html;

/* @var $language_id */
/* @var $content_id */
/* @var $params */
/* @var $type_id */
/* @var $translation */
/* @var $translations */
/* @var $type_characteristics_options_id */

/* @var $this yii\web\View */
/* @var $model backend\models\characteristics\CharacteristicsOptions */

$model->language_id = $language_id;
$model->content_id = $content_id;
$model->type_id = $type_characteristics_options_id;

$name = $model->translation->content ? $model->translation->content : $model->content;

$this->title = Yii::t('backend', 'Update Characteristics Options').': ' . $name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Characteristics Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/buttons', 'Update');
?>
<div class="characteristics-options-update">

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'type_id' => $type_id,
        'language_id' => $language_id,
        'content_id' => $content_id,
        'translation' => $translation,
        'translations' => $translations,
    ]) ?>

</div>
