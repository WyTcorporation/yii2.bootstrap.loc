<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 21.09.2021
 * Time: 08:40
 * User: WyTcorporation, WyTcorp, WyTco
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;

/* @var $news */
/* @var $language */
/* @var $translations */

$this->title = $translations[$language]['name']->content;
$this->params['breadcrumbs'][] = ['label' =>  Yii::t('frontend', 'News'), 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container news-list">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="col-md-12">
        <div class="row">
            <h1><?= $translations[$language]['name']->content ? $translations[$language]['name']->content : ''?></h1>
            <div><?= $translations[$language]['content']->content ? $translations[$language]['content']->content : ''?></div>
        </div>
    </div>
</div>
