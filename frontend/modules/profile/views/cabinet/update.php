<?php

use common\models\User;
use soft\helpers\SHtml;
use soft\form\SForm;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Json;

/* @var $this frontend\components\FrontendView */
/* @var $model frontend\modules\profile\models\PersonalDataForm */
/* @var $upload \soft\helpers\UploadHelper */
/* @var $teacherInfo \backend\modules\usermanager\models\TeacherInfo */

$this->title = "Shaxsiy ma'lumotlarni tahrirlash";
$this->params['breadcrumbs'][] = ['label' => t('Personal cabinet'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCss('
    .form-group label{
        font-weight:bold;
    }
');

$isTeacher = user('isTeacher');


?>

<?php $form = \soft\kartik\SActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]); ?>

<div class="row">
    <div class="col-sm-12">
        <!-- Material tab card start -->
        <div class="card">
            <div class="card-block">
                <div class="row m-b-30">
                    <div class="col-lg-12">
                        <!-- Nav tabs -->
                        <div class="sub-title" style="height: 50px">
                            <?= $this->title ?>
                            <p style="float: right">
                                <?= SHtml::submitButton(fa('save') . ' Saqlash', [
                                    'class' => 'btn btn-outline-success btn-shadow-primary'
                                ]) ?>
                                <?= a('Bekor qilish', 'index', ['class' => 'btn btn-outline-danger']) ?>
                            </p>
                        </div>
                        <ul class="nav nav-tabs md-tabs" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link active" id="asosiy-tab" data-toggle="tab" href="#asosiy" role="tab"
                                   aria-controls="tab-v-1" aria-selected="false">Asosiy</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="addition-tab" data-toggle="tab" href="#addition" role="tab"
                                   aria-controls="tab-v-2" aria-selected="false">Qo'shimcha</a>
                                <div class="slide"></div>
                            </li>

                            <?php if ($isTeacher): ?>
                                <li class="nav-item">
                                    <a class="nav-link" id="education-tab" data-toggle="tab" href="#education"
                                       role="tab"
                                       aria-controls="tab-v-3" aria-selected="true">Ta'lim</a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="job-history-tab" data-toggle="tab" href="#job-history"
                                       role="tab"
                                       aria-controls="tab-v-3" aria-selected="true">Ish faoliyati</a>
                                    <div class="slide"></div>
                                </li>
                            <?php endif ?>

                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content card-block">
                            <div class="tab-pane fade active show" id="asosiy" role="tabpanel"
                                 aria-labelledby="asosiy-tab">
                                <?= \soft\form\SForm::widget([
                                    'model' => $model,
                                    'form' => $form,
                                    'columns' => 2,
                                    'attributes' => [
                                        'lastname',
                                        'firstname',
                                        'position',
                                        'age',
                                        'address:textarea',

                                        'gender:radioList' => [
                                            'items' => User::genders(),
                                        ],


                                    ],
                                ]); ?>
                            </div>
                            <div class="tab-pane fade" id="addition" role="tabpanel" aria-labelledby="addition-tab">

                                <?= \soft\form\SForm::widget([
                                    'model' => $model,
                                    'form' => $form,
                                    'attributes' => [
                                        'education_level_id:dropdownList' => [
                                            'items' => map(\backend\models\EducationLevel::find()->active()->all(), 'id', 'name'),
                                            'options' => [
                                                'prompt' => "Tanlang"
                                            ]
                                        ],
                                        'bio:ckeditor' => [
                                            'options' => [
                                                'editorOptions' => [
                                                    'preset' => 'standart',
                                                    'removeButtons' => 'Subscript,Superscript,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Image'
                                                ]
                                            ]
                                        ],
                                    ]
                                ]); ?>
                                <div class="row">
                                    <?php if ($isTeacher): ?>
                                        <div class="col-md-6">
                                            <?= \soft\form\SForm::widget([
                                                'model' => $teacherInfo,
                                                'form' => $form,
                                                'attributes' => [

                                                    'skill' => [
                                                        'options' => [
                                                            'placeholder' => 'Full stack web developer',
                                                        ]
                                                    ],
                                                    'telegram',
                                                    'facebook',
                                                    'youtube',
                                                    'instagram'

                                                ],
                                            ]); ?>
                                        </div>
                                    <?php endif; ?>

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


                            </div>
                            <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">


                                <?= $form->field($teacherInfo, 'education_story')->widget(MultipleInput::className(), [

                                    'data' => Json::decode($teacherInfo->education_story),
                                    'min' => 0, // should be at least 2 rows
                                    'columns' => [
                                        [
                                            'name' => 'name',
                                            'title' => "Nomi",
                                            'options' => [
                                                'placeholder' => "TATU Farg'ona filiali",
                                            ]
                                        ],
                                        [
                                            'name' => 'spec',
                                            'title' => "Yo'nalish",
                                            'options' => [
                                                'placeholder' => "Kompyuter injiniringi (bakalavr)",
                                            ]
                                        ],
                                        [
                                            'name' => 'years',
                                            'title' => "Yillar",
                                            'options' => [
                                                'placeholder' => "2013 - 2017 yillar",
                                            ]
                                        ],
                                    ],
                                    'allowEmptyList' => false,
                                    'sortable' => true,
                                    'addButtonOptions' => ['class' => 'btn btn-success btn-sm'],
                                    'removeButtonOptions' => ['class' => 'btn btn-danger btn-sm'],
                                    'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME,
                                    'enableGuessTitle' => true,
                                ])
                                    ->label(false); ?>

                            </div>
                            <div class="tab-pane fade" id="job-history" role="tabpanel"
                                 aria-labelledby="job-history-tab">

                                <?= $form->field($teacherInfo, 'experience_story')->widget(MultipleInput::className(), [

                                    'data' => Json::decode($teacherInfo->experience_story),
                                    'min' => 0, // should be at least 2 rows
                                    'columns' => [
                                        [
                                            'name' => 'name',
                                            'title' => "Ish joyi",
                                            'options' => [
                                                'placeholder' => "iTeach Software",
                                            ]
                                        ],
                                        [
                                            'name' => 'position',
                                            'title' => "Lavozim",
                                            'options' => [
                                                'placeholder' => "Yii2 web developer",
                                            ]
                                        ],
                                        [
                                            'name' => 'years',
                                            'title' => "Yillar",
                                            'options' => [
                                                'placeholder' => "2020 - h.v.",
                                            ]
                                        ],
                                    ],
                                    'allowEmptyList' => false,
                                    'sortable' => true,
                                    'addButtonOptions' => ['class' => 'btn btn-success btn-sm'],
                                    'removeButtonOptions' => ['class' => 'btn btn-danger btn-sm'],
                                    'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME,
                                    'enableGuessTitle' => true,
                                ])
                                    ->label(false); ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Material tab card end -->
</div>

<?php \soft\kartik\SActiveForm::end(); ?>

