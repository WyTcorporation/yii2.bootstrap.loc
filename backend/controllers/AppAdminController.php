<?php
/**
 * Created by PhpStorm.
 * User: WyTcorp
 * Date: 19.03.2020
 * Time: 11:07
 * Email: wild.savedo@gmail.com
 * Site : http://lockit.com.ua/
 */

namespace backend\controllers;

use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\translations\Translations;
use backend\models\translations\Type;
use phpDocumentor\Reflection\DocBlock\Description;
use Yii;

//use yii\filters\AccessControl;
use yii\base\BaseObject;
use yii2mod\rbac\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AppAdminController extends Controller
{

    public function behaviors()
    {

        $user = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
        if ($user['user']->name == 'user') {
            $this->redirect('/');
        }
        if ($user['moder']->name == 'moder') {
            $moder = $this->isModerActive() ? $this->isModerActive() : null;
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => Yii::$app->params['AccessControlRulesClose'],
                'rules' => [
                    [
                        'actions' => Yii::$app->params['AccessControlRulesOpen'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => Yii::$app->params['AccessControlRulesClose'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    //Достп модератору
                    isset($moder) && !empty($moder) ? $moder : [],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function isModer($actions)
    {
        //Доступ только для модератора
        $actions[] = 'adminPanel';
        $actions[] = 'logout';

        return [
            'actions' => $actions,
            'allow' => true,
            'roles' => ['moder'],
        ];
    }

    public function isAdmin($actions)
    {
        $actions[] = 'adminPanel';
        $actions[] = 'logout';
        //Доступ только для админа
        return [
            'class' => AccessControl::className(),
            'only' => ['index'],
            'rules' => [
                [
                    'actions' => $actions,
                    'allow' => true,
                    'roles' => ['admin'],
                ],
            ],
        ];

//        //Сначала сохраним authManager в переменную, чтобы код был короче
//        $auth = Yii::$app->authManager;
//
//        //----------------- Создание роли
//
//        //Создадим роль 'author'
//        $author = $auth->createRole('author');
//
//        //Не обязательно, но можно добавить описание роли
//        $author->description = 'Роль автора';
//
//        //Сохраняем роль в базе данных
//        $auth->add($author);
//
//        //-------------------Создание разрешения для создания поста
//
//        $permCreatePost = $auth->createPermission('perm_create-post');//создали объект
//        $permCreatePost->description = 'Разрешение для создания поста';//добавили описание
//        $auth->add($permCreatePost);//создали запись в базе данных
//
//        //-------------------Привяжем разрешение к роли
//        //Роль - это родительский элемент. Разрешение дочерний элемент роли
//        $auth->addChild($author, $permCreatePost);
//
//
//        //-------------------Роль и разрешение созданы. Посмотрим как этим пользоваться.
//
//        //Для начала назначим какому-то обстрактному пользователю с id=10 роль 'автор'
//        $auth->assign($author, 10);
//
//        //Проверим разрешение и если оно есть, позволим создать пост в блоге
//        //Так как разрешение 'perm_create-post' ранее было присоеденино к роли 'author',то
//        //пользователь с id=10 сможет создать пост
//        if(\Yii::$app->user->can('perm_create-post')){
//            //Выводим форму для создания поста блога
//        }
//
//        //Сделаем то же самое, но через метод authManager напрямую
//        $userId = \Yii::$app->getUser();
//        if(\Yii::$app->authManager->checkAccess($userId, 'perm_create-post', $params = [])){
//            //Выводим форму для создания поста блога
//        }
    }

    public function getParamsLanguages()
    {
        $params = Yii::$app->params['languages'];
        $language = Yii::$app->sourceLanguage;

        return ['params' => $params, 'language' => $language];
    }

    public function getParams()
    {
        $language = Yii::$app->sourceLanguage;
        $params = Yii::$app->params['languages'];
        $language_id = Languages::findOne(['code' => $language])->id;
        $content_id = $this->getContentBy('name')->id;
        $type = Type::find()->asArray()->all();

        $type_categories_id = null;
        $type_products_id = null;
        $type_characteristics_id = null;
        $type_characteristics_options_id = null;
        $type_products_models_id = null;
        $type_pages_id = null;
        $type_blog_id = null;
        $type_options_id = null;
        $type_stock_id = null;

        if (isset($type) && !empty($type)) {
            for ($x = 0; $x <= count($type); $x++) {
                if ($type[$x]['type'] == 'categories') $type_categories_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'products') $type_products_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'characteristics') $type_characteristics_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'characteristics-options') $type_characteristics_options_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'products-models') $type_products_models_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'pages') $type_pages_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'blog') $type_blog_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'options') $type_options_id = (int)$type[$x]['id'];
                if ($type[$x]['type'] == 'stock') $type_stock_id = (int)$type[$x]['id'];
            }
        }

        $array = [
            'language' => $language,
            'language_id' => $language_id,
            'content_id' => $content_id,
            'params' => $params,
            'type' => [
                'type_categories_id'=>$type_categories_id,
                'type_products_id'=>$type_products_id,
                'type_characteristics_id'=>$type_characteristics_id,
                'type_characteristics_options_id'=>$type_characteristics_options_id,
                'type_products_models_id'=>$type_products_models_id,
                'type_pages_id'=>$type_pages_id,
                'type_blog_id'=>$type_blog_id,
                'type_options_id'=>$type_options_id,
                'type_stock_id'=>$type_stock_id,
            ]
        ];
        return $array;
    }

    public function getLanguageBy($code)
    {
        return Languages::findOne(['code' => $code]);
    }

    public function getTypeBy($type)
    {
        return Type::findOne(['type' => $type]);
    }

    public function getContentBy($content)
    {
        return Content::findOne(['content' => $content]);
    }


    public function setTranslation($translationInput,$translation_id,$type,$paramsArray = null)
    {

        if ($paramsArray != null) {
            $type_id = $paramsArray['type_id'];
            $language_id = $paramsArray['language_id'];
            $contents = $paramsArray['content_id'];
        } else {
            $type_id = $this->getTypeBy($type);
            $contents = Content::find()->all();
        }

        $params = Yii::$app->params['languages'];

        if (count($params) >= 1) {
            foreach ($params as $key => $value) {
                $language_id = $this->getLanguageBy($value)->id;
                for ($x = 0; $x <= count($contents); $x++) {
                    if ($contents[$x]->id != null) {
                        $content_id = $contents[$x]->id;
                        $content = trim($translationInput['field_' . $contents[$x]->content][$value]);

                        if (isset($content) && !empty($content) && $content != '') {

                            $translation = Translations::findOne(['language_id' => $language_id, 'translation_id' => $translation_id, 'type_id' => $type_id, 'content_id' => $content_id]);
                            if (!isset($translation) && empty($translation)) {
                                $translation = new Translations();
                            }
                            $translation->language_id = $language_id;
                            $translation->translation_id = $translation_id;
                            $translation->type_id = $type_id->id;
                            $translation->content_id = $content_id;
                            $translation->content = $content;
                            if (!$translation->save()){
                                return false;
                            }
                        }
                    }
                }
            }
        }
        return true;
    }

    public function getType($type)
    {
        $type_id = Type::findOne(['type' => $type]);
        return $type_id;
    }


    public function getTranslationsList($translation_id,$type)
    {
        $type_id = $this->getType($type);

        $translations = Translations::find()->where(['translation_id'=>$translation_id,'type_id'=>$type_id])->all();

        $languages = Languages::find()->all();

        $params = Yii::$app->params['languages'];

        $array = [];
        foreach ($languages as $language) {
            foreach ($translations as $translation) {
                if ($language->id == $translation->language_id) {
                    $array[$language->code][$translation->content0->content] = $translation;
                }
            }
        }

        foreach ($params as $key => $value) {
            $field_name[$value] = $array[$value]['name']->content;
            $field_short_content[$value] = $array[$value]['short_content']->content;
            $field_content[$value] = $array[$value]['content']->content;
            $field_keywords[$value] = $array[$value]['keywords']->content;
            $field_description[$value] = $array[$value]['description']->content;
        }

        $translationNew = new Translations();
        $translationNew->field_name = $field_name;
        $translationNew->field_short_content = $field_short_content;
        $translationNew->field_content = $field_content;
        $translationNew->field_keywords = $field_keywords;
        $translationNew->field_description = $field_description;

        return $array;
    }

    public function getTranslation($getArray, $content_name)
    {
        $content_id = Content::findOne(['content' => $content_name]);
        $getArray->content_id = $content_id;
        $translation = $getArray->translation;
        return $translation;
    }

    public function getTranslations($getArray)
    {
        $translations = $getArray->translations;
        $array = [];
        foreach ($translations as $translation) {
            $array[$translation->content0->content] = $translation;
        }
        return $array;
    }
}
