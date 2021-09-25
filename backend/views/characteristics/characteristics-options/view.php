<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $language_id */
/* @var $content_id */
/* @var $type_characteristics_options_id */
/* @var $type_characteristics_id */

/* @var $this yii\web\View */
/* @var $model backend\models\characteristics\CharacteristicsOptions */

$model->language_id = $language_id;
$model->content_id = $content_id;
$model->type_id = $type_characteristics_options_id;

$this->title = $model->translation->content?$model->translation->content:$model->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Characteristics Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="characteristics-options-view">

    <p>
        <?= Html::a(Yii::t('backend/buttons', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend/buttons', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'characteristics_id',
                'value' => function ($model) use ($type_characteristics_id, $language_id, $content_id) {
                    $model->characteristics->language_id = $language_id;
                    $model->characteristics->content_id = $content_id;
                    $model->characteristics->type_id = $type_characteristics_id;
                    return $model->characteristics->translation->content;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'name',
                'value' => function ($model) use ($type_characteristics_options_id, $language_id, $content_id) {
                    $model->language_id = $language_id;
                    $model->content_id = $content_id;
                    $model->type_id = $type_characteristics_options_id;
                    return $model->translation->content?$model->translation->content:$model->content;
                },
                'format' => 'html'
            ],
        ],
    ]) ?>

</div>
