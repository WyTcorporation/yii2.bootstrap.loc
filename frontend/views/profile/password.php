<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 07.09.2021
 * Time: 20:48
 * User: WyTcorporation
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = ['label' => Yii::t('frontend', 'Personal Area'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= Yii::t('frontend', 'Output'); ?>
<div id="account-password" class="container">
    <?=
    Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]
    ) ?>
    <div class="row">
        <div id="content" class="col-sm-9">
            <h1><?= Yii::t('frontend', 'Viewed products'); ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => [
                'class' => 'form-horizontal'
            ]]); ?>

            <fieldset>
                <legend><?= Yii::t('frontend', 'Your account'); ?></legend>

                <?= $form->field($user, 'password')->textInput(['autofocus' => true, 'class' => 'col-sm-10 profile'])->label(Yii::t('frontend', 'password'), ['class' => 'col-sm-2 control-label']) ?>

            </fieldset>

            <div class="buttons clearfix">
                <div class="pull-left">
                    <?= Html::a(Yii::t('frontend/buttons', 'backButton'), ['profile/index'], ['class' => 'btn btn-default']) ?>
                </div>
                <div class="pull-right">
                    <?= Html::submitButton(Yii::t('frontend/buttons', 'proceedButton'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <aside id="column-right" class="col-sm-3 hidden-xs">
            <div class="list-group">
                <?= Html::a(Yii::t('frontend', 'my info'), ['profile/index'], ['class' => 'list-group-item']) ?>
                <?= Html::a(Yii::t('frontend', 'Change contact information'), ['profile/contact', 'id' => $user->id], ['class' => 'list-group-item']) ?>
                <?= Html::a(Yii::t('frontend', 'password'), ['profile/password', 'id' => $user->id], ['class' => 'list-group-item active']) ?>
                <?= Html::a(Yii::t('frontend', 'The address book'), ['profile/address', 'id' => $user->id], ['class' => 'list-group-item']) ?>
                <?= Html::a(Yii::t('frontend', 'Favorites'), ['wishlist/view', 'id' => $user->id], ['class' => 'list-group-item']) ?>
                <?= Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    Yii::t('frontend', 'Output').' (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                ). Html::endForm() ?>
            </div>
        </aside>
    </div>
</div>
