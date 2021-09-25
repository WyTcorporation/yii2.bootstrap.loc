<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 16.03.2020
 * Time: 15:49
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

use backend\models\products\Products;
use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\translations\Type;
use yii\helpers\Url;


$params = Yii::$app->params['languages'];
$language = Yii::$app->language;
$language_id = Languages::findOne(['code' => $language])->id;
$type_products_id = Type::findOne(['type' => 'products'])->id;
$content_id = Content::findOne(['content' => 'name'])->id;
?>

<?php if (!empty($session['cart'])): ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th scope="col"><?=  Yii::t('frontend/cart', 'photo'); ?></th>
                <th scope="col"><?=  Yii::t('frontend/cart', 'name'); ?></th>
                <th scope="col"><?=  Yii::t('frontend/cart', 'col'); ?></th>
                <th scope="col"><?=  Yii::t('frontend/cart', 'price'); ?></th>
                <th scope="col">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($session['cart'] as $id => $item): ?>
                <tr>
                    <th scope="row">
                        <img width="100px" src="<?= $item['img'] == 'no-image.png' ? '/images/'.$item['img'] : $item['img'] ?>" alt="<?= $item['name'] ?>">
                    </th>
                    <td>
                        <?php
                        if (count($params) >= 1) {
                            $product = Products::findOne($id);
                            $product->type_id = $type_products_id;
                            $product->language_id = $language_id;
                            $product->content_id = $content_id;
                            $name = $product->translation->content;
                            $slug = $product->slug;
                            $url = '/' . $language . '/product/view';
                        }
                        ?>
                        <a href="<?= Url::to(['/product/view', 'slug' => $slug]) ?>"><?= $name ?></a>
                    </td>
                    <td><?= $item['qty'] ?></td>
                    <td><?= $item['price']  ?></td>
                    <td data-id="<?= $id ?>" class="text-danger del-item">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4">Итого : </td>
                <td><?= $session['cart.qty'] ?></td>
            </tr>
            <tr>
                <td colspan="4">На сумму : </td>
                <td><?= $session['cart.sum'] ?></td>
            </tr>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <h1><?=  Yii::t('frontend/cart', 'Cart is empty'); ?></h1>
<?php endif; ?>
