<?php
/**
 * @var $this View
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 */

use yii\helpers\Html;
use yii\web\View;

?>
<?php echo Html::beginTag('div', $this->context->options); ?>
<!-- Gallery Toolbar -->
<div class="btn-toolbar" style="padding:4px">
    <div class="btn-group" style="display: inline-block;">
        <div class="btn btn-success btn-file" style="display: inline-block">
            <i class="fas fa-plus"></i> <?php echo Yii::t('app', 'Add'); ?>
            <input type="file" name="gallery-image" class="afile" accept="image/*" multiple="multiple"/>
        </div>
    </div>
    <div class="btn-group" style="display: inline-block;">

        <label class="btn btn-default">
            <input type="checkbox" style="margin-right: 4px;" class="select_all"><?php echo Yii::t(
                'galleryManager/main',
                'Select all'
            ); ?>
        </label>
        <div class="btn btn-default disabled edit_selected">
            <i class="fas fa-edit"></i> <?php echo Yii::t('galleryManager/main', 'Edit'); ?>
        </div>
        <div class="btn btn-default disabled remove_selected">
            <i class="fas fa-times"></i> <?php echo Yii::t('app', 'Remove'); ?>
        </div>
    </div>
</div>
<hr/>
<!-- Gallery Photos -->
<div class="sorter">
    <div class="images"></div>
    <br style="clear: both;"/>
</div>


<!-- Modal -->
<div class="editor-modal modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= Yii::t("app", 'Update') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary  save-changes">
                    <i class="fas fa-save"></i> <?= Yii::t("app", 'Save') ?>
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <?= Yii::t("app", 'Close') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="overlay">
    <div class="overlay-bg">&nbsp;</div>
    <div class="drop-hint">
        <span class="drop-hint-info"><?php echo Yii::t('galleryManager/main', 'Drop Files Here…') ?></span>
    </div>
</div>
<div class="progress-overlay">
    <div class="overlay-bg">&nbsp;</div>
    <!-- Upload Progress Modal-->
    <div class="modal progress-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><?php echo Yii::t('galleryManager/main', 'Uploading images…') ?></h3>
                </div>
                <div class="modal-body">
                    <div class="progress ">
                        <div class="progress-bar progress-bar-info progress-bar-striped active upload-progress"
                             role="progressbar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo Html::endTag('div'); ?>
