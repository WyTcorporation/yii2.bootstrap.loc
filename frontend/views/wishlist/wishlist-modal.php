<?php
/**
 * name: Vladyslav Gladyr
 * email: wild.savedo@gmail.com
 * site: lockit.com
 * 13.07.2020
 */

use frontend\models\Product;
use yii\helpers\Url;


$params = Yii::$app->params['languages'];
$language = Yii::$app->language;
?>

<?php if (!empty($name)): ?>
    <h1><?= Yii::t('frontend', 'Product: {name} Added to wishlist!',['name'=>$name]) ?></h1>
<?php endif; ?>
