<?php

namespace backend\modules\contactmanager\controllers;

use backend\controllers\BackendController;
use Yii;
use backend\modules\contactmanager\models\Contact;
use backend\modules\contactmanager\models\search\ContactSearch;
use soft\web\SController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
class DefaultController extends BackendController
{

    public function actionIndex()
    {
        $searchModel = new ContactSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        $model =  Contact::findModel($id);

        $model->markAsRead();

        if ($this->isAjax){
            $this->formatJson;
            return [
                'forceReload' => '#crud-datatable-pjax',
                'title' => "Xabar #".$id,
                'content' => $this->renderAjax('view', ['model' => $model]),
                'footer' => Yii::$app->help->getViewFooter($id)

            ];
        }
        else{
            return $this->render('view', ['model' => $model]);
        }


    }

    public function actionMarkAsRead($id='')
    {
        $model = Contact::findModel($id);
        $model->markAsRead();
        if ($this->isAjax){
            $this->formatJson;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }
        else{
            return $this->back();
        }
    }
    
    public function actionDelete($id)
    {
        $model =  Contact::findModel($id);
        $model->delete();
        if(request()->isAjax){
            Yii::$app->response->format = 'json';
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            return $this->redirect('index');
        }


    }
    /**
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    // function for report pdf
    public function actionReport($id) {
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('report', [
                'model' => $this->findModel($id),
            ]);
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['iSoft Company'], 
                'SetFooter'=>['{PAGENO}'],
            ]
            ]);
            
            // return the pdf output as per the destination setting
            return $pdf->render(); 
            // return $this->redirect('report'); 
    }

    /**
     * Bulk Delete selected models
     */

    public function actionBulkDelete(){


        $pks = explode(',', request()->post( 'pks' ));
        foreach ( $pks as $pk ) {
            $model = Contact::findModel($pk);
                $model->delete();
        }

        if(request()->isAjax){
            Yii::$app->response->format = 'json';
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            return $this->redirect('index');
        }
    }

}
