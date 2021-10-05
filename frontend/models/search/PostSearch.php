<?php


namespace frontend\models\search;

use Yii;
use frontend\models\Post;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PostSearch extends Post
{

    public $title_search;
    public $category_slug;

    public function rules()
    {
        return [
            [['title_search','category_slug'], 'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search()
    {
        $query = Post::find()
            ->active()
            ->published()
            ->recently()
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 4
            ]
        ]);

        $request = Yii::$app->request;
        $this->title_search = $request->get('search');
        $this->category_slug = $request->get('category');

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'post_lang.title', $this->title_search]);

        if (!empty($this->title_search)){
            $query->joinWith('translations')->distinct()
                ->andFilterWhere(['like', 'post_lang.title' , $this->title_search ])
                ->andWhere(['post_lang.language' => Yii::$app->language]);
        }

        if (!empty($this->category_slug)){
            $query->joinWith('category')->andFilterWhere(['post_category.slug' => $this->category_slug]);
        }

        return $dataProvider;
    }

}