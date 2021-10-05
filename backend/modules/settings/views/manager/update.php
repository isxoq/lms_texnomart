<?php

use soft\helpers\SHtml;
use kartik\widgets\ActiveForm;
use backend\modules\settings\models\Settings;

/* @var $this yii\web\View */
/* @var $model backend\modules\settings\models\Settings */

$this->title = "Asosiy ma'lumotlar - Tahrirlash";

$this->params['breadcrumbs'] = [
    ['label' => "Sayt sozlamalari", 'url' => ['index']],
    ['label' => $model->description, 'url' => ['view', 'id' => $model->id]],
    'Tahrirlash'
];

$langs = array_keys(Yii::$app->site->languages());


?>

<h4 align="center"><?= $model->description ?></h4>

<?php $form = ActiveForm::begin([
    'action' => ['update', 'id' => $model->id]
]); ?>


<?= $form->errorSummary($model) ?>
<div class="row">
    <div class="col-md-6"><?= $form->field($model, "section") ?></div>
    <div class="col-md-6"><?= $form->field($model, "key") ?></div>
</div>
<div class="row">
    <div class="col-md-6"><?= $form->field($model, "description") ?></div>
    <div class="col-md-6"><?= $form->field($model, 'type')->dropDownList(Settings::getTypes()) ?></div>
</div>

<?php if ($model->type == Settings::TYPE_TEXT): ?>

    <?php if ($model->is_multilingual): ?>
        <?php foreach ($langs as $lang): ?>
            <?= $form->field($model, "value[$lang]")->textarea(['rows' => 6])->label("Value[$lang]") ?>
        <?php endforeach ?>
    <?php else: ?>
        <?= $form->field($model, "value")->textarea(['rows' => 6]) ?>
    <?php endif ?>


<?php elseif ($model->type == Settings::TYPE_TEXT_EDITOR): ?>


    <?php if ($model->is_multilingual): ?>
        <?php foreach ($langs as $lang): ?>
            <?= $form->field($model, "value[$lang]")->widget(\dosamigos\ckeditor\CKEditor::class)->label("Value[$lang]") ?>
        <?php endforeach ?>
    <?php else: ?>
        <?= $form->field($model, "value")->widget(\dosamigos\ckeditor\CKEditor::class) ?>
    <?php endif ?>


<?php elseif ($model->type == Settings::TYPE_ELFINDER || $model->type == Settings::TYPE_IMAGE): ?>

    <?php
    $className = "soft\widget\ElfinderInputFile";
    $options = [];
    if ($model->type == Settings::TYPE_IMAGE) {
        $options['filter'] = 'image';
    }

    ?>


    <?php if ($model->is_multilingual): ?>
        <?php foreach ($langs as $lang): ?>
            <?= $form->field($model, "value[$lang]")->widget($className, $options)->label("Value[$lang]") ?>
        <?php endforeach ?>
    <?php else: ?>
        <?= $form->field($model, "value")->widget($className, $options) ?>
    <?php endif ?>


    <?php elseif ($model->type == Settings::TYPE_BOOLEAN): ?>
        <?= $form->field($model, 'value')->checkbox()->label("Is Active") ?>
    <?php else: ?>


    <?php if ($model->is_multilingual): ?>
        <?php foreach ($langs as $lang): ?>
            <?= $form->field($model, "value[$lang]")->textInput()->label("Value[$lang]") ?>
        <?php endforeach ?>
    <?php else: ?>
        <?= $form->field($model, "value") ?>
    <?php endif ?>

<?php endif ?>


<div class="form-group">
    <?= SHtml::submitButton(null, ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>
