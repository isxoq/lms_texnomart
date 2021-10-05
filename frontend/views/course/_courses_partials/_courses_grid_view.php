<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 03.06.2021, 13:41
 */

?>



    <?php foreach ($dataProvider->models as $model): ?>
        <div class="col-lg-6 col-xl-4">
            <?= $this->render('_course_card', ['model' => $model]) ?>
        </div>
    <?php endforeach; ?>
    <div class="col-lg-12 pagination-links-container">
        <?= \frontend\components\edumy\LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>


