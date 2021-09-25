<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 28.08.2021
 */

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $model  */
/* @var $message  */

$this->title = Yii::t('backend', 'Updating Products');
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<?php Pjax::begin(['id' => 'csv']); ?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
    ],
]);

?>

<div class="projects content__wrap">
    <div class="preloader" style="display: none">
        <div class="lds-dual-ring"></div>
    </div>
    <p><?= $message ?></p>
    <div class="">
        <div class="box__table projects">
            <?= $form->field($model, 'imageFile')->fileInput()->label(Yii::t('backend/buttons', 'Download'), ['class' => 'akb-csv']) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend/buttons', 'Download'), ['class' => 'btn btn-primary download-btn', 'id' => 'download-akb-csv', 'name' => 'download-akb-csv', 'value' => 'download-akb-csv', 'data-pjax' => 1]) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?php Pjax::end() ?>
<?php
$script = <<< JS
 $(document).on('pjax:send', function() {
        $('.preloader').show()
    })
    $(document).on('pjax:complete', function() {
        $('.preloader').hide()
    })
JS;
$this->registerJs($script);
?>
