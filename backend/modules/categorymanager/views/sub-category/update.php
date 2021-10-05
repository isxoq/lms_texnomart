<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\categorymanager\models\SubCategory */
$category = $model->category;
$this->title = $model->title ." - Tahrirlash";
$this->params['breadcrumbs'][] = ['label' => 'Kategoriyalar', 'url' => ['category/index']];
$this->params['breadcrumbs'][] = ['label' => $category->titleWithIcon, 'url' => ['category/view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['sub-category/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Tahrirlash";
?>
<div class="sub-category-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
