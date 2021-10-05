<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use soft\helpers\SHtml;
use soft\kartik\SDetailView;

/* @var $this backend\components\BackendView */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <h1><?= "<?= " ?>SHtml::encode($this->title) ?></h1>

    <p>
        <?= "<?= " ?>SHtml::updateButton($model->id) ?>
        <?= "<?= " ?>SHtml::deleteButton(['general/delete<?= "-" ?>model', 'modelClass' => $model->className(), 'id' => $model->id]) ?>
    </p>

    <?= "<?= " ?>SDetailView::widget([
        'model' => $model,
        'attributes' => [
            ['group' => true, 'label' => Yii::t('app' ,'Details')],
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "              '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if ($format== 'text'){
            echo "'".$column->name."', \n";
        }
        else{
            echo "[\n
                    'attribute' => '".$column->name."',\n
                    'format' => '".$format."',\n
                   ]";
        }
    }
}
?>
        ],
    ]) ?>

</div>
