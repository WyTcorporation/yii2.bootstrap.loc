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

use backend\models\options\Options;
use backend\models\products\Products;
use backend\models\shop\Shop;
use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\translations\Translations;
use backend\models\translations\Type;
use Yii;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\Url;
use LisDev\Delivery\NovaPoshtaApi2;


class AppController extends Controller
{
    protected function setMeta($title = null, $keywords = null, $description = null, $forceTitle = null)
    {

        $shopTitle = Yii::$app->params['shopTitle'];

        $language = Yii::$app->language;

        $baseUrl = Url::base(true);
        $thisUrl = Url::current();

        if (isset($forceTitle) && !empty($forceTitle)) {
            $this->view->title = $forceTitle;
            $title = $forceTitle;
        } else {
            $this->view->title = $shopTitle . $title;
            $title = $shopTitle.$title;
        }

//        $this->view->registerLinkTag(['rel' => 'canonical', 'href' => "$baseUrl"]);
//
//        $this->view->registerMetaTag(['property' => 'og:type', 'content' => "website"]);
//
//        $this->view->registerMetaTag(['property' => 'og:url', 'content' => "$baseUrl$thisUrl"]);
//        $this->view->registerMetaTag(['property' => 'og:title', 'content' => "$title"]);
//        $this->view->registerMetaTag(['property' => 'og:description', 'content' => "$description"]);


        $this->view->registerMetaTag(['name' => 'keywords', 'contents' => "$keywords"]);
        $this->view->registerMetaTag(['name' => 'description', 'contents' => "$description"]);


        if(!isset(Yii::$app->session['hits'])) {
            $hits = Products::find()->where(['hit' => '1'])->orderBy('id DESC')->limit(10)->all();

            if (isset($hits) && !empty($hits)) {
                $language_id = Languages::findOne(['code' => $language])->id;
                $content_id = Content::findOne(['content' => 'name'])->id;
                $type_id = $this->getType('products')->id;
                for ($a=0;$a<=count($hits);$a++) {
                    if ($hits[$a]) {
                        $hits[$a]->language_id = $language_id;
                        $hits[$a]->type_id = $type_id;
                        $hits[$a]->content_id = $content_id;
                        $name = $hits[$a]->translation->content;
                        $array[$a]['id'] = $hits[$a]->id;
                        $array[$a]['name'] = $name;
                        $array[$a]['price'] = $hits[$a]->price;
                        $array[$a]['img'] = $hits[$a]->img;
                        $array[$a]['vendor_code'] = $hits[$a]->vendor_code;
                        $array[$a]['hit'] = $hits[$a]->hit;
                        $array[$a]['new'] = $hits[$a]->new;
                        $array[$a]['sale'] = $hits[$a]->sale;
                        $array[$a]['slug'] = $hits[$a]->slug;
                        $array[$a]['status_stock'] = $hits[$a]->status_stock;
                    }
                }
                Yii::$app->session->set('hits', $array);
            }
        }

        if(!isset(Yii::$app->session['contacts'])) {
            $model = Shop::findOne(1);
            if (isset($model) && !empty($model)) {
                $shopTranslations = $this->getTranslationsList($model->id, 'shop');
                $dates = [
                    0 => 'пн-пт',
                    1 => 'вт',
                    2 => 'ср',
                    3 => 'чт',
                    4 => 'пт',
                    5 => 'сб',
                    6 => 'вс',
                ];
                $week = [];
                $array = unserialize($model->date);
                $x = 0;

                foreach ($dates as $key => $date) {
                    if ($key == 0) {
                        $week[$date] .= $array[$key] . ' ';
                        $week[$date] .= $array[$key + 1] . ' ';
                        $week[$date] .= '<br>';
                    } else {
                        if ($array[$key + $x] != '') {
//                            $week[$date] .= $array[$key + $x] . ' ';
//                            $week[$date] .= $array[$key + $x + 1] . ' ';
//                            $week[$date] .= '<br>';
                        } else {
                            $week[$date] .= ' - '.Yii::t('frontend', 'day off').' - <br>';
                        }
                    }
                    $x++;
                }
                $type_options_id = $this->getType('options');
                $options = Options::findOne(['type_id'=>$type_options_id,'status'=>1,'active'=>1]);

                $shops[] = [
                    'name' => $shopTranslations[$language]['name']->content,
                    'phones' => unserialize($model->phones),
                    'address' => $model->address,
                    'location' => $model->location,
                    'email' => $model->email,
                    'date' => $week,
                    'adwords' => $options->content,
                ];

                Yii::$app->session->set('contacts', $shops);
            }
        }
    }

    public function createTranslationArray($language, $type, $content = null)
    {
        $language_id = Languages::findOne(['code' => $language]);
        $type_id = Type::findOne(['type' => $type]);
        $content_id = Content::findOne(['content' => $content]);
        $array ['language_id'] = $language_id;
        $array ['type_id'] = $type_id;
        $array ['content_id'][] = $content_id;
        return $array;
    }

    public function getParamsLanguages()
    {
        $params = Yii::$app->params['languages'];
        $language = Yii::$app->language;

        return ['params' => $params, 'language' => $language];
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
            $field_content[$value] = $array[$value]['content']->content;
            $field_keywords[$value] = $array[$value]['keywords']->content;
            $field_description[$value] = $array[$value]['description']->content;
        }

        $translationNew = new Translations();
        $translationNew->field_name = $field_name;
        $translationNew->field_content = $field_content;
        $translationNew->field_keywords = $field_keywords;
        $translationNew->field_description = $field_description;

        return $array;
    }

    public function getCharacteristicsOptions($characteristics, $active = [], $radio = [],$disabled = [])
    {
        $type = Type::find()->asArray()->all();
        $language = Yii::$app->language;
        $language_id = Languages::findOne(['code' => $language])->id;
        $content_id = Content::findOne(['content' => 'name'])->id;
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
        $array = [];
        if (isset($characteristics) && !empty($characteristics)) {
            for ($x = 0; $x <= count($characteristics); $x++) {
                if ($characteristics[$x] != null) {
                    $array[$x]['id'] = $characteristics[$x]->characteristics->id;
                    $characteristics[$x]->characteristics->language_id = $language_id;
                    $characteristics[$x]->characteristics->content_id = $content_id;
                    $characteristics[$x]->characteristics->type_id = $type_characteristics_id;
                    $array[$x]['name'] = $characteristics[$x]->characteristics->translation->content;
                    if (isset($radio) && !empty($radio)) {
                        for ($a = 0; $a <= count($radio); $a++) {
                            if ($radio[$a] != null && $radio[$a] == $characteristics[$x]->characteristics->id) {
                                $array[$x]['radio'] = 'radio';
                            }
                        }
                    }
                    if (isset($characteristics[$x]->characteristics->characteristicsOptions) && !empty($characteristics[$x]->characteristics->characteristicsOptions)) {
                        $optionsList = $characteristics[$x]->characteristics->characteristicsOptions;
                        for ($y = 0; $y <= count($optionsList); $y++) {
                            if ($optionsList[$y] != null) {
                                $optionsList[$y]->type_id = $type_characteristics_options_id;
                                $optionsList[$y]->language_id = $language_id;
                                $optionsList[$y]->content_id = $content_id;
                                $array[$x]['options'][$y]['id'] = $optionsList[$y]->id;
                                $array[$x]['options'][$y]['name'] = $optionsList[$y]->content ? $optionsList[$y]->content : $optionsList[$y]->translation->content;
                                if (isset($active) && !empty($active)) {
                                    for ($z = 0; $z <= count($active); $z++) {
                                        if ($active[$z] != null && $active[$z] == $optionsList[$y]->id) {
                                            $array[$x]['options'][$y]['active'] = 'active';
                                        }
                                    }
                                }
                                if (isset($disabled) && !empty($disabled)) {
                                    for ($z = 0; $z <= count($disabled); $z++) {
                                        if ($disabled[$z] != null && $disabled[$z] == $optionsList[$y]->id) {
                                            $array[$x]['options'][$y]['disabled'] = 'disabled';
                                        }
                                        if ($disabled[$z] != null && $disabled[$z] == 'all') {
                                            $array[$x]['options'][$y]['disabled'] = 'disabled';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $array;
    }
}
