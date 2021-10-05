<?php

use soft\helpers\SHtml;
use soft\kartik\SActiveForm;
use soft\form\SForm;


/* @var $this backend\components\BackendView */
/* @var $model backend\modules\categorymanager\models\Category */
/* @var $form soft\kartik\SActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-default card-md mb-4">
            <div class="card-header">
                <h6><?= $model->title ?></h6>
            </div>
            <div class="card-body">
                <?php $form = SActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="basic-form-wrapper">
                            <?= SForm::widget([
                                'model' => $model,
                                'form' => $form,
                                'attributes' => [
                                    'title',
                                    'status',
                                    'image:elfinder' => [
                                            'hint' => "Rasm o'lchami: 800x533"
                                    ]
                                ],

                            ]); ?>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <?= SHtml::submitButton() ?>
                </div>
                <?php SActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>