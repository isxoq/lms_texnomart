<?php

namespace frontend\modules\teacher\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\kursmanager\models\Enroll;

class EnrollSearch extends Enroll
{

    public $userFullname;

    public function rules()
    {
        return [
            [['id',  'created_at', 'updated_at',  'status', 'sold_price', 'end_at',], 'integer'],
            [['userFullname'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params, $query)
    {

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'enroll.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'enroll.type', $this->type]);
        $query->andFilterWhere(['like', 'user.firstname', $this->userFullname]);
        $query->orFilterWhere(['like', 'user.lastname', $this->userFullname]);

        return $dataProvider;
    }
}
