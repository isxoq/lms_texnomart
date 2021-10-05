<?php

namespace backend\modules\acf\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\acf\models\Field;

/**
 * FieldSearch represents the model behind the search form of `backend\modules\acf\models\Field`.
 */
class FieldSearch extends Field
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_required', 'type_id', 'is_multilingual', 'character_limit', 'is_active'], 'integer'],
            [['title', 'name', 'description', 'options', 'placeholder', 'prepend', 'append'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Field::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_required' => $this->is_required,
            'is_multilingual' => $this->is_multilingual,
            'character_limit' => $this->character_limit,
            'is_active' => $this->is_active,
            'type_id' => $this->type_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'options', $this->options])
            ->andFilterWhere(['like', 'placeholder', $this->placeholder])
            ->andFilterWhere(['like', 'prepend', $this->prepend])
            ->andFilterWhere(['like', 'append', $this->append]);

        return $dataProvider;
    }
}
