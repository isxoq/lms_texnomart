<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 06.05.2021, 10:38
 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;


/* @var $this \soft\web\SView*/
/* @var $replyModel \backend\modules\kursmanager\models\KursComment */

$model = $replyModel->reply;

$this->title = 'Javobni tahrirlash';

$kurs = $model->kurs;
$commentTitle = 'Comment №' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['/teacher/kurs/index']];
$this->params['breadcrumbs'][] = ['label' => $kurs->title, 'url' => ['/teacher/kurs/view', 'id' => $kurs->id]];
$this->params['breadcrumbs'][] = ['label' => 'Fikrlar', 'url' => ['/teacher/kurs/comments', 'id' => $kurs->id]];
$this->params['breadcrumbs'][] = ['label' => $commentTitle, 'url' => ['/teacher/kurs-comment/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;


?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($replyModel, 'text')->textarea(['rows' => 6, 'required' => true]) ?>

<?php if (!$this->isAjax): ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
<?php endif ?>

<?php ActiveForm::end(); ?>
