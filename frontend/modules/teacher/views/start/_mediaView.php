<?php

use common\components\virtualdars\VideojsWidget;

/* @var $this frontend\components\FrontendView */
/* @var $lesson backend\modules\kursmanager\models\Lesson */
/* @var $nextIsOpen bool */

?>

<?= VideojsWidget::widget([
    'model' => $lesson,
    'registerEvents' => false,
]);
?>

