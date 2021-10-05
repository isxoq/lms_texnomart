<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this frontend\components\FrontendView*/
/* @var $searchModel backend\modules\frontendmanager\models\IndexInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Imkoniyatlar";
$this->description = "Ushbu ma'lumotlar <b>'Biz haqimizda'</b> sahifasida chiqadi ";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="index-info-index">


    <?= \soft\adminty\GridView::widget([
        'dataProvider' => $dataProvider,
        'cols' => [
            'title',
            'icon',
            'actionColumn',
        ],
    ]); ?>


</div>
