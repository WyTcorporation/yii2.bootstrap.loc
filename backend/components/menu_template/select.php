<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 15.03.2020
 * Time: 19:11
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */
$language = Yii::$app->sourceLanguage;

?>
<option value="<?= $category['id'] ?>" <?= $category['id'] == $this->model->id ? 'disabled' : '' ?> <?= $category['id'] == $this->model->parent_id ? 'selected' : '' ?>><?= $tab . $category['name'] ?></option>
<?php if (isset($category['childs'])): ?>
    <?= $this->getMenuHtml($category['childs'], $tab . ' - ') ?>
<?php endif; ?>

