<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 15.03.2020
 * Time: 19:08
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

namespace frontend\controllers;


use backend\models\categories\Categories;
use backend\models\categories\CategoriesPercent;
use backend\models\characteristics\Characteristics;
use backend\models\characteristics\CharacteristicsOptions;
use backend\models\characteristics\CharacteristicsProducts;
use backend\models\products\Products;
use backend\models\shop\Shop;
use backend\models\shop\Stock;
use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\translations\Translations;
use backend\models\translations\Type;
use Yii;
use yii\base\BaseObject;
use yii\data\Pagination;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\HttpException;

class CategoryController extends AppController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],

            ],
//            $this->isAdmin(['index']),
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        $language = Yii::$app->language;
        $params = Yii::$app->params['languages'];
        $language_id = Languages::findOne(['code' => $language])->id;
        $type_id = Type::findOne(['type' => 'categories'])->id;
        $content_id = Content::findOne(['content' => 'name'])->id;

        $category = Categories::find()->where(['parent_id' => 0])->all();

        $model = Shop::findOne(1);
        if (isset($model) && !empty($model)) {
            $translations = $this->getTranslationsList($model->id, 'shop');

            $shops[] = [
                'name'=>$translations[$language]['name']->content,
                'phones'=>unserialize($model->phones),
                'address'=>$model->address,
            ];
        }

        $getStocks = Stock::find()->all();
        $stocks = [];
        if (isset($getStocks) && !empty($getStocks)) {
            for ($x=0;$x<=count($getStocks);$x++) {
                $translation = $this->getTranslationsList($getStocks[$x]->id, 'stock');
                if ($getStocks[$x]->banner !='') {
                    $stocks[$x]['image'] = $getStocks[$x]->banner;
                    $stocks[$x]['name'] = $translation[$language]['name']->content?$translation[$language]['name']->content:'';
                    $stocks[$x]['content'] = $translation[$language]['content']->content?$translation[$language]['content']->content:'';
                }
            }
        }

        $this->setMeta(null, null, null, 'Главная магазина');

        return $this->render('index', compact('category', 'language', 'language_id', 'type_id', 'content_id','shops','stocks'));
    }

    public function actionView($slug)
    {

        $category = Categories::findOne(['slug' => $slug]);

        if (empty($category)) {
            throw new HttpException(404, Yii::t('frontend/flash', 'There is no such category'));
        }

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

        //Category
        $user_role = Yii::$app->user->identity->role;
        $percents = CategoriesPercent::find()->where(['categories_id' => $category->id, 'role' => $user_role])->one();

        $translations = $this->getTranslationsList($category->id, 'categories');

        //Parent name Category
        if ($category->parent_id != 0) {
            $category->category->language_id = $language_id;
            $category->category->type_id = $type_categories_id;
            $category->category->content_id = $content_id;
        }

        //Category Characteristics + options
        $characteristics = $this->getCharacteristicsOptions($category->categoriesCharacteristics, null, [2]);

        $categories = Categories::find()->where(['parent_id' => $category->id])->all();

        //Products
        $query = Products::find()->where(['category_id' => $category->id]);

        $pageSize = 16;


        if (Yii::$app->request->isPjax) {
            $isPjax = Yii::$app->request->post();

            $query = Products::find()->where(['category_id' => $category->id]);

            if (isset($isPjax['pfi_limit']) && !empty($isPjax['pfi_limit'])) {
                $pageSize = (int)$isPjax['pfi_limit'];
            }
            if (isset($isPjax['pfi_sort']) && !empty($isPjax['pfi_sort']) && $isPjax['pfi_sort'] != '') {
                $pfi_sort = $isPjax['pfi_sort'];
                if ($pfi_sort == 'ASC') {
                    $products = Products::find()->where(['category_id' => $category->id])->orderBy('id ASC')->select('id')->asArray()->all();
                    for ($x = 0; $x <= count($products); $x++) {
                        $ids[] = (int)$products[$x]['id'];
                    }
                    $getList = Translations::find()->where(['type_id' => $type_products_id, 'language_id' => $language_id, 'translation_id' => $ids])->orderBy('content ASC')->select('translation_id')->asArray()->all();

                    for ($y = 0; $y <= count($getList); $y++) {
                        $ascIds[] = (int)$getList[$y]['translation_id'];
                    }
                    if (isset($ascIds) && !empty($ascIds)) {
                        $query->orderBy([new Expression(sprintf("FIELD(id, %s)", implode(",", $ascIds)))]);
                    }

                } elseif ($pfi_sort == 'DESC') {
                    $products = Products::find()->where(['category_id' => $category->id])->orderBy('id ASC')->select('id')->asArray()->all();
                    for ($x = 0; $x <= count($products); $x++) {
                        $ids[] = (int)$products[$x]['id'];
                    }
                    $getList = Translations::find()->where(['type_id' => $type_products_id, 'language_id' => $language_id, 'translation_id' => $ids])->orderBy('content DESC')->select('translation_id')->asArray()->all();
                    for ($y = 0; $y <= count($getList); $y++) {
                        $ascIds[] = (int)$getList[$y]['translation_id'];
                    }
                    if (isset($ascIds) && !empty($ascIds)) {
                        $query->orderBy([new Expression(sprintf("FIELD(id, %s)", implode(",", $ascIds)))]);
                    }
                } elseif ($pfi_sort == 'PRICE_ASC') {
                    $query->orderBy('price ASC');
                } elseif ($pfi_sort == 'PRICE_DESC') {
                    $query->orderBy('price DESC');
                }
            }
            $optionsItems = [];
            if (isset($isPjax['checkbox']) && !empty($isPjax['checkbox']) && $isPjax['checkbox'] != '') {
                for ($a = 0; $a <= count($isPjax['checkbox']); $a++) {
                    if ($isPjax['checkbox'][$a] != '') {
                        $optionsItems[] = (int)$isPjax['checkbox'][$a];
                    }
                }
            }

            if (isset($isPjax['radio']) && !empty($isPjax['radio']) && $isPjax['radio'] != '') {
                for ($c = 0; $c <= count($isPjax['radio']); $c++) {
                    if ($isPjax['radio'][$c] != '') {
                        $optionsItems[] = (int)$isPjax['radio'][$c];
                    }
                }
            }

            $characteristicsOptions = CharacteristicsOptions::find()->where(['id'=>$optionsItems])->all();
            for ($b = 0; $b <= count($characteristicsOptions); $b++) {
                if (isset($characteristicsOptions[$b]->id)) {
                    $characteristicsOptions[$b]->language_id = $language_id;
                    $characteristicsOptions[$b]->type_id = $type_characteristics_options_id;
                    $characteristicsOptions[$b]->content_id = $content_id;
                    $filterOptionsArray[$characteristicsOptions[$b]->id]['id'] = $characteristicsOptions[$b]->id;
                    $filterOptionsArray[$characteristicsOptions[$b]->id]['name'] = $characteristicsOptions[$b]->content ? $characteristicsOptions[$b]->content : $characteristicsOptions[$b]->translation->content;
                }
            }

            if (isset($filterOptionsArray)) {
                $filterOptionsArray = array_values($filterOptionsArray);
            }


            if (isset($optionsItems) && !empty($optionsItems)) {
                $itemsCheck = CharacteristicsProducts::find()->where(['characteristics_options_id' => $optionsItems])->all();

                if (isset($itemsCheck) && !empty($itemsCheck)) {
                    for ($d = 0; $d <= count($itemsCheck); $d++) {
                        if (isset($itemsCheck[$d]->product_id)) {
                            $arrayItems[] = (int)$itemsCheck[$d]->product_id;
                        }
                    }
                }

                if (isset($arrayItems) && !empty($arrayItems)) {
                    $arrayItems2 = array_count_values($arrayItems);
                    foreach ($arrayItems2 as $key => $val) {
                        if ($val == max($arrayItems2) && $val != '') {
                            $filterIds[] = $key;
                        }
                    }

                    if (isset($filterIds) && !empty($filterIds)) {
                        $filterIds = array_unique($filterIds);
                        $query->andWhere(['id' => $filterIds]);
                    }

                    if (isset($isPjax['checkbox']) || $isPjax['radio']) {
                        if ($isPjax['checkbox'] && $isPjax['radio']) {
                            $result = array_merge($isPjax['checkbox'], $isPjax['radio']);
                        } else {
                            $result = $isPjax['checkbox'] ? $isPjax['checkbox'] : $isPjax['radio'];
                        }
                        $characteristics = $this->getCharacteristicsOptions($category->categoriesCharacteristics, $result, [2]);
                    }
                } else {

                    $query->andWhere(['id' => null]);
                    if (isset($isPjax['checkbox']) || $isPjax['radio']) {
                        if ($isPjax['checkbox'] && $isPjax['radio']) {
                            $result = array_merge($isPjax['checkbox'], $isPjax['radio']);
                        } else {
                            $result = $isPjax['checkbox'] ? $isPjax['checkbox'] : $isPjax['radio'];
                        }
                        $characteristics = $this->getCharacteristicsOptions($category->categoriesCharacteristics, $result, [2],['all']);
                    }
                }


            }


        }
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => $pageSize, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $this->setMeta($translations[$language]['name']->content, $translations[$language]['keywords']->content, $translations[$language]['description']->content);

        $model = Shop::findOne(1);
        if (isset($model) && !empty($model)) {
            $shopTranslations = $this->getTranslationsList($model->id, 'shop');

            $shops[] = [
                'name'=>$shopTranslations[$language]['name']->content,
                'phones'=>unserialize($model->phones),
                'address'=>$model->address,
            ];
        }

        return $this->render('view', compact(
            'products',
            'category',
            'shops',
            'language',
            'language_id',
            'type_categories_id',
            'type_products_id',
            'type_products_models_id',
            'type_characteristics_options_id',
            'content_id',
            'percents',
            'translations',
            'pages',
            'categories',
            'characteristics',
            'isPjax',
            'filterOptionsArray'
        ));
    }

    public function actionSearch($search)
    {
        if (!$search) {

            Yii::$app->session->setFlash('danger', Yii::t('frontend/flash', 'Search is empty!'));
            return $this->render('index');
        }

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

        $traslations = Translations::find()->where(['like', 'content', $search])->andWhere(['language_id' => $language_id])->asArray()->all();
        $ids = [];
        if (isset($traslations) && !empty($traslations)) {
            for ($x = 0; $x <= count($traslations); $x++) {
                $ids[] = $traslations[$x]['id'];
            }
        }
        $query = Products::find()->where(['id' => $ids]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $this->setMeta(null, null, null, 'Магазин | Поиск : ' . $search);

        return $this->render('search', compact(
            'products',
            'pages',
            'search',
            'language_id',
            'type_id',
            'type_products_id',
            'type_characteristics_options_id',
            'content_id',
           ));
    }
}
