<?php

namespace backend\modules\kursmanager\controllers;

use Yii;
use backend\modules\kursmanager\models\Section;
use backend\modules\kursmanager\models\Lesson;
use soft\web\SController;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

class LessonController extends SController
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'delete-media' => ['post'],
                ],
            ],
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
        /** @var Section $section */
        $section = Section::findModel($id);

        $model = new Lesson([
            'section_id' => $id,
        ]);

        return $this->modal([
            'model' => $model,
            'title' => "Yangi mavzu",
            'params' => [
                'section' =>$section,
            ]
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
        /** @var Lesson $model */
        $model = Lesson::findModel($id);

        /** @var Section $section */
        $section = Section::findModel($model->section_id);

        $sectionsMap = ArrayHelper::map(Section::findAll(['kurs_id' => $section->kurs_id]), 'id', 'title');

        return $this->modal([
            'model' => $model,
            'title' => "Mavzuni tahrirlash",
            'params' => [
                'section' => $section,
                'sectionsMap' => $sectionsMap,
            ],
            'view' => 'update',
            'returnUrl' => ['lesson/view' , 'id' => $model->id],
        ]);
    }

    public function actionDelete($id = '')
    {
        /** @var Lesson $model */
        $model = Lesson::findModel($id);

        if ($this->isAjax){
            $this->formatJson;
        }

        if (YII_ENV_PROD && $model->kurs->isConfirmed){
            if ($model->kurs->hasActiveEnrolls){
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
            return $this->redirect(['section/lessons', 'id' => $model->section_id]);
        }
    }


    public function actionView($id='')
    {

        $model = Lesson::findModel($id);
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
    public function actionUpload($id='')
    {
        /** @var Lesson $model */

        $model = Lesson::findModel($id);
        if (!$model->isVideoLesson){
            forbidden("Ushbu dars uchun video yuklashga ruxsat berilmaydi!");
        }
        /*
                if ($model->hasMedia){
                    $this->setFlash('error', "Yangi video yuklash uchun avval mavjud videoni o'chirishingiz zarur!");
                    return $this->redirect(['view' , 'id' => $id]);
                }*/

        return $this->render('upload', [
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
        $model = Lesson::findModel($id);


        if (!$model->isVideoLesson){
            return json_encode(['success' => false]);
        }

        $result = [
            'success' => true,
        ];

        $mediaFile = UploadedFile::getInstance($model, 'src');
        $generatedUrl = $model->generateUrl();
        $mediaUrl = $generatedUrl['mediaUrl'];
        $directory = $generatedUrl['directory'];

        if ($mediaFile) {

            $allowedExtensions = explode(',', settings('upload', 'allowed_video_types'));

            if (!in_array($mediaFile->extension, $allowedExtensions)){
                forbidden();
                return json_encode(['success' => false]);
            }


            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $mediaFile->extension;
            $filePath = $directory . "/" . $fileName;
            if ($mediaFile->saveAs($filePath)) {
                $path = $mediaUrl . DIRECTORY_SEPARATOR . $fileName;

                $model->deleteOrgSrc();
                $model->deleteStream();

                $model->media_org_src = $path;
                $model->media_size = $mediaFile->size;
                $model->media_extension = $mediaFile->extension;
                $model->stream_status = Lesson::MUST_BE_STREAMED;

                if($model->save()){
                    if ($this->isAjax) {
                        return Json::encode([
                            'files' => [
                                [
                                    'name' => $mediaFile->baseName,
                                    'size' => $mediaFile->size,
                                    'deleteType' => 'POST',
                                ],
                            ],
                            'returnUrl' => to(['lesson/view', 'id' => $id])
                        ]);
                    }

                }
            }

        }

        return json_encode($result);
    }

    /**
     * Mediaga yuklangan va stream qilingan videoni o'chirib tashlaydi
     * @param string $id  Media id
     * @return null
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDeleteMedia($id='')
    {
        /** @var Lesson $model */
        $model = Lesson::findModel($id);

        if (YII_ENV_PROD && $model->kurs->isConfirmed){
            if ($model->kurs->hasActiveEnrolls){
                forbidden("Diqqat!!! Ushbu kursga a'zo bo'lgan va hozirda a'zolik muddati tugamagan o'quvchilar bor! <br> Shu tufayli sizga ushbu videoni o'chirishga ruxsat berilmaydi");
            }
        }

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
     * @throws yii\web\NotFoundHttpException
     */
    public function actionSaveMedia($id='')
    {
        /** @var Lesson $model */
        $model = Lesson::findModel($id);
        if ($model->hasMedia){
            return false;
        }
        $model->createStream();
        $model->deleteOrgSrc();
        return Json::encode([
            'success' => true,
            'url' => to(['lesson/view', 'id' => $id])
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
    public function actionFiles($id='')
    {
        /** @var Lesson $model */
        $model = Lesson::findModel($id);
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
