<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

namespace frontend\controllers;


use frontend\models\Post;
use frontend\models\search\PostSearch;
use yii\data\ActiveDataProvider;

class BlogController extends FrontendController
{

  /*  public function actionIndex()
    {
        $search = new PostSearch();
        $dataProvider = $search->search();

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionDetail($id='')
    {
        $model = Post::find()->active()->published()->slug($id)->one();
        if ($model == null){
            not_found();
        }
        $model->incViewsCount();
        return $this->render('detail', [
            'model' => $model
        ]);
    }*/

}