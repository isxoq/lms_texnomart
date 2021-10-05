<?php


namespace soft\widget;


use yii\widgets\MaskedInput;

class SumMaskedInput extends MaskedInput
{

    public $clientOptions = [
        'alias' => 'currency',
        'digits' => 0,
        'suffix' => ' sum',
        'radixPoint' => '.',
        'removeMaskOnSubmit' => true,
        'prefix' => '',
        'rightAlign' => false,
    ];

}