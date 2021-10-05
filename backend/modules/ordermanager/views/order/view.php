<?php

use soft\helpers\SHtml;
use soft\kartik\SDetailView;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\ordermanager\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= SHtml::encode($this->title) ?></h1>

    <p>
        <?= SHtml::updateButton($model->id) ?>
        <?= SHtml::deleteButton(['general/delete-model', 'modelClass' => $model->className(), 'id' => $model->id]) ?>
    </p>

    <?= SDetailView::widget([
        'model' => $model,
        'attributes' => [
            ['group' => true, 'label' => Yii::t('app' ,'Details')],
'id', 
'user_id', 
'created_at', 
'updated_at', 
'status', 
        ],
    ]) ?>

</div>
