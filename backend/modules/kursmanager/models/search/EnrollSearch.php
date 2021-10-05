<?php

namespace backend\modules\kursmanager\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\kursmanager\models\Enroll;

class EnrollSearch extends Enroll
{

    public $userFullname;
    public $userPhone;
    public $userEmail;
    public $teacherId;

    public function rules()
    {
        return [
            [['id', 'user_id', 'kurs_id', 'created_at', 'updated_at', 'teacherId',  'status', 'sold_price', 'end_at', 'created_by', 'free_trial'], 'integer'],
            [['type', 'userEmail', 'userFullname', 'userPhone'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params, $query = null)
    {
        if ($query == null){

            $query = Enroll::find()->joinWith('user')->joinWith('kurs', false)->with('kurs.user')->with('createdBy');
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'defaultPageSize' => 50,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'enroll.id' => $this->id,
            'enroll.kurs_id' => $this->kurs_id,
            'enroll.status' => $this->status,
            'enroll.sold_price' => $this->sold_price,
            'enroll.end_at' => $this->end_at,
            'enroll.created_by' => $this->created_by,
            'enroll.free_trial' => $this->free_trial,
            'kurs.user_id' => $this->teacherId,
        ]);

        $query->andFilterWhere(['like', 'enroll.type', $this->type]);
        $query->andFilterWhere(['like', 'user.firstname', $this->userFullname]);
        $query->orFilterWhere(['like', 'user.lastname', $this->userFullname]);
        $query->andFilterWhere(['like', 'user.email', $this->userEmail]);
        $query->andFilterWhere(['like', 'user.phone', $this->userPhone]);
        $query->andFilterWhere(['like', 'user.phone', $this->userPhone]);

        return $dataProvider;
    }
}
