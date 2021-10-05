<?php


namespace backend\modules\kursmanager\controllers;

use Yii;
use soft\behaviors\DeleteFileBehavior;
use soft\web\SController;
use backend\modules\kursmanager\models\File;
use backend\modules\kursmanager\models\Lesson;
use soft\helpers\UploadHelper;
use yii\filters\VerbFilter;
use yii\helpers\Url;


class FileController extends SController
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
                ],
            ],
        ];
    }

    //<editor-fold desc="CRUD actions" defaultstate="collapsed">

    public function actionView($id='')
    {
        /** @var File $model */
        $model = File::findModel($id);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Lesson uchun Yangi fayl qo'shish
     * @param string $id Lesson id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate($id='')
    {
        /** @var Lesson $lesson */
        $lesson = Lesson::findModel($id);
        $model = new File([
            'lesson_id' => $id
        ]);

        $upload = new UploadHelper([
            'type' => 'file',
            'dirName' => 'lesson_files',
            'fileRules' => [
                'extensions' => File::ALLOWED_FILE_TYPES,
                'maxSize' => File::FILE_MAX_SIZE,
            ]
        ]);


        if ($model->loadPost() && $this->modelValidate($upload)){

            $model->lesson_id = $id;
            $fileName = $upload->upload();

            if ($fileName != null){
                $model->src = $fileName;
                $model->org_name = $upload->file->name;
                $model->type = $upload->file->type;
                $model->size = $upload->file->size;
                $model->extension = $upload->file->extension;
            }

            if ($model->save()){
                return $this->redirect(['lesson/files', 'id' => $id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'lesson' => $lesson,
            'upload' => $upload,
        ]);
    }

    public function actionUpdate($id='')
    {
        /** @var File $model */
        $model = File::findModel($id);
        $lesson = $model->lesson;

        $upload = new UploadHelper([
            'type' => 'file',
            'dirName' => 'lesson_files',
            'fileRules' => [
                'extensions' => File::ALLOWED_FILE_TYPES,
                'maxSize' => File::FILE_MAX_SIZE,
            ]
        ]);

        if ($model->loadPost() && $this->modelValidate($upload)){

            $model->lesson_id = $id;

            $fileName = $upload->upload();

            if ($fileName !== null && $fileName !== false){

                $model->src = $fileName;
                $model->org_name = $upload->file->name;
                $model->type = $upload->file->type;
                $model->size = $upload->file->size;
                $model->extension = $upload->file->extension;
            }

            if ($model->save()){
                return $this->redirect(Url::previous('_beforeFileUpdate') ?? ['view', 'id' => $id] );
            }
        }

        if (!$this->post()){
            Url::remember($this->request->referrer, "_beforeFileUpdate");
        }

        return $this->render('update', [
            'model' => $model,
            'lesson' => $lesson,
            'upload' => $upload
        ]);

    }

    public function actionDownload($id='')
    {
        /** @var File $model */
        $model = File::findModel($id);
        if($model->hasFile){
            return Yii::$app->response->sendFile($model->filePath, $model->lesson->title." - ".$model->title . " (virtualdars.uz)." . $model->extension);
        }
        else{
            not_found('This application has not a file!');
        }
    }

    public function actionDelete($id='')
    {
        /** @var File $model */
        $model = File::findModel($id);
        $lesson_id = $model->lesson_id;
        /**
         * @see File::behaviors()
         * @see DeleteFileBehavior
         **/
        $model->delete();
        if ($this->isAjax){
            $this->formatJson;
            return ['forceReload'=>'#crud-datatable-pjax', 'forceClose' => true];
        }
        else{
            return $this->redirect(['lesson/files', 'id' => $lesson_id]);
        }
    }
    // </editor-fold>


}