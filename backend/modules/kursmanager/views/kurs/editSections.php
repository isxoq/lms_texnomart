<?php

use soft\helpers\SHtml;
use \kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\teacher\models\Kurs */
/* @var $sections frontend\modules\teacher\models\Section[] */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => "Bo'limlar", 'url' => ['sections', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Bo'limlarni boshqarish";

?>


<div id="panel-option-values" class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
        <div class="float-right" style="margin-bottom:10px">
            <a class="btn btn-outline-danger" href="<?= to(['kurs/sections', 'id' => $model->id]) ?>">
                <i class="fa fa-arrow-left"></i> Ortga qaytish
            </a>
<!--            <button type="submit" class="btn btn-outline-success btn-shadow-primary"><i class="fa fa-save"></i> Saqlash</button>-->
        </div>
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody' => '.form-options-body',
            'widgetItem' => '.form-options-item',
            'min' => 1,
            'insertButton' => '.add-item',
            'deleteButton' => '.delete-item',
            'model' => $sections[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'title',
                'status',
            ],
        ]); ?>

        <table class="table  table-condensed margin-b-none">
            <thead>
            <tr>
                <th style="width: 90px; text-align: center"></th>
                <th style="width: 50px; text-align: center">#</th>
                <th class="required">Bo'lim nomi</th>
                <th class="required">Status</th>
                <th style="width: 90px; text-align: center">Actions</th>
            </tr>
            </thead>
            <tbody class="form-options-body">
            <?php foreach ($sections as $index => $section): ?>
                <tr class="form-options-item">
                    <td class="sortable-handle text-center vmiddle" style="cursor: move;">
                        <?= isBs4() ? fas('arrows-alt') : fa('arrows') ?>
                    </td>
                    <td class="vmiddle center index"><?= $index + 1 ?></td>
                    <td class="vmiddle">
                        <?= $form->field($section, "[{$index}]title")->label(false)->textInput(['maxlength' => 255]); ?>
                        <?php if (!$section->isNewRecord): ?>
                            <?= SHtml::activeHiddenInput($section, "[{$index}]id"); ?>
                        <?php endif; ?>
                    </td>

                    <td class="vmiddle">
                        <?= $form->field($section, "[{$index}]status")->label("Faol")->checkbox(); ?>
                    </td>
                    <td class="text-center vmiddle">
                        <button type="button" style="display: none" class="delete-item btn btn-danger btn-sm">
                            <?= fa('times') ?>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3">
                    <div class="center">
                        <button type="button" class="add-item btn btn-primary"><span class="fa fa-plus"></span> Yangi
                            qo'shish
                        </button>
                        <button type="submit" class="btn btn-success btn-shadow-primary"><i class="fa fa-save"></i> Saqlash</button>

                    </div>
                </td>
            </tr>
            </tfoot>
        </table>
        <?php DynamicFormWidget::end(); ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$js = <<<JS

var fixHelperSortable = function(e, ui) {
ui.children().each(function() {
    $(this).width($(this).width());
    });
    return ui;
};

$(".form-options-body").sortable({
    items: "tr",
    cursor: "move",
    opacity: 0.6,
    axis: "y",
    handle: ".sortable-handle",
    helper: fixHelperSortable,
    update: function(ev){
        $(".dynamicform_wrapper").yiiDynamicForm("updateContainer");
        reOrder()       
    }
}).disableSelection();

$('.dynamicform_wrapper').on('afterInsert', function(e, item) {
    $('.form-options-item').last().find('input[type=text]').val('')
    $('.form-options-item').last().find('input[type=hidden]').val('')
    $('.form-options-item').last().find('.delete-item').show()
    reOrder()
 });

$('.dynamicform_wrapper').on('afterDelete', function(e, item) {
    reOrder()
 });

function reOrder()
{
    $('.index').each(function(index) {
        $(this).html(index + 1);
    });
}

JS;

JuiAsset::register($this);
$this->registerJs($js);
?>
