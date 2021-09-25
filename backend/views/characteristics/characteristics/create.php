<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\characteristics\Characteristics */
/* @var $params */


/* @var $translation */
/* @var $translations */

$this->title = Yii::t('backend', 'Create Characteristics');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Characteristics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristics-create">

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'translation' => $translation,
        'translations' => $translations,
    ]) ?>

</div>
