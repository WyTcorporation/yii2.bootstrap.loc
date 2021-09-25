<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 07.09.2021
 * Time: 19:56
 * User: WyTcorporation
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = Yii::t('frontend', 'Profile');

?>

<div id="account-account" class="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="row">
        <div id="content" class="col-sm-12">
            <h2><?= Yii::t('frontend', 'My account'); ?></h2>
            <ul class="list-unstyled">
                <li>
                    <?= Html::a(Yii::t('frontend', 'Change contact information?'), ['profile/contact','id'=>$user->id]) ?>
                </li>
                <li>
                    <?= Html::a(Yii::t('frontend', 'Change your password'), ['profile/password','id'=>$user->id]) ?>
                </li>
                <li>
                    <?= Html::a(Yii::t('frontend', 'Change my address'), ['profile/address','id'=>$user->id]) ?>
                </li>
                <li>
                    <?= Html::a(Yii::t('frontend', 'Favorites'), ['wishlist/view', 'id' => $user->id]) ?>
                </li>
                <li>
                    <?= Html::a(Yii::t('frontend', 'History of orders'), ['orders/index', 'id' => $user->id]) ?>
                </li>
            </ul>

            <h2><?= Yii::t('frontend', 'Output'); ?></h2>
            <ul class="list-unstyled">
                <li>
                    <?= Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        Yii::t('frontend', 'Output').' (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    ). Html::endForm() ?>
                </li>
            </ul>
        </div>
    </div>
</div>
