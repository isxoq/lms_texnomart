<?php

/* @var $this frontend\components\FrontendView */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\helpers\Html;
use soft\adminty\Breadcrumbs;
use yii\helpers\ArrayHelper;

frontend\assets\AdmintyAsset::register($this);
frontend\assets\Fa5Asset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>

    <!-- Favicon icon -->
    <link rel="icon" href="/adminty/assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">

    <?php $this->head() ?>
    <style>
        .left-side{
            height: 100vh;
            overflow-y: scroll;
        }
        /* width */
        .left-side::-webkit-scrollbar {
            width: 0;
        }

        /* Track */
        .left-side::-webkit-scrollbar-track {
            width: 0;
        }

        /* Handle */
        .left-side::-webkit-scrollbar-thumb {
            width: 0;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        <?= $this->render('@frontend/modules/profile/views/layouts/_header'); ?>
        <div class="pcoded-main-container p-2">
            <div class="row">

                <div class="col-md-8">
                    <?= $content ?>
                </div>
                <div class="col-md-4 left-side">
                    <?= $this->render('_start_sidebar'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

