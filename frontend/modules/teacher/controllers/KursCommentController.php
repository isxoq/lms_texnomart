<?php

namespace frontend\modules\teacher\controllers;

use Yii;
use soft\web\SController;
use backend\modules\kursmanager\models\KursComment;
use yii\web\NotFoundHttpException;

/**
 * KursCommentController implements the CRUD actions for KursComment model.
 */
class KursCommentController extends SController
{

    /**
     * Displays a single KursComment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * O'qituvchi o'zining kurslariga yozilgan kommentlarga javob yozishi mumkin
     * @param $id
     * @return array|string|\yii\web\Response
     */
    public function actionCreateReply($id)
    {
        $model = $this->findModel($id);
        $replyModel = new KursComment([
            'user_id' => user()->id,
            'reply_id' => $model->id,
            'scenario' => 'text_required',

        ]);

        if ($this->isAjax) {

            $this->formatJson;

            if ($replyModel->load(Yii::$app->request->post()) && $replyModel->save()) {
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
            }
            return [

                'title' => 'Javob yozish',
                'content' => $this->renderAjax('reply', [
                    'model' => $model,
                    'replyModel' => $replyModel,
                ]),
                'footer' => Yii::$app->help->modalFooter,

            ];


        } else {
            if ($replyModel->load(Yii::$app->request->post()) && $replyModel->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('reply', [
                'model' => $model,
                'replyModel' => $replyModel,
            ]);
        }


    }


    /**
     * O'qituvchi kommentariyalarga yozgan javobini tahrirlashi mumkin
     * @param $id
     * @return array|string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $replyModel = $this->findReplyModel($id);

        if ($this->isAjax) {

            $this->formatJson;

            if ($replyModel->load(Yii::$app->request->post()) && $replyModel->save()) {
                return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
            }
            return [

                'title' => 'Javobni tahrirlash',
                'content' => $this->renderAjax('update', ['replyModel' => $replyModel]),
                'footer' => Yii::$app->help->modalFooter,

            ];


        } else {
            if ($replyModel->load(Yii::$app->request->post()) && $replyModel->save()) {
                return $this->redirect(['/teacher/kurs-comment/view', 'id' => $replyModel->reply_id]);
            }

            return $this->render('update', [
                'replyModel' => $replyModel,
            ]);
        }
    }

    /**
     *  O'qituvchi kommentariyalarga yozgan javobini o'chirib tashlashi mumkin
     * @param $id
     */
    public function actionDelete($id)
    {
        $this->findReplyModel($id)->delete();

        if (Yii::$app->request->isAjax) {
            return $this->asJson(['forceReload' => '#crud-datatable-pjax', 'forceClose' => true]);
        }
        return $this->redirect(['kurs-comment/index']);
    }

    protected function findModel($id)
    {

        $model = KursComment::findOne($id);
        if ($model == null) {
            not_found();
        }

        if (!$model->kurs || $model->kurs->user_id != user('id')) {
            forbidden();
        }
        $model->scenario = 'text_required';
        return $model;
    }

    protected function findReplyModel($id)
    {

        $model = KursComment::findOne($id);
        if ($model == null) {
            not_found();
        }
        if ($model->user_id != user('id')) {
            forbidden();
        }
        $model->scenario = 'text_required';

        return $model;
    }


}
