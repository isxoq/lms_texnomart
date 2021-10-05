<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 28.05.2021, 14:34
 */

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this \frontend\components\FrontendView */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$sorts = [

    'latest' => t('Latest courses'),
    'popular' => t('Top courses'),
    'title' => t('Sort by name'),
    '-title' => t('Sort by name in descending order'),
    'price' => t('Sort in ascending order by price'),
    '-price' => t('Sort in descending order by price'),
];

$currentSort = Yii::$app->request->get('sort', 'latest');

?>

<div class="row">

    <div class="col-xl-12">
        <div class="candidate_revew_select style2 text-right mb25">
            <ul>
                <li class="list-inline-item">
                    <select class="selectpicker show-tick custom-sortable-selection">
                        <?php foreach ($sorts as $key => $label): ?>
                            <?= Html::tag('option', $label, ['selected' => $key == $currentSort, 'data' => ['url' => Url::current(['sort' => $key])]]) ?>
                        <?php endforeach; ?>
                    </select>
                </li>
                <li class="list-inline-item">
                    <div class="candidate_revew_search_box course mb30 fn-520">
                        <form class="form-inline my-2 my-lg-0" id="course-search-form">
                            <input class="form-control mr-sm-2" type="search" placeholder="<?= t('Search courses') ?>"
                                   name="title" aria-label="Search" id="custom-search-input" value="<?= Yii::$app->request->get('title') ?>">
                            <button class="btn my-2 my-sm-0" type="submit"><span
                                        class="flaticon-magnifying-glass"></span></button>
                        </form>
                    </div>
                </li>


            </ul>
        </div>
    </div>
</div>