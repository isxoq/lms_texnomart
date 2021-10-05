<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 05.05.2021, 9:31
 */

/* @var $this frontend\components\FrontendView */

/* @var $content string */


use yii\helpers\Html;

\frontend\assets\EdumyAsset::register($this);
//\frontend\assets\Fa5Asset::register($this);

//echo \dominus77\sweetalert2\Alert::widget([
//    'useSessionFlash' => true,
//]);

$title = $this->metaTitle == null ? settings('meta', 'meta_title') : $this->metaTitle;
$description = $this->metaDescription == null ? settings('meta', 'meta_description') : $this->metaDescription;
$keywords = $this->metaKeywords == null ? settings('meta', 'meta_keywords') : $this->metaKeywords;
$image = $this->metaImage ?? settings('meta', 'meta_image');
$imageUrl = '';
if (!empty($image)) {
    $imageUrl = Yii::$app->urlManager->createAbsoluteUrl($image);
}

$url = $this->metaUrl ?? Yii::$app->urlManager->createAbsoluteUrl(\yii\helpers\Url::current());

//Google Meta Tags

$this->registerMetaTag(['name' => 'title', 'content' => $title], 'title');
$this->registerMetaTag(['name' => 'description', 'content' => $description], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $keywords], 'keywords');

// Open Graph
$this->registerMetaTag(['property' => 'og:type', 'content' => "website"], 'ogType');
$this->registerMetaTag(['property' => 'og:url', 'content' => $url], 'ogUrl');
$this->registerMetaTag(['property' => 'og:title', 'content' => $title], 'ogTitle');
$this->registerMetaTag(['property' => 'og:description', 'content' => $description], 'ogDescription');
$this->registerMetaTag(['property' => 'og:image', 'content' => $imageUrl], 'ogImage');

// Twitter
$this->registerMetaTag(['property' => "twitter:card", 'content' => "summary_large_image"], "twitterCard");
$this->registerMetaTag(['property' => "twitter:url", 'content' => $url], 'twitterUrl');
$this->registerMetaTag(['property' => "twitter:title", 'content' => $title], 'twitterTitle');
$this->registerMetaTag(['property' => "twitter:description", 'content' => $description], 'twitterDescription');
$this->registerMetaTag(['property' => "twitter:image", 'content' => $imageUrl], 'twitterImage');

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/images/favicon.png" rel="shortcut icon">

        <link rel="apple-touch-icon" type="image/x-icon" href="/tempp/img/apple-touch-icon-57x57-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"
              href="/tempp/img/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
              href="/tempp/img/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
              href="/tempp/img/apple-touch-icon-144x144-precomposed.png">

        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>

        <?php $this->head() ?>

        <?php if (!LOCALHOST): ?>
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=G-LT6TVGFVXZ"></script>
            <script>
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }

                gtag('js', new Date());

                gtag('config', 'G-LT6TVGFVXZ');
            </script>
        <?php endif ?>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>

    <?php $this->beginBody() ?>

    <div class="wrapper">
<!--        <div class="preloader"></div>-->
        <?= $this->render('_header') ?>
        <?= $content ?>
        <?= $this->render('_footer') ?>
        <a class="scrollToHome" href="#"><i class="flaticon-up-arrow-1"></i></a>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>