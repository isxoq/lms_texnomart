<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator soft\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;


/* @var $this backend\components\BackendView */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form soft\kartik\SActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = SActiveForm::begin(); ?>

    <?= "<?= " ?>$form = SForm::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
    <?php
    foreach ($generator->getColumnNames() as $attribute) {
        if (in_array($attribute, $safeAttributes) && !in_array($attribute, ['created_at', 'updated_at'] ) ) {
            echo "          '" . $attribute . "',\n";
        }
    }
    ?>
        ]
    ]); ?>

    <div class="form-group">
        <?= "<?= " ?>SHtml::submitButton() ?>
    </div>

    <?= "<?php " ?>SActiveForm::end(); ?>

</div>
