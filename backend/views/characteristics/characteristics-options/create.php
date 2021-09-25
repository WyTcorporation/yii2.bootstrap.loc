<?php

use yii\helpers\Html;

/* @var $language_id */
/* @var $content_id */
/* @var $params */
/* @var $type_id */
/* @var $translation */
/* @var $translations */

/* @var $this yii\web\View */
/* @var $model backend\models\characteristics\CharacteristicsOptions */

$this->title = Yii::t('backend', 'Create Characteristic Options');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Characteristics Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="characteristics-options-create">

    <?= $this->render('_form', [
        'model' => $model,
        'params' => $params,
        'type_id' => $type_id,
        'language_id' => $language_id,
        'content_id' => $content_id,
        'translation' => $translation,
        'translations' => $translations = null,
    ]) ?>

</div>
