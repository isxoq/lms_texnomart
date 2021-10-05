<?php

namespace frontend\models\search;

use Yii;
use frontend\models\Kurs;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class KursSearch extends Kurs
{

    public $sub_category_id;

    public $categories;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['category_id', 'sub_category_id', 'title'], 'string'],
            ['categories', 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search()
    {

        $query = Kurs::find()
            ->nonDeleted()
            ->active()
//            ->select([
//                '{{kurs}}.*', // select all kurs fields
//                'AVG({{rating}}.rate) AS averageRating' // calculate orders count
//            ])
//            ->joinWith('validRatings', false)
//            ->groupBy('{{kurs}}.id')
            ->with(['subCategory', 'userEnroll', 'user' => function ($query) {
                return $query->select('id,firstname,lastname')->asArray();
            }])
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 9
            ],
            'sort' => [
                'defaultOrder' => [
                    'published_at' => SORT_DESC,
                ],
                'attributes' => [
                    'price' => [
                        'asc' => ['price' => SORT_ASC],
                        'desc' => ['price' => SORT_DESC],
                    ],
                    'title' => [
                        'asc' => ['title' => SORT_ASC],
                        'desc' => ['title' => SORT_DESC],
                    ],
                    'published_at' => [
                        'asc' => ['published_at' => SORT_ASC],
                        'desc' => ['published_at' => SORT_DESC],
                    ],
                    'latest' => [
                        'asc' => ['published_at' => SORT_DESC],
                        'desc' => ['published_at' => SORT_DESC],
                    ],
                    'popular' => [
                        'asc' => ['enrolls_count' => SORT_DESC],
                        'desc' => ['enrolls_count' => SORT_DESC],
                    ],
                ]
            ]
        ]);

        $request = Yii::$app->request;
        $this->title = $request->get('title');
        $this->category_id = $request->get('category');
        $this->sub_category_id = $request->get('sub-category');
        $this->categories = $request->get('cat');

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'kurs.title', $this->title]);

        if (!empty($this->sub_category_id)) {
            $query->joinWith('subCategory')->andFilterWhere(['sub_category.slug' => $this->sub_category_id]);
        }

        if (!empty($this->category_id)) {
            $query->joinWith('category')->andFilterWhere(['category.slug' => $this->category_id]);
        }

        if (!empty($this->categories)) {
            $query->joinWith('category')->andFilterWhere(['category.id' => $this->categories]);
        }

        $query->andFilterWhere(['kurs.user_id' => $request->get('author')]);
        $query->andFilterWhere(['kurs.level' => $request->get('level')]);

        $paid = $request->get('paid', false);
        $free = $request->get('free', false);

        if ($paid && !$free){
            $query->andFilterWhere(['kurs.is_free' => false]);
        }
        if (!$paid && $free){
            $query->andFilterWhere(['kurs.is_free' => 1]);
        }

        return $dataProvider;
    }
}
