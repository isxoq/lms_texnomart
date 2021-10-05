<?php

use common\models\User;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\profile\models\PersonalDataForm */
/* @var $upload \soft\helpers\UploadHelper */

$this->title = "Shaxsiy ma'lumotlarni tahrirlash";
$this->params['breadcrumbs'][] = ['label' => t('Personal cabinet'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $form = \soft\kartik\SActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]); ?>
<div class="row">
    <div class="col-md-6">
        <?= \soft\form\SForm::widget([
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'lastname',
                'firstname',
                'position',
                'age',
                'gender:radioList' => [
                    'items' => User::genders(),
                ],
                'education_level_id:dropdownList' => [
                    'items' => map(\backend\models\EducationLevel::find()->active()->all(), 'id', 'name'),
                    'options' => [
                        'prompt' => "Tanlang"
                    ]
                ],
                'address:textarea',
                'bio:ckeditor' => [
                    'options' => [
                        'editorOptions' => [
                            'preset' => 'basic',
                            'removeButtons' => 'Subscript,Superscript,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Image'
                        ]
                    ]
                ],
            ],
        ]); ?>
    </div>
    <div class="col-md-6">
        <?= \soft\form\SForm::widget([
            'model' => $upload,
            'form' => $form,
            'attributes' => [

                'file:widget' => [
                    'widgetClass' => 'kartik\widgets\FileInput',
                    'label' => "Rasm",
                    'options' => [
                        'options' => [
                            'accept' => 'image/*',
                        ],
                        'pluginOptions' => [
                            'initialPreview' => [
                                $model->avatar
                            ],
                            'showCaption' => true,
                            'showRemove' => true,
                            'initialCaption' => $model->avatar,
                            'showUpload' => false,
                            'initialPreviewAsData' => true,
                            'overwriteInitial' => true,
                            'maxFileSize' => 2800,
                            'dropZoneTitle' => 'Rasmni yuklang',
                            'msgPlaceholder' => 'Rasmni tanlang',
                        ]
                    ],


                ],

            ],
        ]); ?>
    </div>
</div>
<div class="form-group">
    <?= \soft\helpers\SHtml::submitButton() ?>
</div>

<?php \soft\kartik\SActiveForm::end(); ?>

