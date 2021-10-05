<?php

namespace backend\modules\usermanager\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\usermanager\models\TeacherApplication;

class TeacherApplicationSearch extends TeacherApplication
{

    public $username;

    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'created_at'], 'integer'],
            [['message', 'doc', 'username', 'speciality'], 'safe'],
            ['is_ready', 'boolean']
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TeacherApplication::find()->latest()->joinWith('user');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'teacher_application.id' => $this->id,
            'teacher_application.user_id' => $this->user_id,
            'teacher_application.status' => $this->status,
            'teacher_application.created_at' => $this->created_at,
            'teacher_application.is_ready' => $this->is_ready,
        ]);

        $query->andFilterWhere(['like', 'teacher_application.message', $this->message])
            ->andFilterWhere(['like', 'teacher_application.doc', $this->doc])
            ->andFilterWhere(['like', 'teacher_application.speciality', $this->speciality])
            ->andFilterWhere(['like', 'user.firstname', $this->username])
            ->orFilterWhere(['like', 'user.lastname', $this->username]);
        return $dataProvider;
    }
}
