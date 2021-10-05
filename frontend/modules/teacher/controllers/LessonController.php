<?php

namespace frontend\modules\teacher\controllers;

use frontend\components\UserHistoryBehavior;
use Yii;
use frontend\modules\teacher\models\Section;
use frontend\modules\teacher\models\Lesson;
use soft\web\SController;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

class LessonController extends SController
{

    public function actions()
    {
        return [
            'upload-image' => [
                'class' => 'odilov\cropper\UploadAction',
                'url' => '/uploads/poster',
                'path' => '@frontend/web/uploads/poster',
                'jpegQuality' => 75,
            ]
        ];
    }

    public function behaviors()
    {
        return [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-media' => ['post'],
                ],
            ],

            UserHistoryBehavior::class,
        ];
    }

    public $enableCsrfValidation = false;

    //<editor-fold desc="CRUD" defaultstate="collapsed">

    /**
     * @param string $id Section id
     * @return array|string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate($id = '')
    {
        $section = Section::findOwnModel($id);

        $model = new Lesson([
            'scenario' => 'teacher-form',
            'section_id' => $id,
        ]);


        return $this->modal([
            'model' => $model,
            'title' => 'Yangi mavzu',
            'params' => [
                'section' => $section,
            ]
        ]);

        return $this->render('create', [
            'section' => $section,
            'model' => $model,
        ]);

    }

    /**
     * @param $id Section id
     * @return array
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = Lesson::findOwnModel($id);
        $section = Section::findOwnModel($model->section_id);
        $model->scenario = 'teacher-form';
        $sectionsMap = ArrayHelper::map(Section::findAll(['kurs_id' => $section->kurs_id]), 'id', 'title');

        if ($this->modelLoad($model)) {
            $section = Section::findOwnModel($model->section_id);
        }

        return $this->modal([
            'model' => $model,
            'title' => 'Mavzuni tahrirlash',
            'params' => [
                'section' => $section,
                'sectionsMap' => $sectionsMap,
            ],
            'view' => 'update',
            'returnUrl' => ['view', 'id' => $model->id]
        ]);
    }

    public function actionDelete($id = '')
    {
        $model = Lesson::findOwnModel($id);

        if ($this->isAjax) {
            $this->formatJson;
        }

        if (YII_ENV_PROD && $model->kurs->isConfirmed) {
            if ($model->kurs->hasActiveEnrolls) {
                forbidden("Diqqat!!! Ushbu kursga a'zo bo'lgan va hozirda a'zolik muddati tugamagan o'quvchilar bor! <br> Shu tufayli sizga ushbu mavzuni o'chirishga ruxsat berilmaydi");
            }
        }

        /**
         * @see Lesson::beforeDelete()
         **/
        $model->delete();

        if ($this->isAjax) {
            return ['forceReload' => '#crud-datatable-pjax', 'forceClose' => true];
        } else {
            return $this->redirect(['/teacher/section/lessons', 'id' => $model->section_id]);
        }
    }


    public function actionView($id = '')
    {

        $model = Lesson::findOwnModel($id);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    // </editor-fold>


    //<editor-fold desc="Actions for media" defaultstate="collapsed">


    /**
     * Mavjud Media uchun video yuklash
     * Agar allaqachon video yuklanib bo'lgan bo'lsa, `view` actionga o'tadi
     * Agar allaqachon video yuklanib bo'lgan bo'lsa va shu media uchun Yangi video yuklash kerak bo'lsa,
     *  avval videoni o'chirish kerak
     * @param string $id Media id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpload($id = '')
    {
        /** @var Lesson $model */
        $model = Lesson::findOwnModel($id);

        if (!$model->isVideoLesson) {
            forbidden('Ushbu dars uchun video yuklashga ruxsat berilmaydi!');
        }

        if ($this->post()) {

            $model->loadPost();
            $uploadResult = $model->uploadMedia();
            $status = $uploadResult['status'];
            $message = $uploadResult['message'];
            if ($status == 200) {
                $this->setFlash('success', $message);
                return $this->redirect(['view', 'id' => $id]);
            } else {
                $this->setFlash('error', $message);
            }

        }

        return $this->render('upload2', [
            'model' => $model,
        ]);

    }

    /**
     * Ajax upload media (from media action)
     * @param string $id Media id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUploadMedia($id = '')
    {
        /** @var Lesson $model */
        $model = Lesson::findOwnModel($id);
        if (!$model->isVideoLesson) {
            forbidden('Ushbu dars uchun video yuklashga ruxsat berilmaydi!');
        }

        if ($this->isAjax){

            $this->formatJson;

            $uploadResult = $model->uploadMedia();
            $status = $uploadResult['status'];
            $message = $uploadResult['message'];
            if ($status == 200) {
                return [
                    'status' => 200,
                    'message' => $message,
//                    'redirect' => to(['view', 'id' => $id])
                ];
            } else {
                return [
                    'status' => $status,
                    'message' => $message,
                ];
            }

        }


    }

    /**
     * Mediaga yuklangan va stream qilingan videoni o'chirib tashlaydi
     * @param string $id Media id
     * @return null
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeleteMedia($id = '')
    {
        $model = Lesson::findOwnModel($id);

        if (YII_ENV_PROD && $model->kurs->isConfirmed) {
            if ($model->kurs->hasActiveEnrolls) {
                forbidden("Diqqat!!! Ushbu kursga a'zo bo'lgan va hozirda a'zolik muddati tugamagan o'quvchilar bor! <br> Shu tufayli sizga ushbu videoni o'chirishga ruxsat berilmaydi");
            }
        }

        $model->deleteOrgSrc();
        $model->deleteStream();
        if ($this->isAjax) {
            return null;
        } else {
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * Videoni upload qilgandan keyin stream qilish
     * @param string $id Media id
     * @return false|string
     * @throws yii\web\NotFoundHttpException
     */
    public function actionSaveMedia($id = '')
    {
        $model = Lesson::findOwnModel($id);
        if ($model->hasMedia) {
            return false;
        }
        $model->createStream();
        $model->deleteOrgSrc();
        return Json::encode([
            'success' => true,
            'url' => to(['/teacher/lesson/view', 'id' => $id])
        ]);
    }


    // </editor-fold>

    //<editor-fold desc="Files" defaultstate="collapsed">


    /**
     * Ushbu Lesson ichidagi barcha fayllar ro'yxati
     * @param string $id Lesson id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionFiles($id = '')
    {
        $model = Lesson::findOwnModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getFiles(),
        ]);
        return $this->render('files', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }


    // </editor-fold>


}
