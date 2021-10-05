<?php

namespace backend\modules\botmanager\models;

class SendMessage extends \yii\base\Model
{
    public $text;

    public function rules()
    {
        return [
            [['text'], 'required']
        ];
    }
}