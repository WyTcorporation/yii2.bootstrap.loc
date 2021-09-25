<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 11:11
 * User: WyTcorporation
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $result */

$this->params['breadcrumbs'][] = $result['name']->content;


?>
<div id="information-information" class="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="row">
        <div id="content" class="col-sm-12">
            <?=$result['content']->content?>
        </div>
    </div>
</div>