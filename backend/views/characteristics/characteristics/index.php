<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $language_id */
/* @var $content_id */
/* @var $type_characteristics_id */
/* @var $this yii\web\View */
/* @var $searchModel backend\models\characteristics\CharacteristicsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Characteristics');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristics-index">
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
