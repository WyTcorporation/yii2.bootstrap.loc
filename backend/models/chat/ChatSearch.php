<?php

namespace backend\models\chat;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\chat\Chat;

/**
 * ChatSearch represents the model behind the search form of `backend\models\chat\Chat`.
 */
class ChatSearch extends Chat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'first_user_id', 'second_user_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['message', 'images', 'video', 'created_ip', 'updated_ip'], 'safe'],
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
        $query = Chat::find();

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
            'first_user_id' => $this->first_user_id,
            'second_user_id' => $this->second_user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'images', $this->images])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
