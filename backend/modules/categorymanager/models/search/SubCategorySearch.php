<?php

namespace backend\modules\categorymanager\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\categorymanager\models\SubCategory;

class SubCategorySearch extends SubCategory
{

    public function rules()
    {
        return [
            [['id', 'category_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['icon', 'image', 'slug'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SubCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'slug', $this->slug]);
        return $dataProvider;
    }
}
