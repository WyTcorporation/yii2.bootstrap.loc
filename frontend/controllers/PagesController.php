<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 12.09.2021
 * Time: 11:10
 * User: WyTcorporation
 */

namespace frontend\controllers;

use backend\models\translations\Content;
use Yii;
use backend\models\translations\Translation;
use backend\models\pages\Pages;
use yii\web\HttpException;

class PagesController extends AppController
{
    public $type = 'pages';

    public function actionIndex($slug)
    {
        $language = Yii::$app->language;

        $shopTitle = Yii::$app->params['shopTitle'];

        $page = Pages::findOne(['slug'=>$slug]);

        if ($page == null) {
            throw new HttpException(404, 'Страница не найдена!');
        }

        // Все переводы
        $result = $this->getTranslationsList($page->id,$this->type)[$language];

        $this->setMeta(null, $result['keywords']->content, $result['description']->content, $shopTitle . $result['name']->content);

        return $this->render('index', [
            'result' => $result
        ]);
    }
}