<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\blog\Blog */
/* @var $params */
/* @var $language */
/* @var $translations */

$this->title = Yii::t('backend', 'Update Blog').': ' . $translations[$language]['name']->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $translations[$language]['name']->content, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend/buttons', 'Update');
?>
<div class="blog-update">

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'translations' => $translations,
    ]) ?>

</div>
