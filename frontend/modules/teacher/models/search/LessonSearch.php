<?php


namespace frontend\modules\teacher\models\search;


use frontend\modules\teacher\models\Lesson;
use frontend\modules\teacher\models\Section;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class LessonSearch extends Lesson
{

    public function rules()
    {
        return [
            [['title', 'type'], 'string'],
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
            'lesson.type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'lesson.title', $this->title]);
        return $dataProvider;
    }

}