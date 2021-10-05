<?php

namespace backend\modules\botmanager\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\botmanager\models\BotUser;

/**
 * BotUserSearch represents the model behind the search form about `backend\modules\botmanager\models\BotUser`.
 */
class BotUserSearch extends BotUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'temp_kurs_id'], 'integer'],
            [['user_id', 'fio', 'phone', 'step'], 'safe'],
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
        $query = BotUser::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'temp_kurs_id' => $this->temp_kurs_id,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'step', $this->step]);

        return $dataProvider;
    }
}
