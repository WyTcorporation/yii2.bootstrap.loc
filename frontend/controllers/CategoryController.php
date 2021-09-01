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


use Yii;
use frontend\models\Category;
use frontend\models\Product;
use yii\data\Pagination;
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
                'only' => ['logout', 'signup'],
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
//        if(Yii::$app->user->can('admin')){
//            echo "Привет, админ!" . PHP_EOL;
//        }
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();

        $this->setMeta(null,null,null, 'Главная магазина');

        return $this->render('index', compact('hits'));
    }

    public function actionView($slug)
    {

        $paramsLanguages = $this->getParamsLanguages();

        $category = Category::findOne(['slug'=>$slug]);


        if (empty($category)) {
            throw new HttpException(404, 'Такой категории нет');
        }

        $query = Product::find()->where(['category_id' => $category->id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        $this->setMeta( $category->name, $category->keywords, $category->description);

        return $this->render('view', compact('products', 'category', 'pages'));
    }

    public function actionSearch($search)
    {
        if (!$search) {
            return $this->render('search', compact('products', 'pages','search'));
        }

        $query = Product::find()->where(['like','name',$search]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $this->setMeta('Магазин | Поиск : '.$search);

        return $this->render('search', compact('products', 'pages','search'));
    }
}
