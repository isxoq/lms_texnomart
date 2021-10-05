<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\billing\models\OfflinePayments */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="offline-payments-form">

        <?php $form = \soft\kartik\SActiveForm::begin(); ?>

        <?= $form = \soft\form\SForm::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'user_id:select2' => [
                    'label' => 'Talabani tanlang',
                    'options' => [
                        'data' => map(\common\models\User::find()->asArray()->all(), 'id', function ($model) {
                            return $model['firstname'] . " " . $model['lastname'];
                        })
                    ]
                ],
                'course_id:select2' => [
                    'label' => 'Kursni tanlang',
                    'options' => [
                        'options' => [
                            'id' => 'enroll-select-course',
                        ],
                        'data' => map(\backend\modules\kursmanager\models\Kurs::find()->with("user")->asArray()->all(), 'id', function ($model) {
                            return $model['title'] . " (" . $model['user']['firstname'] . " " . $model['user']['lastname'] . ")";
                        })
                    ]
                ],
                'amount' => [
                    'options' => [
                        'id' => 'enroll-amount'
                    ]
                ],
                'duration:dropdownList' => [
                    'items' => Yii::$app->site->kursDurations,
                    'options' => [
                        'id' => 'enroll-duration'
                    ]
                ],
                'document_file:elfinder',
                'type:dropdownList' => [
                    'label' => "To'lov turini tanlang",
                    'items' => map(\backend\modules\billing\models\PaymentTypes::find()->asArray()->all(), 'type', 'name')
                ],
            ]
        ]); ?>

        <div class="form-group">
            <?= \soft\helpers\SHtml::submitButton() ?>
        </div>

        <?php \soft\kartik\SActiveForm::end(); ?>
    </div>


<?php

$this->registerJs('

$("#enroll-select-course").change(function(e){
    
    let url = "' . to(['/billing/offline-payments/kurs-info']) . '"
    $.ajax({
        url:url,
        type:"GET",
        data:{id:$(this).val()},
        success:function(response){
            $("#enroll-amount").val(response.price)        
            $("#enroll-duration").val(response.duration)        
        }
    })

});


');

?>