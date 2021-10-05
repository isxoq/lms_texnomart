<?php

namespace backend\modules\billing\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\billing\models\OfflinePayments;

/**
 * OfflinePaymentsSearch represents the model behind the search form of `backend\modules\billing\models\OfflinePayments`.
 */
class OfflinePaymentsSearch extends OfflinePayments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'course_id', 'created_at', 'cancelled_at', 'status'], 'integer'],
            [['amount'], 'number'],
            [['document_file', 'type'], 'safe'],
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
        $query = OfflinePayments::find();

        // add conditions that should always apply here

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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'cancelled_at' => $this->cancelled_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'document_file', $this->document_file])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
