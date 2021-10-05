<?php

namespace backend\modules\faqmanager\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\faqmanager\models\Faq;

/**
 * FaqSearch represents the model behind the search form about `backend\modules\faqmanager\models\Faq`.
 */
class FaqSearch extends Faq
{



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'category_id'], 'integer'],
            [['status', 'title_uz', 'title_ru'], 'safe'],
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
        $query = Faq::find()->with('category')->joinWith('translations');
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
            'faq.id' => $this->id,
            'faq.sort' => $this->sort,
            'faq.category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        if ($this->title_uz != null && $this->title_ru == null){
            $query->andFilterWhere(['like', 'faq_lang.title', $this->title_uz])->andFilterWhere(['faq_lang.language' => 'uz']);
        }

        if ($this->title_ru != null && $this->title_uz == null){
            $query->andFilterWhere(['like', 'faq_lang.title', $this->title_ru])->andFilterWhere(['faq_lang.language' => 'ru']);
        }

        if ($this->title_ru != null && $this->title_uz != null){
            $query->andWhere(['like', 'faq_lang.title', $this->title_ru]);
            $query->andWhere(['like', 'faq_lang.title', $this->title_uz]);
        }

        return $dataProvider;
    }
}
