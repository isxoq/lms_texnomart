<?php

use soft\helpers\SUrl;
use soft\widget\SButton;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use soft\adminty\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\botmanager\models\BotUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bot Users');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="bot-user-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'cols' => require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                ['content' =>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                        ['role' => 'modal-remote', 'title' => 'Create new Bot Users', 'class' => 'btn btn-default']) .
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                        ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Reset Grid']) .
                    '{toggleData}' .
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
//            'bulkButtonsTemplate' => '{send}',
//            'bulkButtons' => [
//                'send' => [
//                    'modal' => true,
//                    'pjax' => false,
//                    'url' => SUrl::to(['send']),
//                    'style' => SButton::STYLE['info'],
//                    'icon' => 'send',
//                    'title' => Yii::t('app', 'Send message'),
//                ],
//            ],
            'responsive' => true,
        ]) ?>
    </div>
</div>
<?php Modal::begin(["id" => "ajaxCrudModal",
    "footer" => "",// always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>
