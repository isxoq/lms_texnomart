<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 07.06.2021, 11:22
 */

use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $model \common\models\User|null */
$this->title = $model->fullname;
$this->params['renderBreadcrumb'] = false;
$teacherInfo = $model->findOrCreateTeacherInfo();
$educationStory = $teacherInfo->edcutaionStoryAsArray;
$experienceStory = $teacherInfo->experienceStoryAsArray;
?>


<!-- Inner Page Breadcrumb -->
<section class="inner_page_breadcrumb" style="background: url('<?= settings('site', 'pages_banner') ?>')">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 text-center">
                <div class="breadcrumb_content">
                    <h4 class="breadcrumb_title">
                        <?= e($model->fullname) ?>
                    </h4>
                    <p class="color-white">
                        <?= $teacherInfo->skill ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Team Members -->
<section class="our-team">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="instructor_personal_infor">
                    <div class="instructor_thumb text-center">
                        <img class="img-fluid" src="<?= $model->image ?>" alt="" style="height: 150px">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="instructor_personal_infor">
                            <h4>
                                <?= e($model->fullname) ?>
                            </h4>
                            <p>
                                <?= Yii::$app->formatter->asHtml($model->bio) ?>
                            </p>

                            <?php if (!empty($educationStory)): ?>
                                <h4>Ta'lim</h4>
                                <div class="my_resume_eduarea">
                                    <?php foreach ($educationStory as $key => $expstory): ?>

                                        <div class="content <?= $key == count($educationStory) - 1 ? 'style2' : '' ?>">
                                            <div class="circle"></div>
                                            <h4 class="edu_stats">
                                                <?= e(ArrayHelper::getValue($expstory, 'name')) ?>
                                                <small><?= e(ArrayHelper::getValue($expstory, 'years')) ?></small>
                                            </h4>
                                            <p class="edu_center"><?= e(ArrayHelper::getValue($expstory, 'spec')) ?></p>
                                        </div>

                                    <?php endforeach; ?>
                                </div>
                            <?php endif ?>

                            <?php if (!empty($experienceStory)): ?>
                                <h4>Ish faoliyati</h4>
                                <div class="my_resume_eduarea">
                                    <?php foreach ($experienceStory as $key => $expstory): ?>


                                        <div class="content <?= $key == count($educationStory) - 1 ? 'style2' : '' ?>">
                                            <div class="circle"></div>
                                            <h4 class="edu_stats">
                                                <?= e(ArrayHelper::getValue($expstory, 'name')) ?>
                                                <small><?= e(ArrayHelper::getValue($expstory, 'years')) ?></small>
                                            </h4>
                                            <p class="edu_center"><?= e(ArrayHelper::getValue($expstory, 'position')) ?></p>
                                        </div>

                                    <?php endforeach; ?>
                                </div>
                            <?php endif ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="selected_filter_widget style2 mb30">
                    <div class="siderbar_contact_widget">
                        <h4>Contact</h4>
                        <p>Phone Number</p>
                        <i>+765895465877</i>
                        <p>Email</p>
                        <i>info@alitufan.com</i>
                        <p>Skype</p>
                        <i>alitfn</i>
                        <p>Social Media</p>
                        <ul class="scw_social_icon mb0">
                            <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-google"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="selected_filter_widget style2">
                    <div class="siderbar_contact_widget">
                        <p>Total students</p>
                        <i>102,924</i>
                        <p>Courses</p>
                        <i>22</i>
                        <p>Reviews</p>
                        <i>20,400</i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
