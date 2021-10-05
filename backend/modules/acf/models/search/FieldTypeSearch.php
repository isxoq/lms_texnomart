<?php

namespace backend\modules\acf\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\acf\models\FieldType;

/**
 * FieldTypeSearch represents the model behind the search form of `backend\modules\acf\models\FieldType`.
 */
class FieldTypeSearch extends FieldType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_widget', 'is_file_upload'], 'integer'],
            [['name', 'description', 'widget_class', 'options'], 'safe'],
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
        $query = FieldType::find();

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
            'is_widget' => $this->is_widget,
            'is_file_upload' => $this->is_file_upload,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'widget_class', $this->widget_class])
            ->andFilterWhere(['like', 'options', $this->options]);

        return $dataProvider;
    }
}
