<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\billing\models\Payouts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payouts-form">

    <?php $form = \soft\kartik\SActiveForm::begin(); ?>

    <?= $form = \soft\form\SForm::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'teacher_id:select2' => [
                'label' => "O'qituvchini tanlang",
                'options' => [
                    'data' => map(\common\models\User::find()->andWhere(['type' => \common\models\User::TYPE_TEACHER])->asArray()->all(), 'id', function ($model) {
                        return $model['firstname'] . " " . $model['lastname'];
                    })
                ]
            ],
            'document_file:elfinder',
            'payment_type:select2' => [
                'label' => "To'lov turini tanlang",
                'options' => [
                    'data' => map(\backend\modules\billing\models\PaymentTypes::find()->asArray()->all(), 'type', function ($model) {
                        return $model['name'];
                    })
                ]
            ],
            'amount',
            'description:textarea',
        ]
    ]); ?>

    <div class="form-group">
        <?= \soft\helpers\SHtml::submitButton() ?>
    </div>

    <?php \soft\kartik\SActiveForm::end(); ?>

</div>
