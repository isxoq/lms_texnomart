<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;
use unclead\multipleinput\MultipleInput;

/* @var $this backend\components\BackendView */
/* @var $model frontend\modules\teacher\models\Kurs */
/* @var $form soft\kartik\SActiveForm */


?>


<?php $form = SActiveForm::begin([
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
                            <?= $model->isNewRecord ? "Yangi kurs qo'shish" : $model->title ?>
                            <p style="float: right">
                                <?= SHtml::submitButton(fa('save') . ' Saqlash', [
                                    'class' => 'btn btn-outline-success btn-shadow-primary'
                                ]) ?>
                                <?= a('Bekor qilish', 'index', ['class' => 'btn btn-outline-danger']) ?>
                            </p>
                        </div>

                        <ul class="nav nav-tabs md-tabs" role="tablist">

                            <li class="nav-item" style=" width: 14%!important;">
                                <a class="nav-link active" id="asosiy-tab" data-toggle="tab" href="#asosiy" role="tab"
                                   aria-controls="tab-v-1" aria-selected="false">Asosiy</a>
                                <div class="slide" style="width: 14%!important;"></div>
                            </li>
                            <li class="nav-item" style=" width: 14%!important;">
                                <a class="nav-link" id="talablar-tab" data-toggle="tab" href="#talablar" role="tab"
                                   aria-controls="tab-v-2" aria-selected="false">Talablar</a>
                                <div class="slide" style="width: 14%!important;"></div>
                            </li>
                            <li class="nav-item" style=" width: 14%!important;">
                                <a class="nav-link" id="foydalar-tab" data-toggle="tab" href="#foydalar" role="tab"
                                   aria-controls="tab-v-3" aria-selected="true">Foydalar</a>
                                <div class="slide" style="width: 14%!important;"></div>
                            </li>
                            <li class="nav-item" style=" width: 14%!important;">
                                <a class="nav-link" id="narxlash-tab" data-toggle="tab" href="#narxlash" role="tab"
                                   aria-controls="tab-v-3" aria-selected="true">Narxlash</a>
                                <div class="slide" style="width: 14%!important;"></div>
                            </li>
                            <li class="nav-item" style=" width: 14%!important;">
                                <a class="nav-link" id="media-tab" data-toggle="tab" href="#media" role="tab"
                                   aria-controls="tab-v-3" aria-selected="true">Media</a>
                                <div class="slide" style="width: 14%!important;"></div>
                            </li>
                            <li class="nav-item" style=" width: 14%!important;">
                                <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab"
                                   aria-controls="tab-v-3" aria-selected="true">SEO</a>
                                <div class="slide" style="width: 14%!important;"></div>
                            </li>
                            <!-- <li class="nav-item" style=" width: 14%!important;">
                                 <a class="nav-link" id="finish-tab" data-toggle="tab" href="#finish" role="tab"
                                    aria-controls="tab-v-3" aria-selected="true">Yakunlash</a>
                                 <div class="slide" style="width: 14%!important;"></div>
                             </li>-->
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content card-block">

                            <div class="tab-pane fade active show" id="asosiy" role="tabpanel"
                                 aria-labelledby="asosiy-tab">

                                <?= SForm::widget([
                                    'model' => $model,
                                    'form' => $form,
                                    'attributes' => [
                                        'title',
                                        'short_description:textarea',
                                        'description' => [
                                            'type' => SForm::INPUT_WIDGET,
                                            'widgetClass' => \dosamigos\ckeditor\CKEditor::class,
                                        ],
                                        'category_id:select2' => [
                                            'options' => [
                                                'data' => \yii\helpers\ArrayHelper::map(\backend\modules\categorymanager\models\SubCategory::getAll(), 'id', 'title', 'category.title'),
                                            ]
                                        ],
                                        'level:select2' => [
                                            'options' => [
                                                'data' => Yii::$app->site->getKursLevels(),
                                            ]
                                        ],

                                        'duration:select2' => [
                                            'options' => [
                                                'data' => Yii::$app->site->getKursDurations(),
                                            ]
                                        ],
                                        'language:select2' => [
                                            'options' => [
                                                'data' => Yii::$app->site->getKursLanguages(),
                                            ],
                                        ],
                                        /*'is_best' => [
                                            'type' => SForm::INPUT_CHECKBOX,
                                            'label' => 'Ushbu kursni eng yaxshi kurs sifatida belgilash',
                                        ],*/
                                    ]
                                ]); ?>


                            </div>
                            <div class="tab-pane fade" id="talablar" role="tabpanel" aria-labelledby="talablar-tab">


                                <?= $form->field($model, 'requirements')->widget(MultipleInput::className(), [

                                    'data' => json_decode($model->requirements),
                                    'min' => 0, // should be at least 2 rows
                                    'allowEmptyList' => false,
                                    'sortable' => true,
                                    'addButtonOptions' => ['class' => 'btn btn-success btn-sm'],
                                    'removeButtonOptions' => ['class' => 'btn btn-danger btn-sm'],
                                    'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME,
                                    'enableGuessTitle' => true,
                                ])
                                    ->label(false); ?>

                            </div>
                            <div class="tab-pane fade" id="foydalar" role="tabpanel" aria-labelledby="foydalar-tab">
                                <?= $form->field($model, 'benefits')->widget(MultipleInput::className(), [
                                    'data' => json_decode($model->benefits),
                                    'min' => 0, // should be at least 2 rows
                                    'allowEmptyList' => false,
                                    'sortable' => true,
                                    'addButtonOptions' => ['class' => 'btn btn-success btn-sm'],
                                    'removeButtonOptions' => ['class' => 'btn btn-danger btn-sm'],
                                    'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME,
                                    'enableGuessTitle' => true,
                                ])
                                    ->label(false); ?>

                            </div>
                            <div class="tab-pane fade" id="narxlash" role="tabpanel" aria-labelledby="narxlash-tab">
                                <?= SForm::widget([
                                    'model' => $model,
                                    'form' => $form,
                                    'attributes' => [
                                        'is_free:checkbox' => [
                                            'label' => 'Bepul sifatida belgilash',
                                        ],
                                        'price:widget' => [
                                            'widgetClass' => \soft\widget\SumMaskedInput::class,
                                            'fieldConfig' => [
                                                'enableClientValidation' => false,
                                            ],
                                        ],
                                        'old_price:widget' => [
                                            'widgetClass' => \soft\widget\SumMaskedInput::class,
                                            'fieldConfig' => [
                                                'enableClientValidation' => false,
                                            ],
                                        ],
                                        /*'free_duration' => [
                                            'type' => SForm::INPUT_DROPDOWN_LIST,
                                            'items' => Yii::$app->site->getKursFreeDurations()
                                        ]*/

                                    ]
                                ]); ?>
                            </div>
                            <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
                                <?= SForm::widget([
                                    'model' => $model,
                                    'form' => $form,
                                    'attributes' => [
                                        /*'preview_host:select2' => [
                                            'options' => [
                                                'data' => Yii::$app->site->getKursProviders()
                                            ]
                                        ],*/
                                        'preview_link' => [
                                            'options' => [
                                                'placeholder' => 'E.g: https://www.youtube.com/watch?v=oBtf8Yglw2w',
                                            ]
                                        ],
                                        'image:widget' => [
//                                            'prepend' => SHtml::img($model->getThumbUploadUrl('image'), ['class' => 'img-thumbnail']),
                                            'widgetClass' => 'kartik\widgets\FileInput',
                                            'label' => "Rasm (370x370)",
                                            'options' => [
                                                'options' => [
                                                    'accept' => 'image/*',
                                                ],
                                                'pluginOptions' => [
                                                    'initialPreview' => [
                                                        $model->getThumbUploadUrl('image')
                                                    ],
                                                    'showCaption' => true,
                                                    'showRemove' => true,
                                                     'initialCaption' => $model->image,
                                                    'showUpload' => false,
                                                    'initialPreviewAsData' => true,
                                                    'overwriteInitial' => true,
                                                    'maxFileSize' => 2800
                                                ]
                                            ],


                                        ],
                                    ]
                                ]); ?>
                            </div>
                            <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                <?= SForm::widget([
                                    'model' => $model,
                                    'form' => $form,
                                    'attributes' => [
                                        'meta_keywords',
                                        'meta_description:textarea',
                                    ]
                                ]); ?>
                            </div>
                            <div class="tab-pane fade" id="finish" role="tabpanel" aria-labelledby="finish-tab">
                                <div class="form-group" style="text-align: center">
                                    <p>Bir qadam qoldi!</p>
                                    <?= SHtml::submitButton('Saqlash', [
                                        'class' => 'btn btn-primary btn-default btn-squared btn-shadow-primary'
                                    ]) ?>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Material tab card end -->
    </div>
</div>

<?php SActiveForm::end(); ?>








