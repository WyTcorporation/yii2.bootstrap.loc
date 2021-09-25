<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 15.03.2020
 * Time: 20:32
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

namespace frontend\controllers;

use backend\models\categories\Categories;
use backend\models\products\Products;
use backend\models\products\ProductsComments;
use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\translations\Type;
use Yii;

use yii\base\BaseObject;
use yii\data\Pagination;
use yii\web\HttpException;

class ProductController extends AppController
{
    public function actionNew()
    {

        //Params
        $language = Yii::$app->language;
        $params = Yii::$app->params['languages'];
        $language_id = Languages::findOne(['code' => $language])->id;
        $content_id = Content::findOne(['content' => 'name'])->id;
        $type = Type::find()->asArray()->all();

        if (isset($type) && !empty($type)) {
            for ($x = 0; $x <= count($type); $x++) {
                if ($type[$x]['type'] == 'categories') $type_categories_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'products') $type_products_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'pages') $type_pages_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'languages') $type_languages_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'characteristics') $type_characteristics_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'characteristics-options') $type_characteristics_options_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'products-models') $type_products_models_id = (int)$type[$x]['id'];
            }
        }

        $query = Products::find()->where(['new' => 1]);

        $pageSize = 16;

        if (Yii::$app->request->isPjax) {
            $isPjax = Yii::$app->request->post();
            $query = Products::find()->where(['new' => 1]);
            if (isset($isPjax['pfi_limit']) && !empty($isPjax['pfi_limit'])) {
                $pageSize = (int)$isPjax['pfi_limit'];
            }
            if (isset($isPjax['pfi_sort']) && !empty($isPjax['pfi_sort']) && $isPjax['pfi_sort'] != '') {
                $pfi_sort = $isPjax['pfi_sort'];
                if ($pfi_sort == 'ASC') {
                    $query->orderBy('name ASC');
                } elseif ($pfi_sort == 'DESC') {
                    $query->orderBy('name DESC');
                } elseif ($pfi_sort == 'PRICE_ASC') {
                    $query->orderBy('price ASC');
                } elseif ($pfi_sort == 'PRICE_DESC') {
                    $query->orderBy('price DESC');
                }
            }
        }
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => $pageSize, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $shopTitle = Yii::$app->params['shopTitle'];
        $this->setMeta(null, null, null,$shopTitle.'Новинки');

        return $this->render('new', [
            'products'=>$products,
            'pages'=>$pages,
            'isPjax'=>$isPjax,
            'params'=>$params,
            'language'=>$language,
            'language_id'=>$language_id,
            'type_products_id'=>$type_products_id,
            'type_products_models_id'=>$type_products_models_id,
            'type_characteristics_options_id'=>$type_characteristics_options_id,
            'content_id'=>$content_id,
        ]);
    }

    public function actionSale()
    {

        //Params
        $language = Yii::$app->language;
        $params = Yii::$app->params['languages'];
        $language_id = Languages::findOne(['code' => $language])->id;
        $content_id = Content::findOne(['content' => 'name'])->id;
        $type = Type::find()->asArray()->all();

        if (isset($type) && !empty($type)) {
            for ($x = 0; $x <= count($type); $x++) {
                if ($type[$x]['type'] == 'categories') $type_categories_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'products') $type_products_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'pages') $type_pages_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'languages') $type_languages_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'characteristics') $type_characteristics_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'characteristics-options') $type_characteristics_options_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'products-models') $type_products_models_id = (int)$type[$x]['id'];
            }
        }

        $query = Products::find()->where(['sale' => 1]);

        $pageSize = 16;

        if (Yii::$app->request->isPjax) {
            $isPjax = Yii::$app->request->post();
            $query = Products::find()->where(['new' => 1]);
            if (isset($isPjax['pfi_limit']) && !empty($isPjax['pfi_limit'])) {
                $pageSize = (int)$isPjax['pfi_limit'];
            }
            if (isset($isPjax['pfi_sort']) && !empty($isPjax['pfi_sort']) && $isPjax['pfi_sort'] != '') {
                $pfi_sort = $isPjax['pfi_sort'];
                if ($pfi_sort == 'ASC') {
                    $query->orderBy('name ASC');
                } elseif ($pfi_sort == 'DESC') {
                    $query->orderBy('name DESC');
                } elseif ($pfi_sort == 'PRICE_ASC') {
                    $query->orderBy('price ASC');
                } elseif ($pfi_sort == 'PRICE_DESC') {
                    $query->orderBy('price DESC');
                }
            }
        }
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => $pageSize, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $shopTitle = Yii::$app->params['shopTitle'];
        $this->setMeta(null, null, null,$shopTitle.'Новинки');

        return $this->render('sale', [
            'products'=>$products,
            'pages'=>$pages,
            'isPjax'=>$isPjax,
            'params'=>$params,
            'language'=>$language,
            'language_id'=>$language_id,
            'type_products_id'=>$type_products_id,
            'type_products_models_id'=>$type_products_models_id,
            'type_characteristics_options_id'=>$type_characteristics_options_id,
            'content_id'=>$content_id,
        ]);
    }

    public function actionView($slug)
    {
        $product = Products::findOne(['slug' => $slug]);

        if (empty($product)) {
            throw new HttpException(404, Yii::t('frontend/flash', 'There is no such item!'));
        }
        //Params
        $language = Yii::$app->language;
        $params = Yii::$app->params['languages'];
        $language_id = Languages::findOne(['code' => $language])->id;
        $content_id = Content::findOne(['content' => 'name'])->id;
        $type = Type::find()->asArray()->all();
        $user_role = Yii::$app->user->identity->role;

        if (isset($type) && !empty($type)) {
            for ($x = 0; $x <= count($type); $x++) {
                if ($type[$x]['type'] == 'categories') $type_categories_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'products') $type_products_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'pages') $type_pages_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'languages') $type_languages_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'characteristics') $type_characteristics_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'characteristics-options') $type_characteristics_options_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'products-models') $type_products_models_id = (int)$type[$x]['id'];
            }
        }

        $translations = $this->getTranslationsList($product->id, 'products');

        $gallery = null;
        if (isset($product->gallery) && !empty($product->gallery)){
            $gallery = unserialize($product->gallery);
        }
        $model = null;
        if (isset($product->models_id) && !empty($product->models_id)){
            $itemModel = $product->model;
            $itemModel->content_id = $content_id;
            $itemModel->language_id = $language_id;
            $itemModel->type_id = $type_products_models_id;
            $model = $itemModel->translation->content;
        }

        $category = null;
        $percent = null;
        if (isset($product->category) && !empty($product->category)){
            $itemCategory = $product->category;
            $itemCategory->content_id = $content_id;
            $itemCategory->language_id = $language_id;
            $itemCategory->type_id = $type_categories_id;
            $category['name'] = $itemCategory->translation->content;
            $category['slug'] = $itemCategory->slug;
            $percents = $itemCategory->categoriesPercents;
            for ($z=0;$z<=count($percents);$z++) {
                if (isset($percents[$z]) && !empty($percents[$z]) && $percents[$z]->role == $user_role){
                    $percent = $percents[$z] / 100;
                }
            }

        }

        $products = Products::find()->where(['models_id'=>$product->models_id])->all();
        $productModels = null;
        if (isset($products) && !empty($products)){
            for ($x=0;$x<=count($products);$x++) {
                if (isset($products[$x]) && !empty($products[$x])) {
                    $itemCategory = $products[$x]->category;
                    $itemCategory->content_id = $content_id;
                    $itemCategory->language_id = $language_id;
                    $itemCategory->type_id = $type_categories_id;
                    $categoryModels = $itemCategory->translation->content;
                    $translation = $this->getTranslationsList($products[$x]->id, 'products');
                    $productModels[$x]['name'] = $translation[$language]['name']->content;
                    $productModels[$x]['content'] = $translation[$language]['content']->content;
                    $productModels[$x]['category'] = $categoryModels;
                    $productModels[$x]['img'] = $products[$x]->img;
                    $productModels[$x]['price'] = $products[$x]->price;
                    $productModels[$x]['model'] = $model;
                    $productModels[$x]['vendor_code'] = $products[$x]->vendor_code;
                    $productModels[$x]['id'] = $products[$x]->id;
                    $productModels[$x]['status_stock'] = $products[$x]->status_stock;
                    $productModels[$x]['slug'] = $products[$x]->slug;
                }
            }
        }

        $productOptions = $product->characteristicsProducts;
        $productOptionsList = null;
        if (isset($productOptions) && !empty($productOptions)){
            for ($y=0;$y<=count($productOptions);$y++) {
                if (isset($productOptions[$y]) && !empty($productOptions[$y])) {
                    $itemProductOptionsCharacteristics = $productOptions[$y]->characteristicsOptions->characteristics;
                    $itemProductOptionsCharacteristics->content_id = $content_id;
                    $itemProductOptionsCharacteristics->language_id = $language_id;
                    $itemProductOptionsCharacteristics->type_id = $type_characteristics_id;
                    $itemProductOptions = $productOptions[$y]->characteristicsOptions;
                    $itemProductOptions->content_id = $content_id;
                    $itemProductOptions->language_id = $language_id;
                    $itemProductOptions->type_id = $type_characteristics_options_id;
                    $productOptionsList[$itemProductOptionsCharacteristics->translation->content][$y]['name'] = $itemProductOptions->translation->content?$itemProductOptions->translation->content:$productOptions[$x]->content;
                }
            }
        }

        $comments = $product->productsComments;

        $productCommentsList = null;
        if (isset($comments) && !empty($comments)){
            for ($a=0;$a<=count($comments);$a++) {
                if (isset($comments[$a]) && !empty($comments[$a])) {
                    if ($comments[$a]->active == 1) {
                        $productCommentsList[$a]['name'] = $comments[$a]->name;
                        $productCommentsList[$a]['comment'] = $comments[$a]->comment;
                        $productCommentsList[$a]['rating'] = $comments[$a]->rating;
                        $productCommentsList[$a]['created_at'] = $comments[$a]->created_at;
                    }
                }
            }
        }
        $product = [
            'name'=> $translations[$language]['name']->content,
            'content'=> $translations[$language]['content']->content,
            'category'=> $category,
            'id'=> $product->id,
            'img'=> $product->img,
            'slug'=> $product->slug,
            'gallery'=> $gallery,
            'price'=> $product->price,
            'model' => $model,
            'vendor_code' => $product->vendor_code,
            'status_stock' => $product->status_stock,
            'models' => $productModels,
            'productOptionsList' => $productOptionsList,
            'comments' => $productCommentsList,
        ];

        $this->setMeta($translations[$language]['name']->content,$translations[$language]['keywords']->content, $translations[$language]['description']->content);

        return $this->render('view', [
            'product' => $product,
            'percent' => $percent,
        ]);
    }
}
