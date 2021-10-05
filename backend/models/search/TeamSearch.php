<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Team;

class TeamSearch extends Team
{

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['fullname', 'position', 'image', 'socials'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Team::find();

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
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'socials', $this->socials]);
        return $dataProvider;
    }
}
