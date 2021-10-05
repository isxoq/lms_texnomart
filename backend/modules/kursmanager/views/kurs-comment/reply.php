<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 06.05.2021, 10:38
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this \soft\web\SView*/
/* @var $model \backend\modules\kursmanager\models\KursComment */
/* @var $replyModel \backend\modules\kursmanager\models\KursComment */

$this->title = 'Tahrirlash';
$this->params['breadcrumbs'][] = ['label' => 'Kurs Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Comment №'. $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Javob yozish';

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($replyModel, 'text')->textarea(['rows' => 6]) ?>


<?php if (!$this->isAjax): ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
<?php endif ?>

<?php ActiveForm::end(); ?>
