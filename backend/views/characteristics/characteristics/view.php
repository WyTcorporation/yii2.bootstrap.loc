<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $language_id */
/* @var $content_id */
/* @var $type_characteristics_id */
/* @var $this yii\web\View */
/* @var $model backend\models\characteristics\Characteristics */

$model->language_id = $language_id;
$model->content_id = $content_id;
$model->type_id = $type_characteristics_id;

$this->title =  $model->translation->content;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Characteristics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="characteristics-view">

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
                'attribute' => 'name',
                'value' => function ($model) use ($type_characteristics_id, $language_id, $content_id) {
                    $model->language_id = $language_id;
                    $model->content_id = $content_id;
                    $model->type_id = $type_characteristics_id;
                    return $model->translation->content;
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'filter_status',
                'filter' => [ Yii::t('backend/buttons', 'Not Active'), Yii::t('backend/buttons', 'Active')],
                'value' => function ($model) {
                    return $model->filter_status == 1 ? '<span class="text-success">' . Yii::t('backend/buttons', 'Active') . '</span>' : '<span class="text-danger">' . Yii::t('backend/buttons', 'Not Active') . '</span>';
                },
                'format' => 'html'
            ],
        ],
    ]) ?>

</div>
