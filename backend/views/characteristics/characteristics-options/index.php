<?php

use backend\models\characteristics\Characteristics;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $language_id */
/* @var $content_id */
/* @var $type_characteristics_options_id */
/* @var $type_characteristics_id */

/* @var $this yii\web\View */
/* @var $searchModel backend\models\characteristics\CharacteristicsOptionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Characteristics Options');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristics-options-index">

    <?php

    $characteristics = Characteristics::find()->all();
    $names = null;
    foreach ($characteristics as $key => $characteristic) {
        $characteristic->language_id = $language_id;
        $characteristic->content_id = $content_id;
        $characteristic->type_id = $type_characteristics_id;
        $names[$characteristic->id] = $characteristic->translation->content;
    }

    ?>

    <?= $this->render('_search', ['model' => $searchModel,'names'=>$names]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'characteristics_id',
                'filter' => $names,
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
