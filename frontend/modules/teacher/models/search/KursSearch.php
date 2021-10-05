<?php

namespace frontend\modules\teacher\models\search;

use frontend\modules\teacher\models\Kurs;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class KursSearch extends Kurs
{



    public function rules()
    {
        return [
            [['id', 'category_id', 'is_best', 'is_free', 'price',  'created_at', 'updated_at', 'old_price'], 'integer'],
            [['title', 'level', 'language', 'slug', 'username'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $query = null)
    {
        if ($query == null){

            $query = Kurs::find()->own()->nonDeleted()->with('category');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
        ;
        return $dataProvider;
    }
}
