<?php
/**
 * Created by PhpStorm.
 * User: Andrey
 * Date: 07.05.2016
 * Time: 10:35
 */

namespace backend\components;

use Yii;
use yii\base\Widget;
use backend\models\Category;
use common\components\CurrencyManager;

class CurrencyWidget extends Widget
{

    public $currencies;
    public $defaultCurrency;
    public $siteCurrency;
    public $template;
    public $data;
    public $tree;
    public $menuHtml;
    public $model;

    public function init()
    {
        parent::init();
        if ($this->template === null) {
            $this->template = 'currency';
        }
        $this->template .= '.php';
    }

    public function run()
    {
        //get cache
        if($this->tree == 'currency.php'){
            $menu = Yii::$app->cache->get('currency');
            if($menu) {
                return $menu;
            }
        }
        $component = new CurrencyManager();
        $this->data = $listCurrencies = $component->listCurrencies();
        $this->menuHtml = $this->getMenuHtml($this->data);

        //set cache 1 minute
        Yii::$app->cache->set('currency',$this->menuHtml,60);

        return $this->menuHtml;
    }


    protected function getMenuHtml($tree, $tab = '')
    {
        $str = '';
        foreach ($tree as $key=>$currency) {
            $str .= $this->catToTemplate(trim($key),$currency);
        }
        return $str;
    }

    protected function catToTemplate($key,$currency)
    {
        ob_start();
        include __DIR__ . '/menu_template/' . $this->template;
        return ob_get_clean();
    }

}
