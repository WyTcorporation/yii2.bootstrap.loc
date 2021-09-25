<?php

namespace backend\models\currency;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\currency\Currency;

/**
 * CurrencySearch represents the model behind the search form of `backend\models\currency\Currency`.
 */
class CurrencySearch extends Currency
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_default', 'sort', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'symbol', 'code', 'decimal_places', 'status', 'created_ip', 'updated_ip'], 'safe'],
            [['rate'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Currency::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'rate' => $this->rate,
            'is_default' => $this->is_default,
            'sort' => $this->sort,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'symbol', $this->symbol])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'decimal_places', $this->decimal_places])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
