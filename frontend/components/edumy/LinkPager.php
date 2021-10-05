<?php
/*
 * @author Shukurullo Odilov <shukurullo0321@gmail.com>
 * Date: 28.05.2021, 14:41
 */

namespace frontend\components\edumy;


class LinkPager extends \yii\bootstrap4\LinkPager
{

    public $options = ['tag' => 'div', 'class' => 'mbp_pagination'];
    public $listOptions = ['class' => ['page_navigation']];
    public $nextPageLabel = '<span class="flaticon-right-arrow-1"></span>';
    public $prevPageLabel = '<span class="flaticon-left-arrow"></span>';

}