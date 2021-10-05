<?php

namespace backend\modules\octouz\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\octouz\models\OctouzTransactions;

/**
 * OctouzTransactionsSearch represents the model behind the search form of `backend\modules\octouz\models\OctouzTransactions`.
 */
class OctouzTransactionsSearch extends OctouzTransactions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'error', 'created_at'], 'integer'],
            [['shop_transaction_id', 'octo_payment_UUID', 'octo_pay_url', 'status', 'errorMessage', 'transfer_sum', 'refunded_sum'], 'safe'],
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
        $query = OctouzTransactions::find();

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
            'error' => $this->error,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'shop_transaction_id', $this->shop_transaction_id])
            ->andFilterWhere(['like', 'octo_payment_UUID', $this->octo_payment_UUID])
            ->andFilterWhere(['like', 'octo_pay_url', $this->octo_pay_url])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'errorMessage', $this->errorMessage])
            ->andFilterWhere(['like', 'transfer_sum', $this->transfer_sum])
            ->andFilterWhere(['like', 'refunded_sum', $this->refunded_sum]);

        return $dataProvider;
    }
}
