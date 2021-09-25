<?php
/**
 * Create by: Vladislav Gladyr
 * Site: lockit.com.ua
 * Email: wild.savedo@gmail.com
 * Date : 10.09.2021
 * Time: 06:34
 * User: WyTcorporation
 */

namespace common\components;

use Yii;
use yii\base\BaseObject;
use common\models\Currency;

class CurrencyManager extends BaseObject
{
    public $currencies;
    public $defaultCurrency;
    public $siteCurrency;

    public function init()
    {
        parent::init();

        $this->currencies = $currencies = Currency::find()
            ->where(['status' => Currency::STATUS_ACTIVE])
            ->orderBy(['sort' => SORT_ASC])
            ->asArray()
            ->all();
        foreach ($this->currencies as $item) {
            if ($item['is_default'] == 1) {
                $this->defaultCurrency = $item;
            }
        }
        $session = Yii::$app->session;
        if (!$session['currency']) {
            $session['currency'] = $this->defaultCurrency;
        }

        $this->siteCurrency = $session['currency'];
    }

    public function listCurrencies()
    {
        $result = [];
        foreach ($this->currencies as $item) {
            if ($this->siteCurrency['code'] == $item['code']) {
                $result['active'] = $item['code'];
            } else {
                $result[$item['code']] = $item['code'];
            }
        }
        return $result;
    }

    public function showPrice($offer, $symbol = true)
    {
        if ($offer['currency_code'] == $this->siteCurrency['code']) {
            $price = $offer['price'];
        } else {
            foreach ($this->currencies as $item) {
                if ($item['code'] == $offer['currency_code']) {
                    $rate = $item['rate'];
                }
            }
            //dd($this->siteCurrency);
            $price = ($offer['price'] * $rate) / $this->siteCurrency['rate'];
        }

        if ($symbol === true) {
            return number_format($price, $this->siteCurrency['decimal_places'], '.', '') . '&nbsp;' . $this->siteCurrency['symbol'];
        } else {
            //return round($price, $this->siteCurrency['decimal_places']);
            return number_format($price, $this->siteCurrency['decimal_places'], '.', '');
        }
    }

    public function showOldPrice($offer, $symbol = true)
    {
        if ($offer['currency_code'] == $this->siteCurrency['code']) {
            $price = $offer['old_price'];
        } else {
            foreach ($this->currencies as $item) {
                if ($item['code'] == $offer['currency_code']) {
                    $rate = $item['rate'];
                }
            }
            $price = ($offer['old_price'] * $rate) / $this->siteCurrency['rate'];
        }

        if ($symbol === true) {
            return number_format($price, $this->siteCurrency['decimal_places'], '.', '') . '&nbsp;' . $this->siteCurrency['symbol'];
        } else {
            return round($price, $this->siteCurrency['decimal_places']);
        }
    }
}