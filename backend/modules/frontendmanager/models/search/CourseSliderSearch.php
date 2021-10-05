<?php

namespace backend\modules\frontendmanager\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\frontendmanager\models\CourseSlider;

class CourseSliderSearch extends CourseSlider
{

    public function rules()
    {
        return [
            [['id', 'course_id', 'status'], 'integer'],
            [['image', 'little_image'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CourseSlider::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'course_id' => $this->course_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'little_image', $this->little_image]);
        return $dataProvider;
    }
}
