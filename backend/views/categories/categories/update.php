<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\categories\Categories */
/* @var $params */
/* @var $percent */
/* @var $language */
/* @var $language_id */
/* @var $type_id */
/* @var $content_id */
/* @var $categoriesCharacteristics */
/* @var $translations */

$this->title = Yii::t('backend', 'Update Categories').' : ' . $translations[$language]['name']->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $translations[$language]['name']->content, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/buttons', 'Update');
?>
<div class="categories-update">

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'percent' => $percent,
        'language_id' => $language_id,
        'type_id' => $type_id,
        'content_id' => $content_id,
        'categoriesCharacteristics' => $categoriesCharacteristics,
        'translations' => $translations,
    ]) ?>

</div>
