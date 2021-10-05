<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this frontend\components\FrontendView */
/* @var $data array */

$this->title = t('Faq page title');

$this->registerCss(' .mm-menu.mm-offcanvas.mm-opened {
    z-index: 9;
}');

?>

    <!-- Our FAQ -->
    <section class="our-faq">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-xl-4">
                    <div class="faq_question_widget">
                        <div class="widget_list">
                            <ul class="list_details">
                                <?php foreach ($data as $key => $cat): ?>

                                    <li>
                                        <a href="#" class="faq-category-navigation"
                                           data-faq-category="faq-category-<?= $cat['id'] ?>">
                                            <?= e($cat['translation']['title']) ?>
                                        </a>
                                    </li>

                                <?php endforeach ?>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-xl-8">
                    <?php foreach ($data as $faqCatKey => $faqCat): ?>
                        <h4 class="fz20 mb30 faq-category-<?= $faqCat['id'] ?>">
                            <?= e($faqCat['translation']['title']) ?>
                        </h4>
                        <div class="faq_according">
                            <div id="accordion" class="panel-group">

                                <?php foreach ($faqCat['faqs'] as $faqKey => $faq): ?>

                                    <?php $isOpen = $faqCatKey == 0 && $faqKey == 0 ?>

                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a href="#faq_<?= $faq['id'] ?>" class="accordion-toggle link fz20 mb15"
                                                   data-toggle="collapse" data-parent="#accordion">
                                                    <?= e($faq['translation']['title']) ?>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="faq_<?= $faq['id'] ?>"
                                             class="panel-collapse collapse <?= $isOpen ? 'show' : '' ?>">
                                            <div class="panel-body">

                                                <p class="mb25"> <?= Yii::$app->formatter->asHtml($faq['translation']['text']) ?></p>

                                            </div>
                                        </div>
                                    </div>


                                <?php endforeach; ?>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </section>

<?php

$js = <<<JS
$(document).on('click', '.faq-category-navigation', function(e) {
    
    e.preventDefault()
    let categoryClass = $(this).data('faq-category')
    let category = $('.' + categoryClass )
    console.log(categoryClass)
      $("html").animate({
                scrollTop: category.offset().top - 100
            }, 1000);        
})
JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>