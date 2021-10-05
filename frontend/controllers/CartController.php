<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

namespace frontend\controllers;

use Yii;
use frontend\models\Kurs;
use soft\web\SController;
use yii\helpers\Json;

/**
 * Cart controller
 */

class CartController extends SController
{

    //<editor-fold desc="Actions for shopping cart " defaultstate="collapsed">
    public function actionAdd()
    {
        $id = $this->request->get('id');
        $model = Kurs::find()->active()->andWhere(['kurs.id' => $id])->one();
        if($model != null){
            Yii::$app->cart->add($id);
            return $this->success(t('Added to cart'), $model->addToCartButton);
        }
        else{
            return $this->error(t('Product not found'));
        }
    }

    public function actionRemove()
    {
        $id = Yii::$app->request->get('id');
        $model = Kurs::find()->active()->andWhere(['kurs.id' => $id])->one();
        if($model != null){
            Yii::$app->cart->remove($id);
            return $this->success(t('Removed from cart'), $model->addToCartButton);
        }
        else{
            return $this->error(t('Product not found'));
        }
    }

    public function error($message=false)
    {
        if ($this->isAjax){
            return Json::encode([
                'success' => false,
                'message' => $message,
            ]);
        }
        else{
//            if ($message){
//                $this->setFlash('error', $message);
//            }
            return $this->back();
        }
    }

    public function success($message=false, $button=false)
    {
        if ($this->isAjax){
            return Json::encode([
                'success' => true,
                'message' => $message,
                'countItems' => Yii::$app->cart->countItems,
                'cartButton' => $button,
            ]);
        }
        else{
//            if ($message){
//                $this->setFlash('success', $message);
//            }
            return $this->back();
        }
    }

  // </editor-fold>

}

?>