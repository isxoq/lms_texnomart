<?php

namespace backend\modules\billing\controllers;

use soft\components\pdf\FPDF;
use yii;

class InvoiceController extends \yii\web\Controller
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
                    ],
                ],
            ],
        ];
    }

    public function actionPayout()
    {
        return $this->render('payout');
    }

    public function actionPurchase()
    {
        return $this->render('purchase');
    }

    public function actionTest()
    {

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('courier', 'B', 16);
        $pdf->Cell(40, 10, 'Hello World!');
        $pdf->Output();
    }

}
