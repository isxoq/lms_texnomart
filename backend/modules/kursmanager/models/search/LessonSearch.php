<?php


namespace backend\modules\kursmanager\models\search;

use backend\modules\kursmanager\models\Lesson;
use yii\data\ActiveDataProvider;
use yii\base\Model;

class LessonSearch extends Lesson
{

    public function rules()
    {
        return [
            ['title', 'string'],
            ['status', 'integer'],
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

            $query = Lesson::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'lesson.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'lesson.title', $this->title]);
        return $dataProvider;
    }

}