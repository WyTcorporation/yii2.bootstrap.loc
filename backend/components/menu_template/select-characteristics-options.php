<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 27.08.2021
 */

$language = Yii::$app->sourceLanguage;
$name = unserialize($category['name'])[$language];
p($category);
?>
<option value="<?= $category['id'] ?>" <?= $category['id'] == $this->model->id ? 'disabled' : '' ?> <?= $category['id'] == $this->model->characteristics_id ? 'selected' : '' ?>><?= $tab .$name ?></option>
<?php //if (isset($category['childs'])): ?>
<!--    --><?//= $this->getMenuHtml($category['childs'], $tab . ' - ') ?>
<?php //endif; ?>

