<?php

namespace backend\modules\contactmanager\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\contactmanager\models\Contact;

class ContactSearch extends Contact
{

    public function rules()
    {
        return [
            [['id', 'status', 'created_at'], 'integer'],
            [['firstname', 'email', 'body', 'lastname', 'phone'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Contact::find()->where(['!=', 'status', 5])->orderBy('status')->latest();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'phone', $this->phone]);
        return $dataProvider;
    }
}
