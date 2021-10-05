<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 28.04.2021, 14:58
 */

namespace backend\modules\kursmanager\models\search;

use Yii;
use backend\modules\kursmanager\models\LearnedLesson;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class LearnedLessonSearch
 * @package backend\modules\kursmanager\models\search
 */
class LearnedLessonSearch extends LearnedLesson
{

    public $sectionId;

    public $lessonTitle;

    public function rules()
    {
        return [
            [['id', 'user_id', 'lesson_id', 'is_completed', 'sectionId'], 'integer'],
            ['lessonTitle', 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($query = null, $params = [])
    {

        if (empty($params)) {
            $params = Yii::$app->request->queryParams;
        }

        if ($query == null) {
            $query = LearnedLesson::find()->joinWith('section');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 50,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'learned_lesson.id' => $this->id,
            'learned_lesson.user_id' => $this->user_id,
            'learned_lesson.is_completed' => $this->is_completed,
            'section.id' => $this->sectionId,
        ]);

        $query->andFilterWhere(['like', 'lesson.title', $this->lessonTitle]);

        return $dataProvider;
    }

}