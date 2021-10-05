<?php

namespace backend\modules\usermanager\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\usermanager\models\UserHistory;

/**
 * UserHistorySearch represents the model behind the search form about `backend\modules\usermanager\models\UserHistory`.
 */
class UserHistorySearch extends UserHistory
{

    public $userFullname;
    public $phoneOrEmail;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'date'], 'integer'],
            [['url', 'prev_url', 'page_title', 'ip', 'device', 'device_type', 'userFullname', 'phoneOrEmail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = UserHistory::find()->joinWith('user');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'defaultPageSize' => 50,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'prev_url', $this->prev_url])
            ->andFilterWhere(['like', 'page_title', $this->page_title])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'device', $this->device])
            ->andFilterWhere(['like', 'device_type', $this->device_type])

            ->andFilterWhere(['like', 'phone', $this->phoneOrEmail])
            ->orFilterWhere(['like', 'email', $this->phoneOrEmail])


        ;

        $query->andFilterWhere(['like', 'user.firstname', $this->userFullname]);
        $query->orFilterWhere(['like', 'user.lastname', $this->userFullname]);

        return $dataProvider;
    }
}
