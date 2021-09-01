<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CharacteristicsOptionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Characteristics Options';
$this->params['breadcrumbs'][] = $this->title;


//$input  = [];
//$results = array_unique($input);
//sort($results);
//$params = Yii::$app->params['languages'];
//
//foreach($results as $result) {
//    $item = new \backend\models\CharacteristicsOptions();
//    $item->characteristics_id = 5;
//    foreach($params as $param) {
//        $names[$param] = $result;
//    }
//    $item->name = serialize($names);
//    $item->save();
//}

?>
<div class="characteristics-options-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Characteristics Options', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_search', [
        'model' => $searchModel,
        'params' => $params,
        'language' => $language]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'characteristics_id',
                'value' => function ($data) {
                    $name = unserialize($data->characteristics->name);
                    $params = Yii::$app->params['languages'];
                    $firstKey = current($params);
                    return $name[$firstKey];
                },
                'format' => 'html'
            ],
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
