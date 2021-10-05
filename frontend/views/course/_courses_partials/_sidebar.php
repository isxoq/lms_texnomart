<?php

/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 28.05.2021, 14:33
 */

use backend\modules\categorymanager\models\Category;
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Kurs;
use yii\helpers\ArrayHelper;

/* @var $this \frontend\components\FrontendView */


$categories = Category::find()->active()->forceLocalized()->asArray()->all();
$requestCategories = Yii::$app->request->get('cat', []);

$courses = Kurs::find()
    ->active()
    ->select('id,user_id,deleted,status,level')
    ->asArray()
    ->with(['user' => function ($query) {
        return $query->select('id,firstname,lastname');
    }])
    ->all();

$authors = ArrayHelper::map($courses, 'user.id', function ($item) {
    return $item['user']['firstname'] . ' ' . $item['user']['lastname'];
});

$requestAuthors = $this->request->get('author', []);

$siteLevels = Yii::$app->site->kursLevels;

$levels = ArrayHelper::map($courses, 'level', function ($item) use ($siteLevels) {
    return ArrayHelper::getValue($siteLevels, $item['level']);
});

$requestLevels = $this->request->get('level', []);

$sort = $this->request->get('sort');

?>

<?php if (false): ?>
    <div class="selected_filter_widget style2 mb30">
        <div id="accordion" class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#panelBodyfilter" class="accordion-toggle link fz20 mb15" data-toggle="collapse"
                           data-parent="#accordion">Selected Filters</a>
                    </h4>
                </div>
                <div id="panelBodyfilter" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="tags-bar style2">
                            <span>Photoshop<i class="close-tag">x</i></span>
                            <span>Sketch<i class="close-tag">x</i></span>
                            <span>Beginner<i class="close-tag">x</i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<form action="<?= Url::current() ?>" method="get" id="custom-course-filter-form">

    <?php if ($sort): ?>
        <input type="hidden" name="sort" value="<?= $sort ?>">
    <?php endif ?>

    <div class="selected_filter_widget style2 mb30">
        <div id="accordion" class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#panelBodySoftware" class="accordion-toggle link fz20 mb15" data-toggle="collapse"
                           data-parent="#accordion">
                            <?= t('Categories') ?>
                        </a>
                    </h4>
                </div>
                <div id="panelBodySoftware" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="ui_kit_checkbox">
                            <?php foreach ($categories as $category): ?>

                                <?php $id = $category['id'] ?>

                                <div class="custom-control custom-checkbox">
                                    <?= Html::checkbox("cat[]", in_array($id, $requestCategories), [
                                        'id' => "categoryCustomCheck_$id",
                                        'class' => 'custom-control-input',
                                        'value' => $id,
                                    ]) ?>
                                    <?= Html::label(e($category['translation']['title']), "categoryCustomCheck_$id", [
                                        'class' => 'custom-control-label',
                                    ]) ?>
                                </div>

                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="selected_filter_widget style2">
        <div id="accordion" class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#panelBodyAuthors" class="accordion-toggle link fz20 mb15" data-toggle="collapse"
                           data-parent="#accordion">
                            <?= t('Teachers') ?>
                        </a>
                    </h4>
                </div>
                <div id="panelBodyAuthors" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="cl_skill_checkbox">
                            <div class="content ui_kit_checkbox style2 text-left">
                                <?php foreach ($authors as $key => $author): ?>

                                    <div class="custom-control custom-checkbox">

                                        <?= Html::checkbox("author[]", in_array($key, $requestAuthors), [
                                            'id' => "authorCustomCheck_$key",
                                            'class' => 'custom-control-input',
                                            'value' => $key,
                                        ]) ?>

                                        <?= Html::label(e($author), "authorCustomCheck_$key", [
                                            'class' => 'custom-control-label',
                                        ]) ?>

                                    </div>

                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="selected_filter_widget style2 mb30">
        <div id="accordion" class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#panelBodyPrice" class="accordion-toggle link fz20 mb15" data-toggle="collapse"
                           data-parent="#accordion"><?= t('Price') ?></a>
                    </h4>
                </div>
                <div id="panelBodyPrice" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="ui_kit_whitchbox">
                            <div class="custom-control custom-switch">

                                <?= Html::checkbox("paid", $this->request->get('paid', false), [
                                    'id' => "customSwitchPaid",
                                    'class' => 'custom-control-input',
                                    'value' => 1,
                                ]) ?>

                                <?= Html::label(t('Pullik'), "customSwitchPaid", [
                                    'class' => 'custom-control-label',
                                ]) ?>

                            </div>
                            <div class="custom-control custom-switch">

                                <?= Html::checkbox("free", $this->request->get('free', false), [
                                    'id' => "customSwitchFree",
                                    'class' => 'custom-control-input',
                                    'value' => 1,
                                ]) ?>

                                <?= Html::label(t('Free'), "customSwitchFree", [
                                    'class' => 'custom-control-label',
                                ]) ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="selected_filter_widget style2 mb30">
        <div id="accordion" class="panel-group">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#panelBodySkills" class="accordion-toggle link fz20 mb15" data-toggle="collapse"
                           data-parent="#accordion"><?= t('Level') ?></a>
                    </h4>
                </div>
                <div id="panelBodySkills" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="ui_kit_checkbox">

                            <?php foreach ($levels as $key => $level): ?>

                                <div class="custom-control custom-checkbox">
                                    <?= Html::checkbox("level[]", in_array($key, $requestLevels), [
                                        'id' => "levelCustomCheck_$key",
                                        'class' => 'custom-control-input',
                                        'value' => $key,
                                    ]) ?>

                                    <?= Html::label($level, "levelCustomCheck_$key", [
                                        'class' => 'custom-control-label',
                                    ]) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-info" id="course-filter-button">Filterlash</button>
</form>