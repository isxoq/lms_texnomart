<?php

use soft\helpers\SHtml;

/* @var $this \frontend\components\FrontendView */
/* @var $searchModel frontend\modules\teacher\models\search\KursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kurs boshqaruvchisi';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_courseIndexView',
    'layout' => "{items}{pager}"
]); ?>
