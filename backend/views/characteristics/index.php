<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CharacteristicsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Characteristics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristics-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Characteristics', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?//= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'value' => function ($data) {
                    $name = unserialize($data->name);
                    $params = Yii::$app->params['languages'];
                    $firstKey = current($params);
                    return $name[$firstKey];
                },
                'format' => 'html'
            ],

            [
                'attribute' => 'filter_status',
                'value' => function ($data) {
                    return $data->filter_status == 1 ? '<span class="text-success">Да</span>' : '<span class="text-danger">Нет</span>';
                },
                'format' => 'raw'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
