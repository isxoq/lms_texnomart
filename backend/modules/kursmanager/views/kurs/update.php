<?php


/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Kurs */

$this->title = 'Tahrirlash';
$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Tahrirlash';
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
