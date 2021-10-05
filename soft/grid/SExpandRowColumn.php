<?php


namespace soft\grid;


use kartik\grid\ExpandRowColumn;
use kartik\grid\GridView;

class SExpandRowColumn extends ExpandRowColumn
{


//    public  $expandIcon = '<span class="fa fa-plus-square-o"></span>';

//    public  $collapseIcon = '<span clas="fa fa-minus"></span>';

    public  $format = 'raw';

    public  $value;

    public $expandOneOnly = true;

    public function init()
    {

        if ($this->value == null){

            $this->value = function (){
                    return GridView::ROW_COLLAPSED;
            };

        }
        parent::init();
    }

}