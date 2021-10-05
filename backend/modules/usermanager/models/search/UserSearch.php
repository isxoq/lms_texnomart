<?php

namespace backend\modules\usermanager\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\usermanager\models\User;

class UserSearch extends User
{

    public $firstnameOrLastname;
    public $phoneOrEmail;

    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'deleted'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'email', 'firstname', 'lastname', 'phone', 'type', 'firstnameOrLastname', 'phoneOrEmail'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->type,
        ]);

        $query
            ->andFilterWhere(['like', 'firstname', $this->firstnameOrLastname])
            ->orFilterWhere(['like', 'lastname', $this->firstnameOrLastname])
            ->andFilterWhere(['like', 'phone', $this->phoneOrEmail])
            ->orFilterWhere(['like', 'email', $this->phoneOrEmail])
        ;
        return $dataProvider;
    }
}
