<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 28.05.2021, 17:09
 */

/* @var $this \frontend\components\FrontendView */
/* @var $model \backend\modules\kursmanager\models\KursComment|\frontend\models\Kurs */
/* @var $relatedCourses mixed|null */
?>


<div class="feature_course_widget csv1" style="padding-top: 0">

    <img src="<?= $model->kursImage ?>" alt="">
    
    <ul class="list-group">
        <?php foreach ($model->featuresList as $feature): ?>

            <li class="">
                <span>
                    <?= $feature['icon'] ?> <?= $feature['label'] ?>:
                </span>
                <span class="float-right">
                     <b><?= $feature['value'] ?> </b>
                </span>
            </li>

        <?php endforeach; ?>
        <li class="d-flex justify-content-between align-items-center">
            <span>
               <i class="flaticon-award"></i>
                <b><?= t('Certificate of Completion') ?></b>
            </span>

        </li>
    </ul>
    <div class="price">
        <span></span>
        <?= $model->formattedPrice ?>

        <?php if (!$model->is_free && $model->hasDiscount): ?>
            <br><small>
                <del><?= $model->formattedOldPrice ?></del>
            </small>
        <?php endif ?>

    </div>
    <div class="" style="display: flex; justify-content: space-around">
        <?= $model->getCardButton(['class' => 'cart_btnss',  'style' => ['width' => '100%', 'text-align' => 'center'] ]) ?>
    </div>
</div>

<?php if (false): //todo tags ?>
    <div class="blog_tag_widget csv1">
        <h4 class="title">Tags</h4>
        <ul class="tag_list">
            <li class="list-inline-item"><a href="#">Photoshop</a></li>
            <li class="list-inline-item"><a href="#">Sketch</a></li>
            <li class="list-inline-item"><a href="#">Beginner</a></li>
            <li class="list-inline-item"><a href="#">UX/UI</a></li>
        </ul>
    </div>
<?php endif ?>