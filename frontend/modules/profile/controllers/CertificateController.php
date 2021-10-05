<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 01.05.2021, 13:34
 */

namespace frontend\modules\profile\controllers;


use backend\models\Certificate;
use kartik\mpdf\Pdf;
use soft\web\SController;
use yii\helpers\ArrayHelper;
use Yii;

class CertificateController extends SController
{

     public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
          

        ];
    }


    public function actionIndex()
    {

        $user = user();
        $certificates = $user->getCertificates()->with('kurs')->all();
        $kursIds = [];

        if (!empty($certificates)) {
            $kursIds = ArrayHelper::getColumn($certificates, 'kurs_id');
        }

        $enrolls = $user->getEnrolls()
            ->joinWith('kurs')
            ->andWhere(['kurs.is_free' => false])
            ->andWhere(['not in', 'kurs.id', $kursIds])
            ->all();

        $hasNewCerticate = false;

        if (!empty($enrolls)) {
            foreach ($enrolls as $enroll) {
                if ($enroll->getCourseIsCompleted()) {
                    $hasNewCerticate = true;
                    $enroll->createCertificate();
                }
            }
        }

        if ($hasNewCerticate){
            $certificates = $user->getCertificates()->with('kurs')->all();
        }

        if (empty($certificates)){
            return $this->render('noCertifcateView');
        }

        return $this->render('index', [
            'certicates' => $certificates
        ]);

    }

    public function actionView($id)
    {

        $model = $this->findCertificate($id);
        return $model->generateCertificate();

    }

    public function actionDownload($id)
    {

        $model = $this->findCertificate($id);
        return $model->generateCertificate(Pdf::DEST_DOWNLOAD);

    }

    public function actionViewExample()
    {

        $content = $this->renderPartial('example_certificate');
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'cssFile' => '@frontend/web/certificate_vd/style/main.css',
            'marginLeft' => 0,
            'marginRight' => 0,
            'marginTop' => 0,
            'marginBottom' => 0,
            'defaultFont' => 'GilroyBold',
        ]);
        return $pdf->render();
    }

    /**
     * @param $id
     * @return \backend\models\Certificate
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    private function findCertificate($id)
    {
        $model = Certificate::findOne($id);
        if ($model == null){
            not_found();
        }
        if ($model->user_id != user('id')){
            forbidden();
        }
        return $model;
    }

}
