<?php

use soft\helpers\SHtml;
use \kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use frontend\modules\teacher\models\Lesson;

/* @var $this frontend\components\FrontendView */
/* @var $section frontend\modules\teacher\models\Section */
/* @var $lessons frontend\modules\teacher\models\Lesson[] */

$this->title = $section->title ." - Mavzularni tahrirlash";

$this->params['breadcrumbs'][] = ['label' => 'Kurs boshqaruvchisi', 'url' => ['/teacher']];
$this->params['breadcrumbs'][] = ['label' => $section->kurs->title, 'url' => ['/teacher/kurs/view', 'id' => $section->kurs_id]];
$this->params['breadcrumbs'][] = ['label' => "Bo'limlar", 'url' => ['/teacher/kurs/sections', 'id' => $section->kurs_id]];
$this->params['breadcrumbs'][] = ['label' => $section->title, 'url' => ['view', 'id' => $section->id]];
$this->params['breadcrumbs'][] = ['label' => "Mavzular", 'url' => ['lessons', 'id' => $section->id]];
$this->params['breadcrumbs'][] = "Mavzularni tahrirlash";

?>

<div id="panel-option-values" class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
        <p>
        <div class="float-right" style="margin-bottom:10px">
            <a class="btn btn-outline-danger" href="<?= to(['lessons', 'id' => $section->id]) ?>">
                <i class="fa fa-arrow-left"></i> Ortga qaytish
            </a>
<!--            <button type="submit" class="btn btn-outline-success btn-shadow-primary"><i class="fa fa-save"></i> Saqlash</button>-->
        </div>
        </p>
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody' => '.form-options-body',
            'widgetItem' => '.form-options-item',
            'min' => 1,
            'insertButton' => '.add-item',
            'deleteButton' => '.delete-item',
            'model' => $lessons[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'title',
                'status',
                'type'
            ],
        ]); ?>

        <table class="table  table-condensed margin-b-none">
            <thead>
            <tr>
                <th style="width: 90px; text-align: center"></th>
                <th style="width: 50px; text-align: center">#</th>
                <th class="required">Mavzu nomi</th>
<!--                <th class="required">Xulosa</th>-->
                <th class="required">Dars turi</th>
                <th class="required">Status</th>
                <th style="width: 90px; text-align: center">Actions</th>
            </tr>
            </thead>
            <tbody class="form-options-body">
            <?php foreach ($lessons as $index => $lesson): ?>
                <tr class="form-options-item">
                    <td class="sortable-handle text-center vmiddle" style="cursor: move;">
                        <?= isBs4() ? fas('arrows-alt') : fa('arrows') ?>
                    </td>
                    <td class="vmiddle center index"><?= $index + 1 ?></td>
                    <td class="vmiddle">
                        <?= $form->field($lesson, "[{$index}]title")->label(false)->textInput(['maxlength' => 255]); ?>
                        <?php if (!$lesson->isNewRecord): ?>
                            <?= SHtml::activeHiddenInput($lesson, "[{$index}]id"); ?>
                        <?php endif; ?>
                    </td>

                    <td class="vmiddle">
                        <?= $form->field($lesson, "[{$index}]type")->label(false)->dropDownList(Lesson::getTypesList()); ?>
                    </td>

                    <td class="vmiddle">
                        <?= $form->field($lesson, "[{$index}]status")->label("Faol")->checkbox(); ?>
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
