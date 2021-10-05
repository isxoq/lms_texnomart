<?php

namespace backend\modules\botmanager\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\botmanager\models\BotUserAction;

/**
 * BotUserActionSearch represents the model behind the search form about `backend\modules\botmanager\models\BotUserAction`.
 */
class BotUserActionSearch extends BotUserAction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bot_user_id', 'kurs_id'], 'integer'],
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
        $query = BotUserAction::find();

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
            'bot_user_id' => $this->bot_user_id,
            'kurs_id' => $this->kurs_id,
        ]);

        return $dataProvider;
    }
}
