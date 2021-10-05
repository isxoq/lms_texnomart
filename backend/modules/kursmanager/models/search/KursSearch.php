<?php

namespace backend\modules\kursmanager\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\kursmanager\models\Kurs;

class KursSearch extends Kurs
{

    public $username;

    public function rules()
    {
        return [
            [['id', 'category_id', 'is_best', 'is_free', 'price', 'user_id', 'created_at', 'updated_at', 'status', 'deleted', 'old_price'], 'integer'],
            [['title', 'slug', 'username'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Kurs::find()->joinWith('user')->with('subCategory.category');

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
            'kurs.id' => $this->id,
            'kurs.category_id' => $this->category_id,
            'kurs.is_best' => $this->is_best,
            'kurs.is_free' => $this->is_free,
            'kurs.price' => $this->price,
            'kurs.created_at' => $this->created_at,
            'kurs.updated_at' => $this->updated_at,
            'kurs.status' => $this->status,
            'kurs.old_price' => $this->old_price,
            'kurs.level' => $this->level,
        ]);

        $query->andFilterWhere(['like', 'kurs.title', $this->title])
            ->andFilterWhere(['like', 'kurs.language', $this->language])
            ->andFilterWhere(['like', 'kurs.image', $this->image])
            ->andFilterWhere(['like', 'kurs.slug', $this->slug])
            ->andFilterWhere(['like', 'user.firstname', $this->username])
            ->orFilterWhere(['like', 'user.lastname', $this->username]);
        return $dataProvider;
    }
}
