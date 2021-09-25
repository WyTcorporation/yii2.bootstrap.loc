<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 07.05.2016
 * Time: 10:35
 */

namespace backend\components;

use backend\models\categories\Categories;
use backend\models\translations\Content;
use backend\models\translations\Languages;
use backend\models\translations\Translations;
use backend\models\translations\Type;
use Yii;
use yii\base\BaseObject;
use yii\base\Widget;

class MenuWidget extends Widget
{

    public $template;
    public $data;
    public $tree;
    public $menuHtml;
    public $model;


    public function init()
    {
        parent::init();
        if ($this->template === null) {
            $this->template = 'menu';
        }

        $this->template .= '.php';
    }

    public function run()
    {

        //get cache
        if($this->tree == 'menu.php'){
            $menu = Yii::$app->cache->get('menu');
            if($menu) {
                return $menu;
            }
        }
        $language = Yii::$app->sourceLanguage;

        $language_id = Languages::findOne(['code'=>$language])->id;

        $type_id = Type::findOne(['type' => 'categories'])->id;

        $content_id = Content::findOne(['content' => 'name'])->id;

        //$this->data =  Categories::find()->indexBy('id')->asArray()->all();
        $datas = Categories::find()->indexBy('id')->all();
        foreach($datas as $data) {
            $data->type_id = $type_id;
            $data->language_id = $language_id;
            $data->content_id = $content_id;
            $data->name = trim($data->translation->content);
            $categories[$data->id]['id'] = $data->id;
            $categories[$data->id]['name'] = trim($data->translation->content);
            $categories[$data->id]['parent_id'] = $data->parent_id;
        }
        $this->data = $categories;
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);

        //set cache 1 minute
        Yii::$app->cache->set('menu',$this->menuHtml,60);

        return $this->menuHtml;
    }

    protected function getTree()
    {

        $tree = [];
        if (isset($this->data)  && !empty($this->data)) {
            foreach ($this->data as $id => &$node) {
                if (!$node['parent_id']) {
                    $tree[$id] = &$node;
                } else {
                    $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
                }

            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = '')
    {
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category,$tab);
        }
        return $str;
    }

    protected function catToTemplate($category,$tab)
    {
        ob_start();
        include __DIR__ . '/menu_template/' . $this->template;
        return ob_get_clean();
    }

}
