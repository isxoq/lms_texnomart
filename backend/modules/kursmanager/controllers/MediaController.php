<?php


namespace backend\modules\kursmanager\controllers;

use backend\modules\kursmanager\models\Media;
use backend\modules\kursmanager\models\Lesson;
use soft\web\SController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\UploadedFile;

class MediaController extends SController
{

    public function actions()
    {
        return [
            'uploadimage' => [
                'class' => 'odilov\cropper\UploadAction',
                'url' => "/uploads/poster",
                'path' => '@frontend/web/uploads/poster',
                'jpegQuality' => 75,
            ]
        ];
    }
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
//                    'save-media' => ['post'],
                    'upload-media' => ['post'],
                    'delete-video' => ['post'],
                ],
            ],
        ];
    }

        //<editor-fold desc="CRUD actions" defaultstate="collapsed">

        public function actionView($id='')
        {
            $model = Media::findModel($id);
            return $this->render('view', [
                'model' => $model
            ]);
        }

        /**
         * Lesson uchun Yangi video qo'shish
         * Step1: Videoning ma'lumotlarini (title, status, description) kiritish
         * Agar video haqidagi ma'lumotlar to'g'ri kirtilib, video saqlansa, step2 (`upload` action) ga o'tadi
         * @param string $id Lesson id
         * @return string|\yii\web\Response
         * @throws \yii\web\NotFoundHttpException
         */
        public function actionCreate($id='')
        {
            $lesson = Lesson::findModel($id);
            $model = new Media();
            $model->scenario = 'teacher-form';

            if ($model->loadPost()){
                $model->lesson_id = $id;
                if ($model->save()){
                    return $this->redirect(['upload', 'id' => $model->id]);
                }

            }

            return $this->render('create', [
                'model' => $model,
                'lesson' => $lesson,
            ]);
        }

        public function actionUpdate($id='')
        {
            $model = Media::findModel($id);
            $model->scenario = 'teacher-form';
            if ($model->loadPost()){
                $lesson = Lesson::findModel($model->lesson_id);
                if ($model->save()){
                    return $this->redirect(Url::previous('_beforeMediaUpdate') ?? ['view', 'id' => $id] );
                }
            }
            Url::remember($this->request->referrer, "_beforeMediaUpdate");
            return $this->render('update', [
                'model' => $model,
                'lesson' => $model->lesson,
            ]);

        }

        public function actionDelete($id='')
        {
            $model = Media::findModel($id);
            $lesson_id = $model->lesson_id;
            $model->delete();
            return $this->redirect(['lesson/files', 'id' => $lesson_id]);
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
    public function actionUpload($id='')
    {
        $model = Media::findModel($id);

        if ($model->hasOrgMedia && $model->hasStreamedMedia){
            $this->setFlash('error', "Yangi video yuklash uchun avval mavjud videoni o'chirishingiz zarur!");
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('upload', [
            'model' => $model,
        ]);

    }

    /**
     * Ajax upload media (from media action)
     * @param string $id Media id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUploadMedia($id = '')
    {
        $model = Media::findModel($id);

        if ($model->hasOrgMedia && $model->hasStreamedMedia){
            return false;
        }

        $mediaFile = UploadedFile::getInstance($model, 'src');

        $generatedUrl = $model->generateUrl($model->kurs->id);
        $mediaUrl = $generatedUrl['mediaUrl'];
        $directory = $generatedUrl['directory'];

        if ($mediaFile) {
            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $mediaFile->extension;
            $filePath = $directory . "/" . $fileName;
            if ($mediaFile->saveAs($filePath)) {
                $path = $mediaUrl . DIRECTORY_SEPARATOR . $fileName;

                $model->deleteOrgSrc();
                $model->deleteStream();

                $model->org_src = $path;
                $model->size = $mediaFile->size;
                $model->extension = $mediaFile->extension;
                $model->org_name = $mediaFile->baseName;

                if($model->save()){
                    return Json::encode([
                        'files' => [
                            [
                                'name' => $model->org_name,
                                'size' => $mediaFile->size,
                                'deleteUrl' => '/kursmanager/media/delete-video?id=' . $id,
                                'percentUrl' => '/kursmanager/media/get-percent?id=' . $id,
                                'deleteType' => 'POST',
                            ],
                        ],
                        'saveUrl' =>'/kursmanager/media/save-media?id=' . $id
                    ]);
                }
            }
        }

        return '';
    }

    /**
     * Mediaga yuklangan va stream qilingan videoni o'chirib tashlaydi
     * @param string $id  Media id
     * @return null
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeleteVideo($id='')
    {
        $model = Media::findModel($id);
        $model->deleteOrgSrc();
        $model->deleteStream();
        if ($this->isAjax){
            return null;
        }
        else{
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * Videoni upload qilgandan keyin stream qilish
     * @param string $id Media id
     * @return false|string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSaveMedia($id='')
    {
        $model = Media::findModel($id);
        if ($model->hasStreamedMedia){
            return false;
        }
        $model->createStream();
        return Json::encode([
            'success' => true,
            'url' => to(['/kursmanager/media/view', 'id' => $id])
        ]);
    }

    // </editor-fold>
}