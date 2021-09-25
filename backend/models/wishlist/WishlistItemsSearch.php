<?php

namespace backend\models\wishlist;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\wishlist\WishlistItems;

/**
 * WishlistItemsSearch represents the model behind the search form of `backend\models\wishlist\WishlistItems`.
 */
class WishlistItemsSearch extends WishlistItems
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'wishlist_id', 'product_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'created_ip', 'updated_ip'], 'safe'],
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
        $query = WishlistItems::find();

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
            'wishlist_id' => $this->wishlist_id,
            'product_id' => $this->product_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
