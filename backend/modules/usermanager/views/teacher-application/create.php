<?php

use yii\helpers\Html;

/* @var $this backend\components\BackendView */
/* @var $model backend\models\usermanager\models\TeacherApplication */

$this->title = 'Create Teacher Application';
$this->params['breadcrumbs'][] = ['label' => 'Teacher Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-application-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
