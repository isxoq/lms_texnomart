<?php

namespace backend\modules\billing\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\billing\models\Purchases;

/**
 * PurchasesSearch represents the model behind the search form of `backend\modules\billing\models\Purchases`.
 */
class PurchasesSearch extends Purchases
{

    public $userFullName;
    public $courseTitle;
    public $userContact;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'course_id', 'created_at', 'order_id', 'cancelled_time', 'transaction_id', 'status'], 'integer'],
            [['amount', 'teacher_fee', 'platform_fee'], 'number'],
            [['payment_type','userFullName', 'courseTitle'], 'safe'],
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
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Purchases::find()->joinWith('user')->joinWith('course');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [

                    'created_at' => SORT_DESC
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
            'purchases.id' => $this->id,
            'purchases.user_id' => $this->user_id,
            'purchases.course_id' => $this->course_id,
            'purchases.created_at' => $this->created_at,
            'purchases.amount' => $this->amount,
            'purchases.order_id' => $this->order_id,
            'purchases.teacher_fee' => $this->teacher_fee,
            'purchases.platform_fee' => $this->platform_fee,
            'purchases.cancelled_time' => $this->cancelled_time,
            'purchases.transaction_id' => $this->transaction_id,
            'purchases.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'purchases.payment_type', $this->payment_type]);
        $query->andFilterWhere(['like', 'kurs.title', $this->courseTitle]);
        $query->andFilterWhere(['like', 'user.firstname', $this->userFullName]);
        $query->orFilterWhere(['like', 'user.lastname', $this->userFullName]);

        return $dataProvider;
    }
}
