<?php

use soft\helpers\SHtml;
use soft\kartik\SDetailView;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\categorymanager\models\SubCategory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sub Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-category-view">

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
'icon', 
'image', 
'slug', 
'category_id', 
'created_at', 
'updated_at', 
'status', 
        ],
    ]) ?>

</div>
