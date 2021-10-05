<?php

namespace backend\modules\frontendmanager\controllers;

use backend\controllers\BackendController;
use Yii;
use backend\modules\frontendmanager\models\CourseSlider;
use backend\modules\frontendmanager\models\search\CourseSliderSearch;
use yii\base\Model;

class CourseSliderController extends BackendController
{

    public function actions()
    {
        return [
            'upload-image' => [
                'class' => 'odilov\cropper\UploadAction',
                'url' => "/uploads/course_slider",
                'path' => '@frontend/web/uploads/course_slider',
                'jpegQuality' => 75,
            ]
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CourseSliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' =>  CourseSlider::findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new CourseSlider();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model =  CourseSlider::findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        CourseSlider::findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionSorting()
    {
        $slides = CourseSlider::getAll();

        if ($this->post()){


            $items = $this->post('sortable');

            $key = 1;
            foreach ($items as $item) {

                $slide = CourseSlider::findOne($item['id']);
                if ($slide){

                    $slide->sort_order = $key;
                    $slide->save();

                }

                $key ++;

            }

            return $this->redirect(['index']);

        }

        return $this->render('sorting', [
            'slides' => $slides
        ]);
    }

}
