<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model backend\modules\categorymanager\models\SubCategory */
/* @var $category backend\modules\categorymanager\models\Category */

$this->title = "Sub kategoriya qo'shish";
$this->params['breadcrumbs'][] = ['label' => 'Kategoriyalar', 'url' => ['category/index']];
$this->params['breadcrumbs'][] = ['label' => $category->titleWithIcon, 'url' => ['category/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
