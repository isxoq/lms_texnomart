<?php
/** @var \dosamigos\fileupload\FileUploadUI $this */
use yii\helpers\Html;






$context = $this->context;
?>
    <!-- The file upload form used as target for the file upload widget -->
<?= Html::beginTag('div', $context->options); ?>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
        <div class="col-lg-12">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="btn btn-success fileinput-button" id="select-file-button">
                <i class="fa fa-plus"></i>
                <span>Videoni tanlash...</span>
                <?= $context->model instanceof \yii\base\Model && $context->attribute !== null
                    ? Html::activeFileInput($context->model, $context->attribute, $context->fieldOptions)
                    : Html::fileInput($context->name, $context->value, $context->fieldOptions);?>

            </span>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
<?= Html::endTag('div');?>
